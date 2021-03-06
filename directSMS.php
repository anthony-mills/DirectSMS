<?php
/**
 * DirectSMS API Wrapper
 *
 * @author Anthony Mills <me@anthony-mills.com>
 * @link http://www.anthony-mills.com
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License V2
 * @version 0.1
 */
class directSMS {
	
	protected $_apiLocation = 'http://api.directsms.com.au/s3/http/';
	protected $_accountUsername = NULL;
	protected $_accountPassword = NULL;	
	protected $_messageOrigin = '0405000111';
	protected $_messageBody = NULL;
	protected $_splitMessage = FALSE;
	protected $_messageReference = NULL;
	protected $_debugMode = TRUE;
	protected $_connectionId = NULL;
	protected $_messageType = '1-way';
	
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
		$connectResult = $this->_apiConnect();
	}
	 
	/**
	 * Set the mobile number the message appears to the recipient as having been sent from
	 * 
	 * @param integer $numberOrigin
	 * @return bool
	 */
	public function setOriginNumber($messageOrigin) 
	{
		if (strlen($messageOrigin) <= 11) {
			$this->_messageOrigin = urlencode($messageOrigin);
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
			$this->_messageBody = urlencode($messageBody);
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
		$apiString = $this->_apiLocation . 'send_message?connectionid=' . $this->_connectionId . '&senderid=' . $this->_messageOrigin . '&to=' . $messageRecipient . '&type=' . $this->_messageType;
		
		if (!empty($this->_messageReference)) {
			$apiString .= '&messageid=' . $this->_messageReference;
		}
	
		if (!empty($this->_messageBody)) {
			$apiString .= '&message=' . $this->_messageBody;
		}
				
		$sendResult = $this->_apiCommunicate($apiString);
		
	}

	
	/**
	 * Connect to DirectSMS API  
	 * 
	 * @param string $username
	 * @param string $password
	 * @return string
	 */
	protected function _apiConnect()
	{
		$apiString = $this->_apiLocation . 'connect?username=' . $this->_accountUsername . '&password=' . $this->_accountPassword;
		
		$connectionId = $this->_apiCommunicate($apiString);
		if (!empty($connectionId)) {
			$connectionId = explode(': ', $connectionId);
			if (strlen($connectionId[1]) == 34) {
				$this->_connectionId = trim($connectionId[1]);
				return TRUE;
			}
			throw new Exception('Unable to connect to API');
		}
		
	}
		
	/**
	 * Communicate with the SMS provider via their API
	 * 
	 * @param string $apiString
	 * @return bool
	 */
	protected function _apiCommunicate($apiString)
	{
		$curlHandle = curl_init();
		curl_setopt($curlHandle, CURLOPT_URL, $apiString);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, TRUE); 
		$result = curl_exec($curlHandle);
		if ($this->_debugMode) {
			echo $apiString . '<br>';
			print_r($result);
		}
		curl_close($curlHandle);
		
		return $result;
	}
}
