<?php

use Wrench\Application\Application;
use Wrench\Application\NamedApplication;



class Message
{

	protected $type;
	protected $data;

	public function __construct($type, $data, $channel=0) {
		$this->channel=$channel;
		$this->type=$type;
		$this->data=$data;
	}


	public function __toString() {

		return json_encode(
			array(
				'channel'=>$this->channel,
				'type'=>$this->type,
				'data'=>$this->data,
				'time'=>time()
			)
		);
	}
}



class GreenTchat extends Application
{

protected $lastTimestamp = null;
    /**
     * @see Wrench\Application.Application::onData()
     */

	protected $clients=array();


    public function onDisconnect($client) {
		unset($this->clients[$client->getId()]);
		echo "\ndisconnected : ".$client->getId()."\n\n";


		$this->sendUserList();

    }



	//reception d'un message client
    public function onData($data, $client) {


		print_r($data->buffer);

		$json=json_encode(array(
			'messageType'=>'message',
			'content'=>$data->buffer
		));

		foreach($this->clients as $client) {
			$client->send($json);
		}



		//$this->handleMessage($data, $client);
    }


    public function onUpdate() {

		//on prépare un message de type "time"
		$json=json_encode(array(
			'messageType'=>'time',
			'content'=>microtime(true)
		));

		foreach($this->clients as $client) {
			$client->send($json);
		}

    }


		//cette fonction est appelée chaque fois qu'un client se connecte
    	public function onConnect($newClient) {


		//on enregistre le nouveau client (on utilise l'id du client comme clef d'enregistrement
        $this->clients[$newClient->getId()]=$newClient;

		//on prépare la liste des clients à envoyer
		$clientList=array_keys($this->clients);

		//on encode en json la liste des clients
		//et on enregistre aussi le type de message
		$jsonData=json_encode(array(
			'messageType'=>'connection',
			'content'=>$clientList,
		));

		//on envoie à tous les clients la listes des clients

		foreach($this->clients as $client) {
			$client->send($jsonData);
		}


    }

	public function handleMessage($data, $client) {
		$data=json_decode($data, true);

		$type=$data['type'];

		if(method_exists($this, $type)) {

			array_unshift($data['data'], $client);

			return call_user_func_array(array(
				$this, $type
			), $data['data']);
		}
	}



	public function broadCast($message) {

		if(count($this->clients)) {
			foreach($this->clients as $client) {
				$client->send((string) $message);
			}
		}
	}


	public function sendUserList() {

		$clients=array();
		foreach($this->clients as $client) {
			$clients[]=array(
				'id'=>$client->getId(),
				'login'=>$client->login
			);
		}
		$message=new Message('userList', array(
			'clients'=>$clients
		));
		$this->broadCast($message);
	}

	public function register($client, $login) {
		$client->login=$login;
		$this->sendUserList();
	}

	public function message($client, $message) {
		$message=new Message('message', array(
			'message'=>htmlentities($message),
			'client'=>array(
				'id'=>$client->getId(),
				'login'=>$client->login
			)
		));
		$this->broadCast($message);

	}








}