<?php
           
    
	$url = 'https://www.facebook.com';
    $orignal_parse = parse_url($url, PHP_URL_HOST);
    $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
    $read = stream_socket_client("ssl://".$orignal_parse.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
    $cert = stream_context_get_params($read);
    $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);



    // Get The Dates From The Certificate
	
    $valid_from = date(DATE_RFC2822,$certinfo['validFrom_time_t']);
    $valid_to = date(DATE_RFC2822,$certinfo['validTo_time_t']);
    
	$StartDate= date("Y-m-d", strtotime($valid_from));
	$LastDate=  date("Y-m-d", strtotime($valid_to));
    $Todaydate= date('Y-m-d');
    
	echo 'This Certificate is Valid From'.$StartDate.'<br>';
	echo 'This Certificate is Valid To'.$LastDate.'<br>';
	
	$date1=date_create($LastDate);
    $date2=date_create($Todaydate);
    $diff=date_diff($date2,$date1);
    $differncedates=$diff->format("%R%a");

	

    $variation = str_replace("+", "", $differncedates);
	echo 'Total Number of Days Remaining to Expire The SSL Certificate'.$variation;


?>