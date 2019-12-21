<?php 
	set_include_path(get_include_path() . PATH_SEPARATOR . 'libraries');

	include('phpseclib/File/X509.php');

	$filename = 'resources/example_files/123.p12';
	$password = '123';
	$results = array();
	$worked = openssl_pkcs12_read(file_get_contents($filename), $results, $password));
	if($worked) {
	    echo '<pre>', print_r($results, true), '</pre>';
	} else {
	    echo openssl_error_string();
	}

	// $x509 = new File_X509();
	// $cert = $x509->loadX509();

	// print_r($cert);
?>