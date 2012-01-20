<?php
// Include the directSMS class
require_once('directSMS.php');

// Set your directSMS username & password
$accountUsername = 'myusername';
$accountPassword = 'mypassword';

$directSMS = new directSMS($accountUsername, $accountPassword);

$mySMS = 'mytestmsg';

$directSMS->setMessageBody($mySMS);

$directSMS->sendMessage('mobile number for msg');
