<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sms_send($mobile_number,$sms_message){
// //Your authentication key
// // $authKey = "312565A27Gwal5OO3R5e251fe6P1";
// $authKey = "139199Aea72sSE589067e1";

// //Multiple mobiles numbers separated by comma
// // $mobileNumber = "8826531706";
// $mobileNumber = $mobile_number;

// //Sender ID,While using route4 sender id should be 6 characters long.
// $senderId = "OTPSMS";

// //Your message to send, Add URL encoding here.
// // $message = urlencode("Welcome to Dredging Coporation of India");
// $message = urlencode($sms_message);

// //Define route 
// $route = "default";
// //Prepare you post parameters
// $postData = array(
    // 'authkey' => $authKey,
    // 'mobiles' => $mobileNumber,
    // 'message' => $message,
    // 'sender' => $senderId,
    // 'route' => $route
// );
// $verification_code = "784515";
$msg = "DCIeOff.%20Your%20Verification%20Code%20is:%20$sms_message";
//API URL
// $url="http://api.msg91.com/api/sendhttp.php";
$url="http://login.smsmoon.com/API/sms.php?username=dcivizag&password=vizag@123&from=DCIEOF&to=$mobile_number&msg=$msg&type=1&dnd_check=&template_id=1407162520601584911";


// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    // CURLOPT_POST => true,
    // CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));


//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

//Print error if any
if(curl_errno($ch))
{
   // echo 'error:' . curl_error($ch);
}

curl_close($ch);
return $output;
//echo $output;
}
?>

