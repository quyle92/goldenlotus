<?php
function SendSMS_txtlocal($urlApi, $apiKey,$numbers,$sender,$message)
{
	try 
	{
		// example:
		// Account details
		//	$apiKey = urlencode('Your apiKey');
		//
		// Message details
		//	$numbers = array(447123456789, 447987654321);
		//	$sender = urlencode('Jims Autos');
		//	$message = rawurlencode('This is your message');
 
		$numbers = implode(',', $numbers);
 
		// Prepare data for POST request
		$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
		// Send the POST request with cURL
		$ch = curl_init($urlApi);//https://api.txtlocal.com/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
	
		// Process your response here
		echo $response;
		
	} 
	catch (Exception $e) 
	{
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

function GetBalance_eSMS($apiKey, $secretkey, &$result)
{
	try
	{
		$url = "http://rest.esms.vn/MainService.svc/json/GetBalance/".$apiKey."/".$secretkey;
		$ch = curl_init();							
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$result = curl_exec($ch);
		curl_close($ch);
	}
	catch (Exception $e) 
	{
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

function SendSMS_eSMS($urlApi, $apiKey, $secretkey, $phone,$brandname,$content,$smsType,&$result)
{
	try 
	{
		if(strlen($phone) < 10)
		{
			$phone = substr("0000000000",0,10 - strlen($phone)).$phone;	//		xu ly so phone < 10 so va quen mat so phone dau
		}
		$content = urlencode($content);
		//	$urlApi = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get";
		$url = $urlApi."?Phone=".$phone."&Content=".$content."&ApiKey=".$apiKey."&SecretKey=".$secretkey."&Brandname=".$brandname."&SmsType=2";
		//
		//	example:
		//
		//$url = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=0966885959&Content=test sms&ApiKey=940406E900A5252AC061867BE12598&SecretKey=E3702E69F16E1C3EA77818FA19F6E0&Brandname=QCAO_ONLINE&SmsType=2";
 		//
		// Send the POST request with cURL
		//
		$ch = curl_init();							// 'http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get');
		curl_setopt($ch, CURLOPT_URL, $url);
//		//curl_setopt($ch, CURLOPT_POST, true);
//		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		//
		// Process your response here
		//
		//echo $response;
		$result = $response;
	} 
	catch (Exception $e) 
	{
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
?>
	
		
	