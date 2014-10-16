 <?php

 $files = scandir($argv[1]);

 $palantirFiles = preg_grep("/^rospalantir.*/", $files);
 file_put_contents("/nfs/attic/smartw/users/curranw/palantir_backup/blah",  $palantirFiles);

 if (!file_exists($argv[1] . "sent_logs"))
 {
 	mkdir($argv[1] . "sent_logs", 0777, true);
 }
 foreach ($palantirFiles as $palantirFile)
 {
 	$palantirFileFullPath = $argv[1] . "" . $palantirFile;
 	$xml = simplexml_load_file($palantirFileFullPath);

 	$url = 'http://robotics.oregonstate.edu/test/palantir/recieve_file.php';
	$data = array('key1' => $xml->asXML(), 'name' => $palantirFile);

	// use key 'http' even if you send the request to https://...
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => http_build_query($data),
	    ),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result != False)
	{
		rename( $palantirFileFullPath, $argv[1] . "sent_logs/" . $palantirFile);
	}
 }
 ?>