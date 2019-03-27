<?php

echo PHP_EOL;

define( 'HOST', '127.0.0.1' );

define( 'PORT', 9999 );

define( 'MAX_BYTES', 1024 );

define( 'BACKLOG_CONNS', 3 );

set_time_limit( 0 );

ob_implicit_flush();

$socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP ) or die( "Unable to create socket" . PHP_EOL );

socket_set_option( $socket, SOL_SOCKET, SO_REUSEADDR, 1 ) or die( "Unable to set socket option" . PHP_EOL );

socket_bind( $socket, HOST, PORT ) or die( "Unable to bind to socket" . PHP_EOL );

socket_listen( $socket, BACKLOG_CONNS ) or die( "Unable to set up socket listener" . PHP_EOL );

echo 'Server started' . PHP_EOL;

echo PHP_EOL;

echo 'Listening on ' . HOST . ':' . PORT . PHP_EOL;

echo PHP_EOL;

$listen = TRUE;

do {
    echo "Waiting" . PHP_EOL;

    $spawn = socket_accept( $socket ) or die( "Unable to accept incoming connection" . PHP_EOL );

    $request = socket_read( $spawn, MAX_BYTES ) or die( "Unable to read request" . PHP_EOL );

    echo "Got something" . PHP_EOL;

    $response = trim( $request );

    echo "Processing" . PHP_EOL;

    if( strtolower($response) === 'stop' ) {

        $listen = FALSE;

    }

    socket_write( $spawn, $response, strlen ( $response ) ) or die( "Unable to write output" . PHP_EOL );

    echo "Response sent" . PHP_EOL;

    echo PHP_EOL;

    socket_close( $spawn );

} while ( $listen );

socket_close( $socket );

echo "Server stopped" . PHP_EOL;

echo PHP_EOL;

?>
