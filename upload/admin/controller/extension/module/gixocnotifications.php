<?php
class ControllerExtensionModuleGixOCNotifications extends Controller {
	private $error = array();
	private $ssl = false;
	private $messengers = array();
	private $messengers_text = array();
	private $get_telegram = false;

	public function __construct($registry) {
		parent::__construct($registry);
		$this->load->language('extension/module/gixocnotifications');

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->ssl = true;
		} else {
			$this->ssl = false;
		}

		$this->messengers = array(
			'1' => 'telegram',
			'2' => 'viber'
		);

		$this->messengers_text = array(
			'1' => '<i class="fa fa-paper-plane"></i> Telegram',
			'2' => '<i class="fa fa-phone"></i> Viber'
		);
	}

	public function index() {
		$this->document->setTitle($this->language->get('text_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('gixocnotifications', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_orders_status'] = $this->language->get('text_orders_status');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_cut'] = $this->language->get('text_cut');
		$data['text_split'] = $this->language->get('text_split');
		$data['text_developer'] = $this->language->get('text_developer');

		$data['button_verify'] = $this->language->get('button_verify');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_close'] = $this->language->get('button_close');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_download'] = $this->language->get('button_download');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_template'] = $this->language->get('tab_template');
		$data['tab_users'] = $this->language->get('tab_users');
		$data['tab_logs'] = $this->language->get('tab_logs');
		$data['tab_support'] = $this->language->get('tab_support');

		$data['legend_new_order'] = $this->language->get('legend_new_order');
		$data['legend_new_customer'] = $this->language->get('legend_new_customer');
		$data['legend_new_affiliate'] = $this->language->get('legend_new_affiliate');
		$data['legend_new_review'] = $this->language->get('legend_new_review');
		$data['legend_new_return'] = $this->language->get('legend_new_return');
		$data['legend_orders'] = $this->language->get('legend_orders');

		$data['column_use'] = $this->language->get('column_use');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_port'] = $this->language->get('column_port');
		$data['column_login'] = $this->language->get('column_login');
		$data['column_password'] = $this->language->get('column_password');
		$data['column_user'] = $this->language->get('column_user');
		$data['column_id'] = $this->language->get('column_id');
		$data['column_orders'] = $this->language->get('column_orders');
		$data['column_new'] = $this->language->get('column_new');
		$data['column_new_order'] = $this->language->get('column_new_order');
		$data['column_new_customer'] = $this->language->get('column_new_customer');
		$data['column_new_affiliate'] = $this->language->get('column_new_affiliate');
		$data['column_new_review'] = $this->language->get('column_new_review');
		$data['column_new_return'] = $this->language->get('column_new_return');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_auto'] = $this->language->get('entry_auto');
		$data['entry_wait'] = $this->language->get('entry_wait');

		$data['help_timeout'] = $this->language->get('help_timeout');
		$data['help_trim_messages'] = $this->language->get('help_trim_messages');
		$data['help_license'] = $this->language->get('help_license');
		$data['help_new_order'] = sprintf($this->language->get('help_new_order'), HTTPS_CATALOG);
		$data['help_new_order_ex'] = $this->language->get('help_new_order_ex');
		$data['help_orders'] = $this->language->get('help_orders');
		$data['help_orders_ex'] = $this->language->get('help_orders_ex');
		$data['help_new_customer'] = $this->language->get('help_new_customer');
		$data['help_new_customer_ex'] = $this->language->get('help_new_customer_ex');
		$data['help_new_affiliate'] = $this->language->get('help_new_affiliate');
		$data['help_new_affiliate_ex'] = $this->language->get('help_new_affiliate_ex');
		$data['help_new_review'] = $this->language->get('help_new_review');
		$data['help_new_review_ex'] = $this->language->get('help_new_review_ex');
		$data['help_new_return'] = $this->language->get('help_new_return');
		$data['help_new_return_ex'] = $this->language->get('help_new_return_ex');
		$data['help_module'] = $this->language->get('help_module');
		$data['help_thanks'] = $this->language->get('help_thanks');
		$data['help_faq'] = $this->language->get('help_faq');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_title'),
			'href' => $this->url->link('extension/module/gixocnotifications', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/module/gixocnotifications', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		if (isset($this->request->post['gixocnotifications_status'])) {
			$data['gixocnotifications_status'] = $this->request->post['gixocnotifications_status'];
		} else {
			$data['gixocnotifications_status'] = $this->config->get('gixocnotifications_status');
		}

		if (isset($this->request->post['gixocnotifications_langdata'])) {
			$data['gixocnotifications_langdata'] = $this->request->post['gixocnotifications_langdata'];
		} else {
			$data['gixocnotifications_langdata'] = $this->config->get('gixocnotifications_langdata');
		}

		if (isset($this->request->post['gixocnotifications_userdata'])) {
			$data['gixocnotifications_userdata'] = $this->request->post['gixocnotifications_userdata'];
		} else {
			$data['gixocnotifications_userdata'] = $this->config->get('gixocnotifications_userdata');
		}

		$data['messengers'] = $this->messengers;

		$data['messengers_text'] = $this->messengers_text;

		if (isset($this->request->post['gixocnotifications_logs'])) {
			$data['gixocnotifications_logs'] = $this->request->post['gixocnotifications_logs'];
		} else {
			$data['gixocnotifications_logs'] = $this->config->get('gixocnotifications_logs');
		}

		foreach ($data['messengers'] as $messenger) {
			$data['entry_' . $messenger . '_key'] = $this->language->get('entry_' . $messenger . '_key');
			$data['entry_get_token_' . $messenger] = $this->language->get('entry_get_token_' . $messenger);
			$data['error_' . $messenger] = $this->language->get('error_' . $messenger);

			if (isset($this->request->post['gixocnotifications_' . $messenger . '_key'])) {
				$data['gixocnotifications_' . $messenger . '_key'] = $this->request->post['gixocnotifications_' . $messenger . '_key'];
			} else {
				$data['gixocnotifications_' . $messenger . '_key'] = $this->config->get('gixocnotifications_' . $messenger . '_key');
			}

			if (isset($this->request->post['gixocnotifications_' . $messenger . '_webhook'])) {
				$data['gixocnotifications_' . $messenger . '_webhook'] = $this->request->post['gixocnotifications_' . $messenger . '_webhook'];
			} else {
				$data['gixocnotifications_' . $messenger . '_webhook'] = $this->config->get('gixocnotifications_' . $messenger . '_webhook');
			}

			if (isset($this->request->post['gixocnotifications_' . $messenger . '_timeout'])) {
				$data['gixocnotifications_' . $messenger . '_timeout'] = $this->request->post['gixocnotifications_' . $messenger . '_timeout'];
			} else {
				$data['gixocnotifications_' . $messenger . '_timeout'] = $this->config->get('gixocnotifications_' . $messenger . '_timeout');
			}

			if (isset($this->request->post['gixocnotifications_' . $messenger . '_trim_messages'])) {
				$data['gixocnotifications_' . $messenger . '_trim_messages'] = $this->request->post['gixocnotifications_' . $messenger . '_trim_messages'];
			} else {
				$data['gixocnotifications_' . $messenger . '_trim_messages'] = $this->config->get('gixocnotifications_' . $messenger . '_trim_messages');
			}

			$data['logs_file'][$messenger] = $this->readlogs('gixocnotifications_' . $messenger . '.log');
		}

		$data['token'] = $this->session->data['token'];
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$telegram = new Telegram($data['gixocnotifications_telegram_key'], 5);
		$this->get_telegram = $telegram->get_telegram();
		$data['get_telegram'] = $this->get_telegram;

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['ordervar'] = $this->ordervar();
		$data['customervar'] = $this->customervar();
		$data['affiliatevar'] = $this->affiliatevar();
		$data['reviewvar'] = $this->reviewvar();
		$data['returnvar'] = $this->returnvar();

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('user/user');
		$data['users'] = $this->model_user_user->getUsers(array());

		$data['ssl'] = $this->ssl;

		$data['logs'] = array(
			'0' => $this->language->get('text_log_off'),
			'1' => $this->language->get('text_log_small'),
			'2' => $this->language->get('text_log_all')
		);

		$this->response->setOutput($this->load->view('extension/module/gixocnotifications', $data));
	}

	public function set_webhook(){
		$json = array();

		// Check user has permission
		if ((!$this->user->hasPermission('modify', 'extension/module/gixocnotifications')) || (!isset($this->request->post['key'])) || (!isset($this->request->post['bot_key']))) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			if ((!empty($this->request->post['key'])) && (!empty($this->request->post['bot_key']))) {
				if (($this->request->post['key']) == 'telegram') {
					$timeout = !empty($this->request->post['timeout']) ? $this->request->post['timeout'] : '5';
					$telegram = new Telegram($this->request->post['bot_key'], $timeout);
					if ($this->ssl) {
						$telegram->setWebhook(HTTPS_CATALOG . 'gixocnotifications-webhook-telegram/');
						$response = $telegram->getWebhookInfo();
						if ((isset($response['url'])) && (($response['url']) == HTTPS_CATALOG . 'gixocnotifications-webhook-telegram/')) {
							$json['webhook'] = 'tg://resolve?domain=' . $telegram->getBotInfo()['username'];
							$json['success'] = $this->language->get('text_token');
							$this->load->model('extension/module/gixocnotifications');
							$this->model_extension_module_gixocnotifications->editSettingValue('gixocnotifications', 'gixocnotifications_telegram_key', $this->request->post['bot_key']);
							$this->model_extension_module_gixocnotifications->editSettingValue('gixocnotifications', 'gixocnotifications_telegram_webhook', $json['webhook']);
						}
					}
				} elseif (($this->request->post['key']) == 'viber') {
					if ($this->ssl) {
						$timeout = !empty($this->request->post['timeout']) ? $this->request->post['timeout'] : '5';
						$viber = new Viber($this->request->post['bot_key'], $timeout);
						$viber->setWebhook(HTTPS_CATALOG . 'gixocnotifications-webhook-viber');
						$response = $viber->getWebhookInfo();
						if ((isset($response['webhook'])) && (($response['webhook']) == HTTPS_CATALOG . 'gixocnotifications-webhook-viber')) {
							$json['webhook'] = 'viber://pa/info?uri=' . $response['uri'];
							$json['success'] = $this->language->get('text_token');
							$this->load->model('extension/module/gixocnotifications');
							$this->model_extension_module_gixocnotifications->editSettingValue('gixocnotifications', 'gixocnotifications_viber_key', $this->request->post['bot_key']);
							$this->model_extension_module_gixocnotifications->editSettingValue('gixocnotifications', 'gixocnotifications_viber_webhook', $json['webhook']);
						}
					}
				}
			}
		}

		if (!isset($json['success'])) {
			$json['error'] = $this->language->get('error_token');
		}

		if (!isset($json['webhook'])) {
			$json['webhook'] = false;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function ordervar() {
		$temp = array();
		$temp['{order_id}'] = $this->language->get('text_order_id'); 
		$temp['{store_name}'] = $this->language->get('text_store_name');
		$temp['{customer_firstname}'] = $this->language->get('text_firstname');
		$temp['{customer_lastname}'] = $this->language->get('text_lastname');
		$temp['{customer_email}'] = $this->language->get('text_email');
		$temp['{customer_telephone}'] = $this->language->get('text_telephone');
		$temp['{customer_group}'] = $this->language->get('text_customer_groups');
		$temp['{payment_address}'] = $this->language->get('text_payment_address');
		$temp['{payment_method}'] = $this->language->get('text_payment_method');
		$temp['{shipping_address}'] = $this->language->get('text_shipping_address');
		$temp['{shipping_method}'] = $this->language->get('text_shipping_method');
		$temp['{total}'] = $this->language->get('text_total');
		$temp['{comment}'] = $this->language->get('text_comment');
		$temp['{order_status}'] = $this->language->get('text_orders_status');
		$temp['{date_added}'] = $this->language->get('text_date_added');
		$temp['{date_modified}'] = $this->language->get('text_date_modified');

		return $temp;
	}

	private function customervar() {
		$temp = array();
		$temp['{store_name}'] = $this->language->get('text_store_name');
		$temp['{customer_firstname}'] = $this->language->get('text_firstname');
		$temp['{customer_lastname}'] = $this->language->get('text_lastname');
		$temp['{customer_group}'] = $this->language->get('text_customer_groups');
		$temp['{customer_email}'] = $this->language->get('text_email');
		$temp['{customer_telephone}'] = $this->language->get('text_telephone');
		$temp['{date_added}'] = $this->language->get('text_date_added');

		return $temp;
	}

	private function affiliatevar() {
		$temp = array();
		$temp['{store_name}'] = $this->language->get('text_store_name');
		$temp['{affiliate_firstname}'] = $this->language->get('text_firstname');
		$temp['{affiliate_lastname}'] = $this->language->get('text_lastname');
		$temp['{affiliate_email}'] = $this->language->get('text_email');
		$temp['{affiliate_telephone}'] = $this->language->get('text_telephone');
		$temp['{affiliate_website}'] = $this->language->get('text_website');
		$temp['{affiliate_company}'] = $this->language->get('text_company');
		$temp['{date_added}'] = $this->language->get('text_date_added');

		return $temp;
	}

	private function reviewvar() {
		$temp = array();
		$temp['{store_name}'] = $this->language->get('text_store_name');
		$temp['{name}'] = $this->language->get('text_firstname');
		$temp['{review}'] = $this->language->get('text_review');
		$temp['{rating}'] = $this->language->get('text_rating');
		$temp['{product_name}'] = $this->language->get('text_product_name');
		$temp['{product_model}'] = $this->language->get('text_product_model');
		$temp['{product_sku}'] = $this->language->get('text_product_sku');
		$temp['{date_added}'] = $this->language->get('text_date_added');

		return $temp;
	}

	private function returnvar() {
		$temp = array();
		$temp['{store_name}'] = $this->language->get('text_store_name');
		$temp['{customer_firstname}'] = $this->language->get('text_firstname');
		$temp['{customer_lastname}'] = $this->language->get('text_lastname');
		$temp['{customer_email}'] = $this->language->get('text_email');
		$temp['{customer_telephone}'] = $this->language->get('text_telephone');
		$temp['{order_id}'] = $this->language->get('text_order_id'); 
		$temp['{date_ordered}'] = $this->language->get('text_date_ordered');
		$temp['{product_name}'] = $this->language->get('text_product_name');
		$temp['{product_model}'] = $this->language->get('text_product_model');
		$temp['{product_quantity}'] = $this->language->get('text_product_quantity');
		$temp['{return_reason}'] = $this->language->get('text_return_reason');
		$temp['{opened}'] = $this->language->get('text_return_opened');
		$temp['{comment}'] = $this->language->get('text_comment');
		$temp['{date_added}'] = $this->language->get('text_date_added');

		return $temp;
	}

	private function readlogs($filename) {
		$file = DIR_LOGS . $filename;

		if (!is_file($file)) {
			return '';
		}

		if (file_exists($file)) {
			return htmlentities(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
		} else {
			return '';
		}
	}

	public function clearLog() {
		$json = array();

		if ((!$this->user->hasPermission('modify', 'extension/module/gixocnotifications')) || (!isset($this->request->post['key']))) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$key = $this->request->post['key'];

			if ($key == 'telegram') {
				$file = DIR_LOGS . 'gixocnotifications_telegram.log';
			} elseif ($key == 'viber') {
				$file = DIR_LOGS . 'gixocnotifications_viber.log';
			} else {
				$file = false;
			}

			if ($file) {
				$handle = @fopen($file, 'w+');

				fclose($handle);

				$json['success'] = $this->language->get('text_clear_log_success');
			} else {
				$json['error'] = $this->language->get('error_permission');
			}
		}

		if (!$json) {
			$json['error'] = $this->language->get('error_permission');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function downloadLog() {
		$json = array();

		if ((!$this->user->hasPermission('modify', 'extension/module/gixocnotifications')) || (!isset($this->request->get['key']))) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$key = $this->request->get['key'];

			if ($key == 'telegram') {
				$file = DIR_LOGS . 'gixocnotifications_telegram.log';
			} elseif ($key == 'viber') {
				$file = DIR_LOGS . 'gixocnotifications_viber.log';
			} else {
				$file = false;
			}

			if (file_exists($file) && filesize($file) > 0) {
				$json['success'] = 'ok';
			} else {
				$json['error'] = sprintf($this->language->get('error_warning'), basename($file), '0B');
			}
		}

		if (isset($json['success'])) {
			$this->response->addHeader('Pragma: public');
			$this->response->addHeader('Expires: 0');
			$this->response->addHeader('Content-Description: File Transfer');
			$this->response->addHeader('Content-Type: application/octet-stream');
			$this->response->addHeader('Content-Disposition: attachment; filename="gixocnotifications_' . $key . '_error_' . date('Y-m-d_H-i-s', time()) . '.log"');
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->response->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
		}

		if (!$json) {
			$json['error'] = sprintf($this->language->get('error_warning'), basename($file), '0B');
		}

		if (!isset($json['success'])) {
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}

	public function install(){
		$this->load->model('extension/event');

		$this->model_extension_event->addEvent('GixOCNotificationsNewOrder', 'catalog/controller/checkout/success/before', 'extension/module/gixocnotifications/new_order');
		$this->model_extension_event->addEvent('GixOCNotificationsNewCustomer', 'catalog/model/account/customer/addCustomer/after', 'extension/module/gixocnotifications/new_customer');
		$this->model_extension_event->addEvent('GixOCNotificationsNewAffiliate', 'catalog/model/affiliate/affiliate/addAffiliate/after', 'extension/module/gixocnotifications/new_affiliate');
		$this->model_extension_event->addEvent('GixOCNotificationsNewReview', 'catalog/model/catalog/review/addReview/before', 'extension/module/gixocnotifications/new_review');
		$this->model_extension_event->addEvent('GixOCNotificationsOrders', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/module/gixocnotifications/orders');
		$this->model_extension_event->addEvent('GixOCNotificationsNewReturn ', 'catalog/model/account/return/addReturn/after', 'extension/module/gixocnotifications/new_return');

		$this->load->model('extension/module/gixocnotifications');
		$data = array();

		foreach ($this->messengers as $messenger) {
			$url_alias_info = $this->model_extension_module_gixocnotifications->get('webhook_' . $messenger);
			if (empty($url_alias_info) || (isset($url_alias_info['query']) && ($url_alias_info['query'] != 'extension/module/gixocnotifications/webhook_' . $messenger))) {
				$data['extension/module/gixocnotifications/webhook_' . $messenger] = 'gixocnotifications-webhook-' . $messenger;
			}
		}

		$this->model_extension_module_gixocnotifications->write($data);
	}

	public function uninstall(){
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('gixocnotifications');

		$this->load->model('extension/event');
		$this->model_extension_event->deleteEvent('GixOCNotificationsNewOrder');
		$this->model_extension_event->deleteEvent('GixOCNotificationsNewCustomer');
		$this->model_extension_event->deleteEvent('GixOCNotificationsNewAffiliate');
		$this->model_extension_event->deleteEvent('GixOCNotificationsNewReview');
		$this->model_extension_event->deleteEvent('GixOCNotificationsOrders');
		$this->model_extension_event->deleteEvent('GixOCNotificationsNewReturn');

		$this->load->model('extension/module/gixocnotifications');

		foreach ($this->messengers as $messenger) {
			$this->model_extension_module_gixocnotifications->delete('gixocnotifications-webhook-' . $messenger);
		}
	}	

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/gixocnotifications')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}