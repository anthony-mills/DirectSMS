<?php
// Include the directSMS class
require_once('directSMS.php');

// Set your directSMS username & password
$accountUsername = 'accountusername';
$accountPassword = 'accountpassword';

$directSMS = new directSMS($accountUsername, $accountPassword);

$mySMS = 'A test sms message';

$directSMS->setMessageBody($mySMS);

$directSMS->sendMessage('mymobilenumber');
