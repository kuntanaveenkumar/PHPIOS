<?php 
session_start();
ini_set('max_execution_time', 600);//300 seconds = 5 minutes
$notification_text="Sending test push notification"
$deviceToken = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$passphrase = 'xxxxxx';
//if (!$fp)
//   exit("Failed to connect: $err $errstr" . PHP_EOL);
//echo 'Connected to APNS' . PHP_EOL;
unset($ctx);
$ctx = stream_context_create();
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns-dis.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
$['device_key']="XXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
// Open a connection to the APNS server
$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 360, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
// Create the payload body
$body['aps'] = array(
'alert' => $notification_text,
'badge' => 1,
'sound' => 'default'
);
// Encode the payload as JSON
$payload = json_encode($body);
$deviceToken=trim($device_key);
// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
fclose($fp);
usleep(500000);
// Close the connection to the server
if (!$result)
$success= 'Message not delivered' . PHP_EOL;
else
$success= 'Message successfully delivered' . PHP_EOL;
header("location:success.php?msg=".$success);
exit;
   ?>