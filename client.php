<?php

echo PHP_EOL;

define( 'HOST', '127.0.0.1' );

define( 'PORT', 9999 );

define( 'MAX_BYTES', 1024 );

$request = empty( $argv[1] ) ? $argv[0] : trim ( $argv[1] );

$socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP ) or die( "Could not create socket" . PHP_EOL );

socket_connect( $socket, HOST, PORT ) or die( "Could not connect to server" . PHP_EOL );

socket_write( $socket, $request, strlen( $request ) ) or die( "Could not send request to server" . PHP_EOL );

$response = socket_read( $socket, MAX_BYTES ) or die( "Could not read server response" . PHP_EOL );

$response = trim( $response );

echo $response . PHP_EOL;

socket_close( $socket );

echo PHP_EOL;

?>
