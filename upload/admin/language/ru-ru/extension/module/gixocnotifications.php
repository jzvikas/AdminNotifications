<?php
// Heading
$_['heading_title']                 = '<a href="https://gixoc.ru">GixOC.ru</a> - <b>Уведомления администратора (Telegram, Viber)</b>';
$_['text_title']                    = 'GixOC.ru - Уведомления администратора (Telegram, Viber)';

// Text
$_['text_module']                   = 'Модули';
$_['text_success']                  = 'Настройки сохранены';
$_['text_token']                    = 'Проверка токена прошла успешно!';
$_['text_edit']                     = 'Настройки';
$_['text_cut']                      = 'Обрезать';
$_['text_split']                    = 'Разбивать';
//Vars
$_['text_order_id']                 = 'Номер заказа';
$_['text_store_name']               = 'Название магазина';
$_['text_firstname']                = 'Имя';
$_['text_lastname']                 = 'Фамилия';
$_['text_email']                    = 'E-mail';
$_['text_telephone']                = 'Телефон';
$_['text_customer_groups']          = 'Группа покупателя';
$_['text_payment_address']          = 'Адрес оплаты';
$_['text_payment_method']           = 'Способ оплаты';
$_['text_shipping_address']         = 'Адрес доставки';
$_['text_shipping_method']          = 'Способ доставки';
$_['text_total']                    = 'Итого';
$_['text_comment']                  = 'Комментарий к заказу';
$_['text_orders_status']            = 'Статус заказа';
$_['text_date_added']               = 'Дата и время добавления';
$_['text_date_modified']            = 'Дата и время изменения';
$_['text_company']                  = 'Компания';
$_['text_website']                  = 'Веб-сайт';
$_['text_review']                   = 'Отзыв';
$_['text_rating']                   = 'Оценка';
$_['text_product_name']             = 'Название товара';
$_['text_product_model']            = 'Модель товара';
$_['text_product_sku']              = 'Артикул товара';
$_['text_product_quantity']         = 'Количество';
$_['text_date_ordered']             = 'Дата заказа';
$_['text_return_reason']            = 'Причина возврата';
$_['text_return_opened']            = 'Товар распакован (Да/Нет)';
$_['text_log_off']                  = 'Выключены';
$_['text_log_small']                = 'Только ошибки';
$_['text_log_all']                  = 'Полные (все запросы: успешные и ошибочные + тест уведомлений)';
$_['text_clear_log_success']        = 'Логи успешно очищены!';
$_['text_developer']                = 'Разработчик';

// Button
$_['button_verify']                 = 'Проверить';

// Tab
$_['tab_general']                   = 'Общие';
$_['tab_template']                  = 'Шаблоны уведомлений';
$_['tab_users']                     = 'Настройки пользователей';
$_['tab_logs']                      = 'Логи';
$_['tab_support']                   = 'Поддержка';

// Legend
$_['legend_new_order']              = 'Шаблон уведомления о новом заказе';
$_['legend_new_customer']           = 'Шаблон уведомления о новом покупателе';
$_['legend_new_affiliate']          = 'Шаблон уведомления о новом партнере';
$_['legend_new_review']             = 'Шаблон уведомления о новом отзыве';
$_['legend_new_return']             = 'Шаблон уведомления о новом возврате';
$_['legend_orders']                 = 'Шаблоны уведомлений о статусах заказа';

// Column
$_['column_use']                    = 'Использовать';
$_['column_ip']                     = 'IP-адрес';
$_['column_port']                   = 'Порт';
$_['column_login']                  = 'Логин';
$_['column_password']               = 'Пароль';
$_['column_user']                   = 'Администратор';
$_['column_id']                     = ' ID';
$_['column_new']                    = 'Уведомлять о новом';
$_['column_orders']                 = 'Уведомлять о заказе';
$_['column_new_order']              = 'заказе';
$_['column_new_customer']           = 'покупателе';
$_['column_new_affiliate']          = 'партнере';
$_['column_new_review']             = 'отзыве';
$_['column_new_return']             = 'возврате';

