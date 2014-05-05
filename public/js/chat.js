var socket=null;


jQuery(function() {

	$( ".Chat" ).click(function() {
		$( "#chat" ).slideToggle( "slow", function() {
		});
	});

	var url='ws://192.168.1.13:8000/greentchat';
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

function timeConverter(UNIX_timestamp){
	 var a = new Date(UNIX_timestamp*1000);
	 var months = ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
	     var year = a.getFullYear();
	     var month = months[a.getMonth()];
	     var date = a.getDate();
	     var hour = a.getHours();
	     var min = a.getMinutes();
	     var sec = a.getSeconds();
	     var time = date+' '+month+' '+year+' '+hour+':'+min+':'+sec ;
	     return time;
	 }

function initializeSocket(url) {

	var socket=new WebSocket(url);

	socket.onmessage=function(serverData) {

		//on transforme la chaine de caractère json renvoyée par le serveur en objet
		var data=JSON.parse(serverData.data);


		//gestion de l'event connection
		if(data.messageType=='connection') {
			jQuery('#logged').empty();
			for(var i=0; i<data.content.length; i++) {
				jQuery('#logged').append('<div class="list">'+data.content[i]+'</div>');
			}
		}
		//gestion de l'event "time"
		else if(data.messageType=='time') {

			formattedTime = timeConverter(data.content);

			jQuery('#onServerUpdate').html(formattedTime);
		}
		//gestion de l'event "message"
		else if(data.messageType=='message') {
			jQuery('#tchatContent').append('<div>'+data.content+'</div>');
		}


		//jQuery('#log').html(serverData.data);
	}
	return socket;
}