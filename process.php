<?php
session_start();
mysql_connect('localhost','baacce5_cgcrm','0bvD@GeR)E-e');
mysql_select_db('baacce5_cgcrm');
//$payment_type = 'Authorization';	
$payment_type = 'Sale';

$request  = 'METHOD=DoDirectPayment';
$request .= '&VERSION=51.0';
$request .= '&USER=yudhbir.singh-facilitator_api1.60degree.com'; // your paypal Api  username
$request .= '&PWD=MKAWUSQTDCYP66DY'; //your paypal Api password  
$request .= '&SIGNATURE=AFcWxV21C7fd0v3bYYYRCpSSRl31AeLbxk12zw6sfr2otxKf5yDNCOzF';  ////your paypal Api signature password  
$request .= '&CUSTREF=' . (int)$_SESSION['order_id'];
$request .= '&PAYMENTACTION=' . $payment_type;
$request .= '&AMT='.$_POST['amount'];
$request .= '&CREDITCARDTYPE=' . $_POST['cc_type'];
$request .= '&ACCT=' . urlencode(str_replace(' ', '', $_POST['cc_number']));
// $request .= '&CARDSTART=' . urlencode($_POST['cc_start_date_month'] . $_POST['cc_start_date_year']);
$request .= '&EXPDATE=' . urlencode($_POST['cc_expire_date_month'] . $_POST['cc_expire_date_year']);
$request .= '&CVV2=' . urlencode($_POST['cc_cvv2']);

if ($_POST['cc_type'] == 'SWITCH' || $_POST['cc_type'] == 'SOLO') { 
	$request .= '&CARDISSUE=' . urlencode($_POST['cc_issue']);
}

$request .= '&FIRSTNAME=' . urlencode($_POST['first_name']);
$request .= '&LASTNAME=' . urlencode($_POST['last_name']);
$request .= '&EMAIL=' . urlencode($_POST['email_address']);
$request .= '&PHONENUM=' . urlencode($_POST['phone_no']);
$request .= '&IPADDRESS=' . urlencode($_SERVER['REMOTE_ADDR']);
$request .= '&COUNTRYCODE=' . urlencode($_POST['country_code']);
$request .= '&CURRENCYCODE=' . urlencode('USD');
$request .= '&CUSTOM=' . urlencode($_POST['leads_ids']);
	
/* $request .= '&SHIPTONAME=' . urlencode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']);
$request .= '&SHIPTOSTREET=' . urlencode($order_info['shipping_address_1']);
$request .= '&SHIPTOCITY=' . urlencode($order_info['shipping_city']);
$request .= '&SHIPTOSTATE=' . urlencode(($order_info['shipping_iso_code_2'] != 'US') ? $order_info['shipping_zone'] : $order_info['shipping_zone_code']);
$request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['shipping_iso_code_2']);
$request .= '&SHIPTOZIP=' . urlencode($order_info['shipping_postcode']);
 */	
	
/* $curl = curl_init('https://api-3t.paypal.com/nvp'); // This is for live account
$curl = curl_init('https://api-3t.sandbox.paypal.com/nvp'); // This is for sandbox account
 */

$curl = curl_init('https://api-3t.sandbox.paypal.com/nvp');
curl_setopt($curl, CURLOPT_PORT, 443);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

$response = curl_exec($curl);

curl_close($curl);
$filename = time().'data.txt';
$fp = fopen($filename,'w');
fwrite($fp, $response);
	


/* if (!$response) {
	write curl error to log file
	$fp = fopen('data.txt', 'DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
	fwrite($fp, $request);
	fclose($fp);	
} */

$response_info = array();

parse_str($response, $response_info);
$response_info['leads_ids']=$_POST['leads_ids'];
// echo "<pre>";print_r($response_info);echo"</pre>";
// die;


$json = array();

if ((($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) && $_POST['amount'] == $response_info['AMT']) {
	$message = '';

	if (isset($response_info['AVSCODE'])) {
		$message .= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
	}

	if (isset($response_info['CVV2MATCH'])) {
		$message .= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
	}

	if (isset($response_info['TRANSACTIONID'])) {
		$message .= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
	}
	
	if (isset($response_info['AMT'])) {
		$message .= 'AMOUNT: ' . $response_info['AMT'] . "\n";
	}
	
	fwrite($fp, $message);
	
	$sql= "CREATE TABLE IF NOT EXISTS `paypal_pro` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `Order_Id` varchar(255) NOT NULL,
	  `Name` varchar(255) NOT NULL,
	  `Email` varchar(255) NOT NULL,
	  `Address` varchar(255) NOT NULL,
	  `Phone_No` varchar(255) NOT NULL,
	  `City` varchar(255) NOT NULL,
	  `State` varchar(255) NOT NULL,
	  `Country_code` varchar(255) NOT NULL,
	  `Currency` varchar(255) NOT NULL,
	  `Amount` decimal(10,0) NOT NULL,
	  `Message` text NOT NULL,
	  `ip` varchar(255) NOT NULL,
	   PRIMARY KEY (`id`)
	)";
	mysql_query($sql) or mysql_error();
	$name= $_POST['first_name'].' '.$_POST['last_name'];
	$sql = 'INSERT INTO `paypal_pro` SET `Order_Id` ="'.$_SESSION['order_id'].'", `Name` = "'.$name.'", `Email` = "'.$_POST['email_address'].'", `Address` = "'.$_POST['address'].'", `Phone_No` ="'.$_POST['phone_no'].'", `City` = "'.$_POST['city'].'", `State` = "'.$_POST['state'].'", `Country_code` = "'.$_POST['country_code'].'", `Currency` = "USD", `Amount` = "'.$_POST['amount'].'", `Message` ="'.$message.'", `ip` = "'.$_SERVER['REMOTE_ADDR'].'"';	
	mysql_query($sql) or mysql_error();	
	//Do your database query and send mail to your client here
	//Do your database query and send mail to your client here
	//Do your database query and send mail to your client here
	//Do your database query and send mail to your client here
	//Do your database query and send mail to your client here
	$_SESSION['leads_ids']=$response_info['leads_ids'];
	$json['success'] = 'conversion.php';
} else {
	$json['error'] = $response_info['L_LONGMESSAGE0'];
}
fclose($fp);
echo (json_encode($json));
?>