<?php 
	set_include_path('libraries/phpseclib/');

	include('File/X509.php');

	function runTests() {
		$extractCertificate = extractCertificate();
		$retrieveInfo = retrieveInfo($extractCertificate);
	}

	function extractCertificate() {
		$filename = 'resources/example_files/certificates/123.p12';
		$password = '123';
		$results = array();
		$worked = openssl_pkcs12_read(file_get_contents($filename), $results, $password);
		if($worked) {
		    return $results;
		} else {
		    return openssl_error_string();
		}
	}

	function retrieveInfo($results) {
		$pem = str_replace(array("-----BEGIN CERTIFICATE-----", "-----END CERTIFICATE-----"), array("", ""), $results['cert']);
		$x509 = new File_X509();
		$cert = $x509->loadX509($pem);

		// print_r($cert);
		// Cert Common Name : $cert['tbsCertificate']['subject']['rdnSequence'][1][0]['value']['utf8String']
		// Cert Team ID : $cert['tbsCertificate']['subject']['rdnSequence'][2][0]['value']['utf8String']
		// Organisation Name : $cert['tbsCertificate']['subject']['rdnSequence'][3][0]['value']['utf8String']
		// Invalid Before : $cert['tbsCertificate']['validity']['notBefore']['utcTime']
		// Valid Until : $cert['tbsCertificate']['subject']['notAfter']['utcTime']
		echo '<pre>', print_r($cert['tbsCertificate'], true), '</pre>';
	}

	function readFileToBytes() {
		$filename = "resources/example_files/certificates/123.p12"; 
		$handle = fopen($filename, "rb"); 
		$fsize = filesize($filename); 
		$contents = fread($handle, $fsize); 
		$byteArray = unpack("N*",$contents); 
		echo '<pre>'.print_r($byteArray, true).'</pre>'
	}

	runTests();

?>