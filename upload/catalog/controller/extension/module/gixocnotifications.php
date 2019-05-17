<?php
class ControllerExtensionModuleGixOCNotifications extends Controller {
	private $error = array();
	private $language_id;
	private $langdata;

	public function __construct($registry) {
		parent::__construct($registry);
		$this->language_id = $this->config->get('config_language_id');
		$this->langdata = $this->config->get('gixocnotifications_langdata');
	}

	public function new_order($route, $data) {
		if (isset($this->session->data['order_id']) && !empty($this->session->data['order_id']) ) {
			$order_id = array($this->session->data['order_id']);
			if ($this->config->get('gixocnotifications_status')) {
				$this->options('new_order_', $order_id);
			}
		}
	}

	public function new_customer($route, $data) {
		if (isset($data[0]) && !empty($data[0]) && ($this->config->get('gixocnotifications_status'))) {
			$this->options('new_customer_', $data[0]);
		}
	}

	public function new_affiliate($route, $data) {
		if (isset($data[0]) && !empty($data[0]) && ($this->config->get('gixocnotifications_status'))) {
			$this->options('new_affiliate_', $data[0]);
		}
	}

	public function new_review($route, $data) {
		if (isset($data) && !empty($data) && ($this->config->get('gixocnotifications_status'))) {
			$this->options('new_review_', $data);
		}
	}

	public function new_return($route, $data) {
		if (isset($data[0]) && !empty($data[0]) && ($this->config->get('gixocnotifications_status'))) {
			$this->options('new_return_', $data[0]);
		}
	}

