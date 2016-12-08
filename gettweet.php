<?php
	require 'vendor/autoload.php';
	require 'key.php';
	use mpyw\Co\Co;
	use mpyw\Co\CURLException;
	use mpyw\Cowitter\Client;
	use mpyw\Cowitter\HttpException;

	$client = new Client([CK, CS, AT, ATS]);
	$client->post('statuses/update', ['status' => 'test tweet by api']);
?>
