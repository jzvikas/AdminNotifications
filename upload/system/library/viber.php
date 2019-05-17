<?php
class Viber {
	const URL = 'https://chatapi.viber.com/pa/';

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

	public function setWebhook($url) {
		$data['url'] = $url;
		$data['send_name'] = true;
		$data['send_photo'] = true;
		$response = $this->call('set_webhook', $data);
		return $response;
	}

	public function delWebhook() {
		$data['url'] = '';
		$response = $this->call('set_webhook', $data);
		return $response;
	}

	public function getWebhookInfo() {
		$response = $this->call('get_account_info');
		return $response;
	}

	public function getBotInfo(){
		$response = $this->getWebhookInfo();
		return $response;
	}

	public function setTo($chat_id) {
		$this->chat_id = $chat_id;
	}

	public function sendMessage($message, $trim = false) {
		$text = $message;
		$data = array();

		if ($trim) {
			$data['receiver'] = $this->chat_id;
			$data['min_api_version'] = '1';
			$data['sender'] = array(
				'name' => 'gixoc.ru',
				'avatar' => 'https://www.viber.com/app/uploads/viber-logo.png'
			);
			$data['tracking_data'] = 'tracking data';
			$data['type'] = 'text';
			$data['text'] = mb_substr($text, 0, 7000);
			$response = $this->call('send_message', $data);
		} else {
			do {
				$data['receiver'] = $this->chat_id;
				$data['min_api_version'] = '1';
				$data['sender'] = array(
					'name' => 'gixoc.ru',
					'avatar' => 'https://www.viber.com/app/uploads/viber-logo.png'
				);
				$data['tracking_data'] = 'tracking data';
				$data['type'] = 'text';
				$data['text'] = mb_substr($text, 0, 7000);
				$response = $this->call('send_message', $data);

				$text = mb_substr($text, 7000);
			} while (mb_strlen($text, 'UTF-8') > 0);
		};
		return $response;
	}

	private function call($method, $data = array()) {
		$curl = curl_init();

		$options = [
			CURLOPT_URL => self::URL . $method,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_POST => null,
			CURLOPT_POSTFIELDS => null,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_TIMEOUT => $this->timeout,
			CURLOPT_HTTPHEADER => array("Cache-Control: no-cache", "Content-Type: application/JSON", "X-Viber-Auth-Token: " . $this->token)
		];

		if (!empty($data)) {
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = JSON_encode($data, 1);
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
		if (isset($result['status']) && ($result['status'] == '0')) {
			if ($this->logtype == '2') {
				$this->log->write('Success in ' . $method . ' (result = ' . json_encode($result) . ')');
			}
			return $result;
		} elseif ($result['status'] != '0') {
			if ($this->logtype == '2') {
				$this->log->write('ERROR in ' . $method . ' (array = ' . serialize($data) . ') :: description = ' . $result['status_message'] . '(error code = ' . $result['status'] . ')');
			} elseif ($this->logtype == '1') {
				$this->log->write('ERROR in ' . $method . ' :: description = ' . $result['status_message'] . '(error code = ' . $result['status'] . ')');
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