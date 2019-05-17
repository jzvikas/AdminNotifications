<?php
class Telegram {
	const URL = 'https://api.telegram.org/bot';

	protected $token;
	protected $chat_id;

	private $logtype;
	private $log;
	private $timeout;

	public function __construct($token, $timeout = 5) {
		$this->token = $token;
		$this->timeout = $timeout;
		$this->logtype = '0';
	}

	public function setLog($log, $logtype = '0') {
		if ($logtype == '2') {
			$this->logtype = '2';
		} elseif ($logtype == '1') {
			$this->logtype = '1';
		} else {
			$this->logtype = '0';
		}

		$this->log = $log;
	}

	public function get_telegram(){		
		$curl = curl_init('https://telegram.org');
						
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				
		$response = curl_exec($curl);
		
		curl_close($curl);
		
		if ($response) return true;
        
		return false;
	}

	public function getUpdates() {
		$response = $this->call('getUpdates');
		return $response;
	}

	public function setWebhook($url) {
		$data['url'] = $url;
		$response = $this->call('setWebhook', $data);
		return $response;
	}

	public function delWebhook() {
		$data['url'] = '';
		$response = $this->call('setWebhook', $data);
		return $response;
	}

	public function getWebhookInfo() {
		$response = $this->call('getWebhookInfo');
		return $response;
	}

	public function getBotInfo(){
		$response = $this->call('getMe');
		return $response;
	}

	public function setTo($chat_id) {
		$this->chat_id = $chat_id;
	}

	public function sendMessage($message, $trim = false) {
		$text = $message;
		$data = array();

		if ($trim) {
			$data['chat_id'] = $this->chat_id;
			$data['text'] = mb_substr($text, 0, 4096);
			$data['parse_mode'] = 'HTML';
			$response = $this->call('sendMessage', $data);
		} else {
			do {
				$data['chat_id'] = $this->chat_id;
				$data['text'] = mb_substr($text, 0, 4096);
				$data['parse_mode'] = 'HTML';
				$response = $this->call('sendMessage', $data);

				$text = mb_substr($text, 4096);
			} while (mb_strlen($text, 'UTF-8') > 0);
		};
		return $response;
	}

	private function call($method, $data = array()) {
		$curl = curl_init();

		$options = [
			CURLOPT_URL => self::URL . $this->token . '/' . $method,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => null,
			CURLOPT_POSTFIELDS => null,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT => $this->timeout,
		];

		if (!empty($data)) {
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = $data;
		}

		curl_setopt_array($curl, $options);

		$response = curl_exec($curl);

		if (!$response) {
			if ($this->logtype == '2') {
				$this->log->write('ERROR in ' . $method . ' (array = ' . serialize($data) . ') :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
			} elseif ($this->logtype == '1') {
				$this->log->write('ERROR in ' . $method . ' :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
			}
			return false;
		}

		$result = json_decode($response, true);
		if (isset($result['ok']) && ($result['ok'])) {
			if ($this->logtype == '2') {
				$this->log->write('Success in ' . $method . ' (result = ' . json_encode($result['result']) . ')');
			}
			return $result['result'];
		} elseif (!($result['ok'])) {
			if ($this->logtype == '2') {
				$this->log->write('ERROR in ' . $method . ' (array = ' . serialize($data) . ') :: description = ' . $result['description'] . '(error code = ' . $result['error_code'] . ')');
			} elseif ($this->logtype == '1') {
				$this->log->write('ERROR in ' . $method . ' :: description = ' . $result['description'] . '(error code = ' . $result['error_code'] . ')');
			}
			return false;
		} else {
			if ($this->logtype == '2') {
				$this->log->write('ERROR in ' . $method . ' (array = ' . serialize($data) . ') :: result = ' . serialize($result));
			} elseif ($this->logtype == '1') {
				$this->log->write('ERROR in ' . $method . ' :: result = ' . serialize($result));
			}
			return false;
		}

		curl_close($curl);
		return false;
	}
}