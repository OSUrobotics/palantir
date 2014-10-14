 <?php

 $files = scandir($argv[1]);


 $palantirFiles = preg_grep("/^rospalantir.*/", $files);

 var_dump($palantirFiles);


 foreach ($palantirFiles as $palantirFile)
 {
 	$palantirFileFullPath = $argv[1] . "" . $palantirFile;
 	print($palantirFileFullPath);
 	#$fileContents = file_get_contents($palantirFile);
 	#print($fileContents);
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

	var_dump($result);


 	#foreach ($xml->msgs as $msg)
 	#{
 	#	var_dump($msg);
 	#}
 	#unset($xml);
 }
 ?>