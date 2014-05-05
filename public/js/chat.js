var socket=null;


jQuery(function() {

	$( ".Chat" ).click(function() {
		$( "#chat" ).slideToggle( "slow", function() {
		});
	});

	var url='ws://naimy.serveftp.com:8000/server';
	var pseudo= $('#pseudo').html;
	socket=initializeSocket(url);


	jQuery('#sendMessage').submit(function(event) {
		var value=jQuery('#saySomething').val();
		sendMessage(socket, value);
		return false;
	});


});

function sendMessage(socket, value) {

	socket.send(value);
}

function initializeSocket(url) {

	var socket=new WebSocket(url);

	socket.onmessage=function(serverData) {

		console.debug(serverData.data);


		//on transforme la chaine de caractère json renvoyée par le serveur en objet
		var data=JSON.parse(serverData.data);


		//gestion de l'event connection
		if(data.messageType=='connection') {
			console.log(data.content);
			jQuery('#logged').empty();
			for(var i=0; i<data.content.length; i++) {
				jQuery('#logged').append('<div class="list">'+data.content[i]+'</div>');
			}
		}
		//gestion de l'event "time"
		else if(data.messageType=='time') {
			jQuery('#onServerUpdate').html(data.content);
		}
		//gestion de l'event "message"
		else if(data.messageType=='message') {
			jQuery('#tchatContent').append('<div>'+data.content+'</div>');
		}


		//jQuery('#log').html(serverData.data);
	}
	return socket;
}