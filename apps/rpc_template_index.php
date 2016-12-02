<?php

	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqpLib\Message\AMQPMessage;

	$connection		= new AMQPStreamConnection('172.17.0.2', 5672, 'guest', 'guest');
	$channel 		= $connection->channel();

	$channel->queue_declare('tlab.template.index', false, false, false, false);

	echo " [x] Awaiting RPC requests\n";
	$callback = function($req) 
	{
		$data 			= json_decode($req->body, true);

		$fields			= $data['body'];

		//url-ify the data for the POST
		$fields_string	= http_build_query($fields);

		$url			= 'http://172.17.0.7/templates?'.$fields_string;

		//open connection
		$header[]		= "Authorization: ".$data['header']['token'];

		$curl			= curl_init();

		curl_setopt_array($curl, array(
							  CURLOPT_PORT 				=> "80",
							  CURLOPT_URL 				=> $url,
							  CURLOPT_RETURNTRANSFER 	=> true,
							  CURLOPT_ENCODING 			=> "",
							  CURLOPT_MAXREDIRS 		=> 10,
							  CURLOPT_TIMEOUT 			=> 30,
							  CURLOPT_HTTP_VERSION 		=> CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST 	=> "GET",
							  CURLOPT_HTTPHEADER 		=> $header,
						));

		$result			= curl_exec($curl);
		
		curl_close($curl);

	    $msg 			= new AMQPMessage((string) $result, array('correlation_id' => $req->get('correlation_id')));

	    $req->delivery_info['channel']->basic_publish($msg, '', $req->get('reply_to'));
	    $req->delivery_info['channel']->basic_ack($req->delivery_info['delivery_tag']);
	};

	$channel->basic_qos(null, 1, null);
	$channel->basic_consume('tlab.template.index', '', false, false, false, false, $callback);

	while(count($channel->callbacks)) 
	{
	    $channel->wait();
	}

	$channel->close();
	$connection->close();

?>