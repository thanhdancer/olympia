var io = require( 'socket.io' ).listen(8092);
io.sockets.on( 'connection', function ( socket ) {

	socket.on( 'keep-alive', function(a) {
			socket.emit( 'keep-alive', a );
		});
	// command from Server to Screen
	socket.on( 'toScreen', function( data ) {
		socket.broadcast.emit( 'Screen', data );
	});
});