	public function orders($route, $data) {
		if (isset($data[0]) && !empty($data[0]) && isset($data[1]) && !empty($data[1]) && ($this->config->get('gixocnotifications_status'))) {
			$this->options('new_order_', $data););
		}
	}

	private function options($option, $info) {
		$userdata = $this->config->get('gixocnotifications_userdata');

		$messengers = array(
			'1' => 'telegram',
			'2' => 'viber'
		);

		foreach ($messengers as $messenger) {
			$key = $this->config->get('gixocnotifications_' . $messenger . '_key');
			$webhook = $this->config->get('gixocnotifications_' . $messenger . '_webhook');
			if (!empty($key)) {
				$message = new $messenger($key, $this->config->get('gixocnotifications_' . $messenger . '_timeout'));
				$message->setLog( new \Log('gixocnotifications_' . $messenger . '.log'), $this->config->get('gixocnotifications_logs')[$messenger]);

				foreach ($userdata as $user_id => $user) {
					if (isset($user[$option . $messenger]) && ($user[$option . $messenger] == 'on') && !empty($user['id_' . $messenger]) && ($this->config->get('gixocnotifications_' . $messenger . '_key'))) {
						$dr = $option . 'template';
						$text = htmlspecialchars_decode($this->$dr($info, $messenger));
						$message->setTo($user['id_' . $messenger]);
						$send = false;
						if ($webhook == 'false') {
							$send = false;
						} else {
							$send = $message->sendMessage($text, $this->config->get('gixocnotifications_' . $messenger . '_trim_messages'));
						}
					}
				}
			}
		}
	}

	private function new_order_template($data, $messenger) {
		$order_id = $data[0];
		if (isset($data[1]) && !empty($data[1])) {
			$message = $this->langdata[$this->language_id]['orders_' . $messenger][$data[1]];
		} else {
			$message = $this->langdata[$this->language_id]['new_order_' . $messenger];
		}

		$this->load->model('extension/module/gixocnotifications');
		$order_info = $this->model_extension_module_gixocnotifications->getOrder($order_id);

		if ($order_info['payment_address_format']) {
			$format = $order_info['payment_address_format'];
		} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}

		$find = array(
			'{firstname}',
			'{lastname}',
			'{company}',
			'{address_1}',
			'{address_2}',
			'{city}',
			'{postcode}',
			'{zone}',
			'{zone_code}',
			'{country}'
		);

		$replace = array(
			'firstname' => $order_info['payment_firstname'],
			'lastname'  => $order_info['payment_lastname'],
			'company'   => $order_info['payment_company'],
			'address_1' => $order_info['payment_address_1'],
			'address_2' => $order_info['payment_address_2'],
			'city'      => $order_info['payment_city'],
			'postcode'  => $order_info['payment_postcode'],
			'zone'      => $order_info['payment_zone'],
			'zone_code' => $order_info['payment_zone_code'],
			'country'   => $order_info['payment_country']
		);

		$payment_address = str_replace(array("\r\n", "\r", "\n"), ' ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ' ', trim(str_replace($find, $replace, $format))));

		if ($order_info['shipping_address_format']) {
			$format = $order_info['shipping_address_format'];
		} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}

		$find = array(
			'{firstname}',
			'{lastname}',
			'{company}',
			'{address_1}',
			'{address_2}',
			'{city}',
			'{postcode}',
			'{zone}',
			'{zone_code}',
			'{country}'
		);

		$replace = array(
			'firstname' => $order_info['shipping_firstname'],
			'lastname'  => $order_info['shipping_lastname'],
			'company'   => $order_info['shipping_company'],
			'address_1' => $order_info['shipping_address_1'],
			'address_2' => $order_info['shipping_address_2'],
			'city'      => $order_info['shipping_city'],
			'postcode'  => $order_info['shipping_postcode'],
			'zone'      => $order_info['shipping_zone'],
			'zone_code' => $order_info['shipping_zone_code'],
			'country'   => $order_info['shipping_country']
		);

		$shipping_address = str_replace(array("\r\n", "\r", "\n"), ' ', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), ' ', trim(str_replace($find, $replace, $format))));

		$find = array(
			'{order_id}',
			'{store_name}',
			'{customer_firstname}',
			'{customer_lastname}',
			'{customer_email}',
			'{customer_telephone}',
			'{customer_group}',
			'{payment_address}',
			'{payment_method}',
			'{shipping_address}',
			'{shipping_method}',
			'{total}',
			'{comment}',
			'{order_status}',
			'{date_added}',
			'{date_modified}'
		);

		$replace = array(
			'{order_id}'           => isset($order_info['order_id']) ? $order_info['order_id'] : '',
			'{store_name}'         => isset($order_info['store_name']) ? $order_info['store_name'] : '',
			'{customer_firstname}' => isset($order_info['firstname']) ? $order_info['firstname'] : '',
			'{customer_lastname}'  => isset($order_info['lastname']) ? $order_info['lastname'] : '',
			'{customer_email}'     => isset($order_info['email']) ? $order_info['email'] : '',
			'{customer_telephone}' => isset($order_info['telephone']) ? $order_info['telephone'] : '',
			'{customer_group}'     => isset($order_info['customer_group']) ? $order_info['customer_group'] : '',
			'{payment_address}'    => isset($payment_address) ? $payment_address : '',
			'{payment_method}'     => isset($order_info['payment_method']) ? $order_info['payment_method'] : '',
			'{shipping_address}'   => isset($shipping_address) ? $shipping_address : '',
			'{shipping_method}'    => isset($order_info['shipping_method']) ? $order_info['shipping_method'] : '',
			'{total}'              => isset($order_info['total']) ? $order_info['total'] : '',
			'{comment}'            => isset($order_info['comment']) ? $order_info['comment'] : '',
			'{order_status}'       => isset($order_info['order_status']) ? $order_info['order_status'] : '',
			'{date_added}'         => isset($order_info['date_added']) ? $order_info['date_added'] : '',
			'{date_modified}'      => isset($order_info['date_modified']) ? $order_info['date_modified'] : ''
		);

		return str_replace(array("\r\n", "\r", "\n"), chr(10), preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), chr(10), trim(str_replace($find, $replace, $message))));
	}

	private function new_customer_template($customer_info, $messenger) {
		$message = $this->langdata[$this->language_id]['new_customer_' . $messenger];

		$this->load->model('account/customer_group'); 

		$find = array(
			'{store_name}',
			'{customer_firstname}',
			'{customer_lastname}',
			'{customer_group}',
			'{customer_email}',
			'{customer_telephone}',
			'{date_added}'
		);

		if (isset($customer_info['customer_group_id'])) {
			$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_info['customer_group_id']);
		} else {
			$customer_group = '';
		}

		$replace = array(
			'{store_name}'         => $this->config->get('config_name'),
			'{customer_firstname}' => isset($customer_info['firstname']) ? $customer_info['firstname'] : '',
			'{customer_lastname}'  => isset($customer_info['lastname']) ? $customer_info['lastname'] : '', 
			'{customer_group}'     => isset($customer_group['name']) ? $customer_group['name'] : '',
			'{customer_email}'     => isset($customer_info['email']) ? $customer_info['email'] : '',
			'{customer_telephone}' => isset($customer_info['telephone']) ? $customer_info['telephone'] : '',
			'{date_added}'         => date("Y-m-d H:i:s")
		);

		return str_replace(array("\r\n", "\r", "\n"), chr(10), preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), chr(10), trim(str_replace($find, $replace, $message))));
	}

	private function new_affiliate_template(/* $affiliate_id */$affiliate_info, $messenger) {
		$message = $this->langdata[$this->language_id]['new_affiliate_' . $messenger];

		$find = array(
			'{store_name}',
			'{affiliate_firstname}',
			'{affiliate_lastname}',
			'{affiliate_email}',
			'{affiliate_telephone}',
			'{affiliate_website}',
			'{affiliate_company}',
			'{date_added}'
		);

		$replace = array(
			'{store_name}'          => $this->config->get('config_name'),
			'{affiliate_firstname}' => isset($affiliate_info['firstname']) ? $affiliate_info['firstname'] : '',
			'{affiliate_lastname}'  => isset($affiliate_info['lastname']) ? $affiliate_info['lastname'] : '',
			'{affiliate_email}'     => isset($affiliate_info['email']) ? $affiliate_info['email'] : '',
			'{affiliate_telephone}' => isset($affiliate_info['telephone']) ? $affiliate_info['telephone'] : '',
			'{affiliate_website}'   => isset($affiliate_info['website']) ? $affiliate_info['website'] : '',
			'{affiliate_company}'   => isset($affiliate_info['company']) ? $affiliate_info['company'] : '',
			'{date_added}'          => date("Y-m-d H:i:s")
		);

		return str_replace(array("\r\n", "\r", "\n"), chr(10), preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), chr(10), trim(str_replace($find, $replace, $message))));
	}

	private function new_review_template($data, $messenger) {
		$message = $this->langdata[$this->language_id]['new_review_' . $messenger];

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($data[0]);

		$find = array(
			'{store_name}',
			'{name}',
			'{review}',
			'{rating}',
			'{product_name}',
			'{product_model}',
			'{product_sku}',
			'{date_added}'
		);

		$customer_review = $data[1];

		$replace = array(
			'{store_name}'    => $this->config->get('config_name'),
			'{name}'          => isset($customer_review['name']) ? $customer_review['name'] : '',
			'{review}'        => isset($customer_review['text']) ? $customer_review['text'] : '',
			'{rating}'        => isset($customer_review['rating']) ? $customer_review['rating'] : '',
			'{product_name}'  => isset($product_info['name']) ? $product_info['name'] : '',
			'{product_model}' => isset($product_info['model']) ? $product_info['model'] : '',
			'{product_sku}'   => isset($product_info['sku']) ? $product_info['sku'] : '',
			'{date_added}'    => date("Y-m-d H:i:s")
		);

		return str_replace(array("\r\n", "\r", "\n"), chr(10), preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), chr(10), trim(str_replace($find, $replace, $message))));
	}

	private function new_return_template($data, $messenger) {
		$message = $this->langdata[$this->language_id]['new_return_' . $messenger];

		$find = array(
			'{store_name}',
			'{customer_firstname}',
			'{customer_lastname}',
			'{customer_email}',
			'{customer_telephone}',
			'{order_id}',
			'{date_ordered}',
			'{product_name}',
			'{product_model}',
			'{product_quantity}',
			'{return_reason}',
			'{opened}',
			'{comment}',
			'{date_added}'
		);

		$this->load->model('extension/module/gixocnotifications');

		$return_reasons = $this->model_extension_module_gixocnotifications->getReturnReason($data['return_reason_id']);

		$replace = array(
			'{store_name}'         => $this->config->get('config_name'),
			'{customer_firstname}' => isset($data['firstname']) ? $data['firstname'] : '',
			'{customer_lastname}'  => isset($data['lastname']) ? $data['lastname'] : '',
			'{customer_email}'     => isset($data['email']) ? $data['email'] : '',
			'{customer_telephone}' => isset($data['telephone']) ? $data['telephone'] : '',
			'{order_id}'           => isset($data['order_id']) ? $data['order_id'] : '',
			'{date_ordered}'       => isset($data['date_ordered']) ? $data['date_ordered'] : '',
			'{product_name}'       => isset($data['product']) ? $data['product'] : '',
			'{product_model}'      => isset($data['model']) ? $data['model'] : '',
			'{product_quantity}'   => isset($data['quantity']) ? $data['quantity'] : '',
			'{return_reason}'      => isset($return_reasons['name']) ? $return_reasons['name'] : '',
			'{opened}'             => ($data['opened']) ? $this->language->get('text_yes') : $this->language->get('text_no'),
			'{comment}'            => isset($data['comment']) ? $data['comment'] : '',
			'{date_added}'         => date("Y-m-d H:i:s")
		);

		return str_replace(array("\r\n", "\r", "\n"), chr(10), preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), chr(10), trim(str_replace($find, $replace, $message))));
	}

	public function webhook_telegram() {
		$sapi_type = php_sapi_name();
		if (substr($sapi_type, 0, 3) == 'cgi')
			header("Status: 200 Ok'");
		else
			header("HTTP/1.0 200 OK");

		$request = file_get_contents('php://input');

		$input = json_decode($request, true);

		if (isset($input['message']['text'] ) && $input['message']['text'] == '/start') {
			$key = $this->config->get('gixocnotifications_telegram_key');
			$webhook = $this->config->get('gixocnotifications_telegram_webhook');
			if (!empty($key) && ($webhook != 'false')) {
				$telegram = new \Telegram($key, $this->config->get('gixocnotifications_telegram_timeout'));
				$telegram->setLog( new \Log('gixocnotifications_telegram.log'), $this->config->get('gixocnotifications_logs')['telegram']);
				$telegram->setTo($input['message']['from']['id']);
				$telegram->sendMessage('Здравствуйте, ' . $input['message']['from']['last_name'] . ' ' . $input['message']['from']['first_name'] . '!' . chr(10) . 'Ваш ID: ' . $input['message']['from']['id'] . chr(10) . 'Язык: ' . $input['message']['from']['language_code'], $this->config->get('gixocnotifications_telegram_trim'));
			}
		}
	}

	public function webhook_viber() {
		$request = file_get_contents("php://input");
		$input = json_decode($request, true);

		if (isset($input['event'])) {
			$key = $this->config->get('gixocnotifications_viber_key');
			$webhook = $this->config->get('gixocnotifications_viber_webhook');
			if (!empty($key) && ($webhook != 'false')) {
				$viber = new \Viber($key, $this->config->get('gixocnotifications_viber_timeout'));
				$viber->setLog( new \Log('gixocnotifications_viber.log'), $this->config->get('gixocnotifications_logs')['viber']);

				if ($input['event'] == 'webhook') {
					$webhook_response['status'] = 0;
					$webhook_response['status_message'] = "ok";
					$webhook_response['event_types'] = 'delivered';
					echo json_encode($webhook_response);
					die;
				} elseif ($input['event'] == 'conversation_started'){
					$user_id = $input['user']['id'];
					$user_name = $input['user']['name'];
					$viber_message = 'Здравствуйте, ' . $user_name .  '! Ваш ID - ' . $user_id;

					$viber->setTo($user_id);
					$viber->sendMessage($viber_message, $this->config->get('gixocnotifications_viber_trim'));
				} elseif ($input['event'] == 'message') {
					$sender_id = $input['sender']['id'];
					$sender_name = $input['sender']['name'];
					$viber_message = 'Здравствуйте, ' . $sender_name .  '! Ваш ID - ' . $sender_id;

					$viber->setTo($sender_id);
					$viber->sendMessage($viber_message, $this->config->get('gixocnotifications_viber_trim'));
				}
			}
		}
	}
}