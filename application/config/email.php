<?php defined('BASEPATH') OR exit('No direct script access allowed');


//$config = array(
//    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
//    'smtp_host' => 'relay.nic.in', 
//  'smtp_port' => 25,
//    'smtp_user' => 'eoffice@dcil.co.in',
//   'smtp_pass' => '',
//   'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
//   'mailtype' => 'text', //plaintext 'text' mails or 'html'
//   'smtp_timeout' => '3600', //in seconds
//    'charset' => 'iso-8859-1',
//    'wordwrap' => TRUE
//);

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'relay.emailgov.in', 
    'smtp_port' => 465,
    'smtp_user' => 'eoffice@dcil.co.in',
    'smtp_pass' => 'Licd@2021*',
    'smtp_crypto' => 'tls',//can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '30', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);


