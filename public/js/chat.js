var client=new GC_Client('ws://172.21.9.52:8000/test');

client.on('connect', function(data) {
	jQuery('#input').show();
});

client.on('message', function(data) {
	var content='<div>'+data.data.message+'</div>';
	jQuery('#content').append(content);
});


client.connect();

jQuery(function() {

	jQuery('#input').submit(function() {
		var message=jQuery('#input input').val();
		jQuery('#input input').val('');
		client.send('message', {message: message});
		return false;
	});

});