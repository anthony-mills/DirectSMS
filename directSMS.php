<?php
class directSMS {
	
	protected $_apiLocation = 'http://srs.smsc.com.au/enterprise/sendsmsv2';
	protected $_accountUsername = NULL;
	protected $_accountPassword = NULL;	
	protected $_numberOrigin = '0405000111';
	protected $_messageBody = NULL;
	protected $_splitMessage = FALSE;
	protected $_messageReference = NULL;
	
	/**
	 * Set the account credentials
	 *  
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($accountUsername, $accountPassword) 
	{
		$this->_accountUsername = $accountUsername;
		$this->_accountPassword = $accountPassword;
	}
	 
	/**
	 * Set the mobile number the message appears to the recipient as having been sent from
	 * 
	 * @param integer $numberOrigin
	 * @return bool
	 */
	public function setOriginNumber($numberOrigin) 
	{
		if ((is_numeric($numberOrigin)) && (strlen($numberOrigin) <= 10)) {
			$this->_numberOrigin = $numberOrigin;
			return TRUE;
		}
		return FALSE;	
	}
	
	/**
	 * Set the message content to be sent
	 * 
	 * @param string $messageBody
	 * @return bool 
	 */
	public function setMessageBody($messageBody) 
	{
		if (!empty($messageBody)) {
			if (strlen($messageBody) > 160) {
				$this->_splitMessage = 1;
			}
			$this->_messageBody = $messageBody;
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * Set a message reference for the delivery reciept
	 * 
	 * @param string $messageReference
	 * @return bool
	 */
	public function setMessageReference($messageReference)
	{
		if ((!empty($messageReference)) && (strlen($messageReference) <= 64)) {
			$this->_messageReference = preg_replace('/[\s\W]+/','-',$messageReference); 
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Send an SMS to recipient
	 * 
	 * @param integer $recipient
	 * @return bool
	 */
	public function sendMessage($messageRecipient)
	{
		
		
	}
}
