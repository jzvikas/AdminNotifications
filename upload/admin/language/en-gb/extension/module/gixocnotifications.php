<?php
// Heading
$_['heading_title']                 = '<a href="https://gixoc.ru">GixOC.ru</a> - <b>Admin Notifications (Telegram, Viber)</b>';
$_['text_title']                    = 'GixOC.ru - Admin Notifications (Telegram, Viber)';

// Text
$_['text_module']                   = 'Modules';
$_['text_success']                  = 'Settings saved';
$_['text_token']                    = 'Token verification was successful!';
$_['text_edit']                     = 'Settings';
$_['text_cut']                      = 'Cut';
$_['text_split']                    = 'Split';
//Vars
$_['text_order_id']                 = 'Number order';
$_['text_store_name']               = 'Store Name';
$_['text_firstname']                = 'Firstname';
$_['text_lastname']                 = 'Lastname';
$_['text_email']                    = 'E-mail';
$_['text_telephone']                = 'Telephone';
$_['text_customer_groups']          = 'Customer groups';
$_['text_payment_address']          = 'Payment address';
$_['text_payment_method']           = 'Payment method';
$_['text_shipping_address']         = 'Shipping address';
$_['text_shipping_method']          = 'Shipping method';
$_['text_total']                    = 'Total';
$_['text_comment']                  = 'Comment';
$_['text_orders_status']            = 'Order status';
$_['text_date_added']               = 'Date added';
$_['text_date_modified']            = 'Date modified';
$_['text_company']                  = 'Company';
$_['text_website']                  = 'Website';
$_['text_review']                   = 'Review';
$_['text_rating']                   = 'Rating';
$_['text_product_name']             = 'Product Name';
$_['text_product_model']            = 'Product Code';
$_['text_product_sku']              = 'Product Sku';
$_['text_product_quantity']         = 'Quantity';
$_['text_date_ordered']             = 'Order Date';
$_['text_return_reason']            = 'Reason for Return';
$_['text_return_opened']            = 'Product is opened (Yes/No)';
$_['text_log_off']                  = 'Off';
$_['text_log_small']                = 'Only requests';
$_['text_log_all']                  = 'Full (requests + notification test)';
$_['text_clear_log_success']        = 'Logs successfully cleared!';
$_['text_developer']                = 'Developer';

// Button
$_['button_verify']                 = 'Verify';

// Tab
$_['tab_general']                   = 'Design';
$_['tab_template']                  = 'Template Notifications';
$_['tab_users']                     = 'Setting users';
$_['tab_logs']                      = 'Logs';
$_['tab_support']                   = 'Support';

// Legend
$_['legend_new_order']              = 'Notification of new order';
$_['legend_new_customer']           = 'Notification of new customer';
$_['legend_new_affiliate']          = 'Notification of new affiliate';
$_['legend_new_review']             = 'Notification of new review';
$_['legend_new_return']             = 'Notification of new return';
$_['legend_orders']                 = 'Notification of status orders';

// Column
$_['column_use']                    = 'On/Off';
$_['column_ip']                     = 'IP';
$_['column_port']                   = 'Port';
$_['column_login']                  = 'Login';
$_['column_password']               = 'Password';
$_['column_user']                   = 'User';
$_['column_id']                     = ' ID';
$_['column_new']                    = 'Notification of new';
$_['column_orders']                 = 'Notification of order';
$_['column_new_order']              = 'order';
$_['column_new_customer']           = 'customer';
$_['column_new_affiliate']          = 'affiliate';
$_['column_new_review']             = 'review';
$_['column_new_return']             = 'return';

// Entry
$_['entry_status']                  = 'Status';
$_['entry_wait']                    = 'Please wait...';
//Telegram
$_['entry_telegram_key']            = 'Telegram Bot API Token';
$_['entry_get_token_telegram']      = 'Get your Telegram Token';
//Viber
$_['entry_viber_key']               = 'Viber Bot API Token';
$_['entry_get_token_viber']         = 'Get your Viber Token';

// Help
$_['help_new_order']                = 'New order notification template settings (from page %sindex.php?route=checkout/success)';
$_['help_new_order_ex']             = 'You got a new order #{order_id}, store {store_name}, phone: {customer_telephone}, email: {customer_email}';
$_['help_orders']                   = 'Settings a notification template for every order status';
$_['help_orders_ex']                = 'Status for order #{order_id} has changed to {order_status}';
$_['help_new_customer']             = 'Settings a notification template for customer registration';
$_['help_new_customer_ex']          = 'Created new customer: {customer_firstname}, phone: {customer_telephone}, email: {customer_email}';
$_['help_new_affiliate']            = 'Settings a notification template for affiliate registration';
$_['help_new_affiliate_ex']         = 'Created new affiliate: {affiliate_firstname}, phone: {affiliate_telephone}, email: {affiliate_email}';
$_['help_new_review']               = 'Settings a notification template for new review';
$_['help_new_review_ex']            = 'You have received a new review to the product {product_name} (SKU {product_sku}) from the customer {name}. Review text: "{review}"';
$_['help_new_return']               = 'Settings a notification template for new return';
$_['help_new_return_ex']            = 'Customer {customer_firstname} requested a return of {product_name} (model {product_model}), order no. {order_id}. Comment from customer "{comment}"';
$_['help_module']                   = 'Instructions for setting module (only in Russian language)';
$_['help_bot_telegram']             = '<a href="https://gixoc.ru/blog/get_bot_telegram/">Create a bot in Telegram — GixOС.ru</a> (only in Russian language)';
$_['help_bot_viber']                = '<a href="https://gixoc.ru/blog/get_bot_viber/">Create a bot in  Viber — GixOС.ru</a> (only in Russian language)';
$_['help_trim_messages']            = 'Long message';
$_['help_timeout']                  = 'Connection timeout';
$_['help_proxy']                    = 'Proxy';
$_['help_id_telegram']              = 'How to get user ID in Telegram ';
$_['help_id_viber']                 = 'How to get user ID in в Viber';
$_['help_log']                      = 'Log';
$_['help_license']                  = 'License';
$_['help_thanks']                   = 'Thanks';
$_['help_faq']                      = 'Frequently Asked Questions';
$_['help_support']                  = 'Support';

// Error
$_['error_telegram']                = ' <b>Sorry, Telegram is not available.</b> Most likely, the servers of your hosting provider are located in the Russian Federation, where, at the request of Roskomnadzor, Telegram is blocked. We advise you to use the Viber notification method.';
$_['error_token']                   = 'The authentication Bot Token is not valid!';
//Error Viber
$_['error_viber']                   = ' <b>Sorry, Viber requires a secure connection to the site.</b> We advise you <a target="_blank" href="http://forum.opencart.pro/topic/5083-%D1%80%D1%83%D0%BA%D0%BE%D0%B2%D0%BE%D0%B4%D1%81%D1%82%D0%B2%D0%BE-%D0%B4%D0%BB%D1%8F-%D0%BF%D0%B5%D1%80%D0%B5%D1%85%D0%BE%D0%B4%D0%B0-%D0%BD%D0%B0-ssl-https-v20/"> to switch to SSL</a>.';
$_['error_warning']                 = 'Warning: Your error log file %s is %s!';
$_['error_permission']              = 'Warning: You do not have permission to modify module ' . $_['heading_title'] .'!';