// Entry
$_['entry_status']                  = 'Статус';
$_['entry_wait']                    = 'Пожалуйста, подождите...';
//Telegram
$_['entry_telegram_key']            = 'Telegram Bot Ключ (токен)';
$_['entry_get_token_telegram']      = 'Как получить Telegram Bot Ключ (токен)';
//Viber
$_['entry_viber_key']               = 'Viber Bot Ключ (токен)';
$_['entry_get_token_viber']         = 'Как получить Viber Bot Ключ (токен)';

// Help
$_['help_new_order']                = 'Здесь можно настроить шаблон уведомления о новом заказе (со страницы %sindex.php?route=checkout/success)';
$_['help_new_order_ex']             = 'Вы получили новый заказ №{order_id}, магазин {store_name}, номер телефона: {customer_telephone}, e-mail покупателя: {customer_email}';
$_['help_orders']                   = 'Здесь можно настроить индивидуальный шаблон уведомлений для любого статуса заказа';
$_['help_orders_ex']                = 'Статус заказа №{order_id} изменился на {order_status}';
$_['help_new_customer']             = 'Здесь можно настроить шаблон уведомления о регистрации нового покупателя';
$_['help_new_customer_ex']          = 'Зарегистрировался новый покупатель: {customer_firstname}, номер телефона: {customer_telephone}, e-mail покупателя: {customer_email}';
$_['help_new_affiliate']            = 'Здесь можно настроить шаблон уведомления о регистрации нового партнера';
$_['help_new_affiliate_ex']         = 'Зарегистрировался новый партнер: {affiliate_firstname}, номер телефона: {affiliate_telephone}, e-mail покупателя: {affiliate_email}';
$_['help_new_review']               = 'Здесь можно настроить шаблон уведомления о новом отзыве к товару';
$_['help_new_review_ex']            = 'Вы получили новый отзыв к товару {product_name} (артикул {product_sku}) от покупателя {name}. Текст отзыва: {review}';
$_['help_new_return']               = 'Здесь можно настроить шаблон уведомления о новом возврате';
$_['help_new_return_ex']            = 'Покупатель {customer_firstname} запросил возврат товара {product_name} (модель {product_model}), заказ № {order_id}. Комментарий от покупателя: "{comment}"';
$_['help_module']                   = 'Инструкция по настройке модуля';
$_['help_bot_telegram']             = '<a href="https://gixoc.ru/blog/get_bot_telegram/">Создать бота в Telegram — GixOС.ru</a>';
$_['help_bot_viber']                = '<a href="https://gixoc.ru/blog/get_bot_viber/">Создать бота в Viber — GixOС.ru</a>';
$_['help_trim_messages']            = 'Длинное сообщение';
$_['help_timeout']                  = 'Таймаут соединения';
$_['help_id_telegram']              = 'Как получить ID пользователя в Telegram';
$_['help_id_viber']                 = 'Как получить ID пользователя в Viber';
$_['help_log']                      = 'Лог';
$_['help_license']                  = 'Лицензия';
$_['help_thanks']                   = 'Поблагодарить';
$_['help_faq']                      = 'Часто Задаваемые Вопросы';
$_['help_support']                  = 'Поддержка';

// Error
$_['error_telegram']                = ' <b>К сожалению, Telegram не доступен.</b> Скорее всего, серверы вашего хостинг-провайдера расположены на территории Российской Федерации, в которой, по требованию Роскомнадзора, заблокирован Telegram. Советуем Вам использовать метод уведомления по Viber.';
$_['error_token']                   = 'Неправильный Bot Token!';
//Error Viber
$_['error_viber']                   = ' <b>К сожалению, Viber требует наличия у сайта защищенного соединения.</b> Советуем Вам <a target="_blank" href="http://forum.opencart.pro/topic/5083-%D1%80%D1%83%D0%BA%D0%BE%D0%B2%D0%BE%D0%B4%D1%81%D1%82%D0%B2%D0%BE-%D0%B4%D0%BB%D1%8F-%D0%BF%D0%B5%D1%80%D0%B5%D1%85%D0%BE%D0%B4%D0%B0-%D0%BD%D0%B0-ssl-https-v20/"> перейти на использование SSL</a>.';
$_['error_warning']                 = 'Внимание: Ваш  файл ошибок %s имеет размер %s!';
$_['error_permission']              = 'У вас нет прав для управления модулем ' . $_['heading_title'] .'!';