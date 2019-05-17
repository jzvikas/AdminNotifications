<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-gixocnotifications" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-gixocnotifications" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-cog"></i> <?php echo $tab_general; ?></a></li>
            <li><a href="#tab-users" data-toggle="tab"><i class="fa fa-users"></i> <?php echo $tab_users; ?></a></li>
            <li><a href="#tab-template" data-toggle="tab"><i class="fa fa-envelope"></i> <?php echo $tab_template; ?></a></li>
            <li><a href="#tab-logs" data-toggle="tab"><i class="fa fa-book"></i> <?php echo $tab_logs; ?></a></li>
            <li><a href="#tab-help" data-toggle="tab" class="btn btn-info" style="color: #424242;"><b><i class="fa fa-life-ring"></i> <?php echo $tab_support; ?></b></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="gixocnotifications_status" id="input-status" class="form-control">
                  <?php if ($gixocnotifications_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <fieldset>
                <legend>Telegram</legend>
                <?php if (!$get_telegram) { ?>
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>  <?php echo $error_telegram; ?></div>
                <?php } else { ?>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="gixocnotifications_telegram_key"><?php echo $entry_telegram_key; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="gixocnotifications_telegram_key" value="<?php echo $gixocnotifications_telegram_key; ?>" placeholder="<?php echo $entry_telegram_key; ?>" id="telegram_key" class="form-control" />
                  </div>
                  <div class="col-sm-2" id="telegram_webhook">
                    <a class="btn btn-primary" onclick="webhook('telegram');"><i class="fa fa-retweet"></i> <?php echo $button_verify; ?></a>
                  </div>
                </div>
                <div class="form-group">
                  <input type="hidden" name="gixocnotifications_telegram_webhook" value="<?php echo !empty($gixocnotifications_telegram_webhook) ? $gixocnotifications_telegram_webhook : 'false' ?>" />
                  <label class="col-sm-2 control-label"><?php echo $help_trim_messages; ?></label>
                  <div class="col-sm-4">
                    <label class="radio-inline">
                      <?php if ($gixocnotifications_telegram_trim_messages) { ?>
                      <input type="radio" name="gixocnotifications_telegram_trim_messages" value="1" checked="checked" />
                      <?php echo $text_cut; ?>
                      <?php } else { ?>
                      <input type="radio" name="gixocnotifications_telegram_trim_messages" value="1" />
                      <?php echo $text_cut; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$gixocnotifications_telegram_trim_messages) { ?>
                      <input type="radio" name="gixocnotifications_telegram_trim_messages" value="0" checked="checked" />
                      <?php echo $text_split; ?>
                      <?php } else { ?>
                      <input type="radio" name="gixocnotifications_telegram_trim_messages" value="0" />
                      <?php echo $text_split; ?>
                      <?php } ?>
                    </label>
                  </div>
                  <label class="col-sm-2 control-label"><?php echo $help_timeout; ?></label>
                  <div class="col-sm-4">
                    <input type="text" name="gixocnotifications_telegram_timeout" value="<?php echo !empty($gixocnotifications_telegram_timeout) ? $gixocnotifications_telegram_timeout : '5' ?>" placeholder="<?php echo $help_timeout; ?>"  class="form-control" />
                  </div>
                </div>
              <?php } ?>
              </fieldset>
              <fieldset>
                <legend>Viber</legend>
                <?php if (!$ssl) { ?>        
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>  <?php echo $error_viber; ?></div>
                <?php } else { ?>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-viber"><?php echo $entry_viber_key; ?></label>
                  <div class="col-sm-8">
                    <input type="text" name="gixocnotifications_viber_key" value="<?php echo $gixocnotifications_viber_key; ?>" placeholder="<?php echo $entry_viber_key; ?>" id="viber_key" class="form-control" />
                  </div>
                  <div class="col-sm-2">
                    <a class="btn btn-primary" onclick="webhook('viber');"><i class="fa fa-retweet"></i> <?php echo $button_verify; ?></a>
                  </div>
                </div>
                <div class="form-group">
                <input type="hidden" name="gixocnotifications_viber_webhook" value="<?php echo !empty($gixocnotifications_viber_webhook) ? $gixocnotifications_viber_webhook : 'false' ?>" />
                  <label class="col-sm-2 control-label"><?php echo $help_trim_messages; ?></label>
                  <div class="col-sm-4">
                    <label class="radio-inline">
                      <?php if ($gixocnotifications_viber_trim_messages) { ?>
                      <input type="radio" name="gixocnotifications_viber_trim_messages" value="1" checked="checked" />
                      <?php echo $text_cut; ?>
                      <?php } else { ?>
                      <input type="radio" name="gixocnotifications_viber_trim_messages" value="1" />
                      <?php echo $text_cut; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$gixocnotifications_viber_trim_messages) { ?>
                      <input type="radio" name="gixocnotifications_viber_trim_messages" value="0" checked="checked" />
                      <?php echo $text_split; ?>
                      <?php } else { ?>
                      <input type="radio" name="gixocnotifications_viber_trim_messages" value="0" />
                      <?php echo $text_split; ?>
                      <?php } ?>
                    </label>
                  </div>
                  <label class="col-sm-2 control-label"><?php echo $help_timeout; ?></label>
                  <div class="col-sm-4">
                    <input type="text" name="gixocnotifications_viber_timeout" value="<?php echo !empty($gixocnotifications_viber_timeout) ? $gixocnotifications_viber_timeout : '5' ?>" placeholder="<?php echo $help_timeout; ?>"  class="form-control" />
                  </div>
                </div>
                <?php } ?>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-users">
              <ul class="nav nav-tabs">
              <?php foreach ($messengers as $keys => $messenger) { ?>
                <li <?php if ($keys == '1') { ?> class="active"<?php } ?>><a href="#tab-<?php echo $messenger; ?>_users" data-toggle="tab"><?php echo $messengers_text[$keys]; ?></a></li>
              <?php } ?>
              </ul>
              <div class="tab-content">
              <?php foreach ($messengers as $keys => $messenger) { ?>
                <div class="tab-pane <?php if ($keys == '1') { ?> active <?php } ?>required" id="tab-<?php echo $messenger; ?>_users">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td rowspan="2" class="text-right"><?php echo $column_user; ?></td>
                        <td rowspan="2" class="text-right control-label"><?php echo $messenger; ?><?php echo $column_id; ?></td>
                        <td colspan="5" class="text-center"><?php echo $column_new; ?></td>
                      </tr>
                      <tr>
                        <td class="text-center"><?php echo $column_new_order; ?></td>
                        <td class="text-center"><?php echo $column_new_customer; ?></td>
                        <td class="text-center"><?php echo $column_new_affiliate; ?></td>
                        <td class="text-center"><?php echo $column_new_review; ?></td>
                        <td class="text-center"><?php echo $column_new_return; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($users as $user) { ?>
                      <tr>
                        <td class="text-left"><?php echo $user['username']; ?></td>
                        <td><input type="text" name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][id_<?php echo $messenger; ?>]" value="<?php echo !empty($gixocnotifications_userdata[$user['user_id']]['id_' . $messenger]) ? $gixocnotifications_userdata[$user['user_id']]['id_' . $messenger] : '' ?>" placeholder="<?php echo $messenger; ?><?php echo $column_id; ?>"  class="form-control" />
                        </td>
                        <?php if (isset($gixocnotifications_userdata[$user['user_id']]['new_order_' . $messenger])) { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_order_<?php echo $messenger; ?>]" type="checkbox" checked></td>
                        <?php } else { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_order_<?php echo $messenger; ?>]" type="checkbox"></td>
                        <?php } ?>
                        <?php if (isset($gixocnotifications_userdata[$user['user_id']]['new_customer_' . $messenger])) { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_customer_<?php echo $messenger; ?>]" type="checkbox" checked></td>
                        <?php } else { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_customer_<?php echo $messenger; ?>]" type="checkbox"></td>
                        <?php } ?>
                        <?php if (isset($gixocnotifications_userdata[$user['user_id']]['new_affiliate_' . $messenger])) { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_affiliate_<?php echo $messenger; ?>]" type="checkbox" checked></td>
                        <?php } else { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_affiliate_<?php echo $messenger; ?>]" type="checkbox"></td>
                        <?php } ?>
                        <?php if (isset($gixocnotifications_userdata[$user['user_id']]['new_review_' . $messenger])) { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_review_<?php echo $messenger; ?>]" type="checkbox" checked></td>
                        <?php } else { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_review_<?php echo $messenger; ?>]" type="checkbox"></td>
                        <?php } ?>
                        <?php if (isset($gixocnotifications_userdata[$user['user_id']]['new_return_' . $messenger])) { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_return_<?php echo $messenger; ?>]" type="checkbox" checked></td>
                        <?php } else { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']; ?>][new_return_<?php echo $messenger; ?>]" type="checkbox"></td>
                        <?php } ?>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td rowspan="2" class="text-left"><?php echo $column_user; ?></td>
                        <td colspan="<?php echo count($order_statuses); ?>" class="text-center"><?php echo $column_orders; ?></td>
                      </tr>
                      <tr>
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <td class="text-center"><?php echo $order_status['name']; ?></td>  
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($users as $user) { ?>
                      <tr>
                        <td class="text-left"><?php echo $user['username']; ?></td>
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if (isset($gixocnotifications_userdata[$user['user_id']]['orders_' . $messenger][$order_status['order_status_id']])) { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']?>][orders_<?php echo $messenger; ?>][<?php echo $order_status['order_status_id']; ?>]" type="checkbox" checked></td>
                        <?php } else { ?>
                        <td class="text-center"><input name="gixocnotifications_userdata[<?php echo $user['user_id']?>][orders_<?php echo $messenger; ?>][<?php echo $order_status['order_status_id']; ?>]" type="checkbox"></td>
                        <?php } ?> 
                        <?php } ?>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
        <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-template">
              <ul class="nav nav-tabs">
              <?php foreach ($messengers as $keys => $messenger) { ?>
                <li <?php if ($keys == '1') { ?> class="active"<?php } ?>><a href="#tab-<?php echo $messenger; ?>_template" data-toggle="tab"><?php echo $messengers_text[$keys]; ?></a></li>
              <?php } ?>
              </ul>
              <div class="tab-content">
              <?php foreach ($messengers as $keys => $messenger) { ?>
                <div class="tab-pane <?php if ($keys == '1') { ?> active <?php } ?>" id="tab-<?php echo $messenger; ?>_template">
                  <fieldset>
                    <legend><?php echo $legend_new_order; ?> (<?php echo $messengers_text[$keys]; ?>)</legend>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_new_order; ?></div>
                    <div class="form-group required">
                      <div class="col-sm-8">
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group">
                          <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <textarea name="gixocnotifications_langdata[<?php echo $language['language_id']; ?>][new_order_<?php echo $messenger; ?>]" rows="7" placeholder="<?php echo $help_new_order_ex; ?>" class="form-control"><?php echo !empty($gixocnotifications_langdata[$language['language_id']]['new_order_' . $messenger]) ? $gixocnotifications_langdata[$language['language_id']]['new_order_' . $messenger] : $help_new_order_ex; ?></textarea>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="col-sm-4">
                        <table class="table table-bordered table-hover">
                          <tbody>
                            <?php foreach ($ordervar as $key => $list) { ?>
                            <tr>
                              <td class="text-left"><?php echo $key; ?></td>
                              <td class="text-left"><?php echo $list; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </fieldset>
                  <fieldset>
                    <legend><?php echo $legend_new_customer; ?> (<?php echo $messengers_text[$keys]; ?>)</legend>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_new_customer; ?></div>
                    <div class="form-group required">
                      <div class="col-sm-8">
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group">
                          <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <textarea name="gixocnotifications_langdata[<?php echo $language['language_id']; ?>][new_customer_<?php echo $messenger; ?>]" rows="7" placeholder="<?php echo $help_new_customer_ex; ?>" class="form-control"><?php echo !empty($gixocnotifications_langdata[$language['language_id']]['new_customer_' . $messenger]) ? $gixocnotifications_langdata[$language['language_id']]['new_customer_' . $messenger] : $help_new_customer_ex; ?></textarea>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="col-sm-4">
                        <table class="table table-bordered table-hover">
                          <tbody>
                            <?php foreach ($customervar as $key => $list) { ?>
                            <tr>
                              <td class="text-left"><?php echo $key; ?></td>
                              <td class="text-left"><?php echo $list; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </fieldset>
                  <fieldset>
                    <legend><?php echo $legend_new_affiliate; ?> (<?php echo $messengers_text[$keys]; ?>)</legend>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_new_affiliate; ?></div>
                    <div class="form-group required">
                      <div class="col-sm-8">
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group">
                          <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <textarea name="gixocnotifications_langdata[<?php echo $language['language_id']; ?>][new_affiliate_<?php echo $messenger; ?>]" rows="7" placeholder="<?php echo $help_new_affiliate_ex; ?>" class="form-control"><?php echo !empty($gixocnotifications_langdata[$language['language_id']]['new_affiliate_' . $messenger]) ? $gixocnotifications_langdata[$language['language_id']]['new_affiliate_' . $messenger] : $help_new_affiliate_ex; ?></textarea>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="col-sm-4">
                        <table class="table table-bordered table-hover">
                          <tbody>
                            <?php foreach ($affiliatevar as $key => $list) { ?>
                            <tr>
                              <td class="text-left"><?php echo $key; ?></td>
                              <td class="text-left"><?php echo $list; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </fieldset>
                  <fieldset>
                    <legend><?php echo $legend_new_review; ?> (<?php echo $messengers_text[$keys]; ?>)</legend>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_new_review; ?></div>
                    <div class="form-group required">
                      <div class="col-sm-8">
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group">
                          <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <textarea name="gixocnotifications_langdata[<?php echo $language['language_id']; ?>][new_review_<?php echo $messenger; ?>]" rows="7" placeholder="<?php echo $help_new_review_ex; ?>" class="form-control"><?php echo !empty($gixocnotifications_langdata[$language['language_id']]['new_review_' . $messenger]) ? $gixocnotifications_langdata[$language['language_id']]['new_review_' . $messenger] : $help_new_review_ex; ?></textarea>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="col-sm-4">
                        <table class="table table-bordered table-hover">
                          <tbody>
                            <?php foreach ($reviewvar as $key => $list) { ?>
                            <tr>
                              <td class="text-left"><?php echo $key; ?></td>
                              <td class="text-left"><?php echo $list; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </fieldset>
                  <fieldset>
                    <legend><?php echo $legend_new_return; ?> (<?php echo $messengers_text[$keys]; ?>)</legend>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_new_return; ?></div>
                    <div class="form-group required">
                      <div class="col-sm-8">
                        <?php foreach ($languages as $language) { ?>
                        <div class="input-group">
                          <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                          <textarea name="gixocnotifications_langdata[<?php echo $language['language_id']; ?>][new_return_<?php echo $messenger; ?>]" rows="7" placeholder="<?php echo $help_new_return_ex; ?>" class="form-control"><?php echo !empty($gixocnotifications_langdata[$language['language_id']]['new_return_' . $messenger]) ? $gixocnotifications_langdata[$language['language_id']]['new_return_' . $messenger] : $help_new_return_ex; ?></textarea>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="col-sm-4">
                        <table class="table table-bordered table-hover">
                          <tbody>
                            <?php foreach ($returnvar as $key => $list) { ?>
                            <tr>
                              <td class="text-left"><?php echo $key; ?></td>
                              <td class="text-left"><?php echo $list; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </fieldset>
                  <fieldset>
                    <legend><?php echo $legend_orders; ?> (<?php echo $messengers_text[$keys]; ?>)</legend>
                    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_orders; ?></div>
                    <?php foreach ($order_statuses as $order_status) { ?>
                      <div class="form-group required">
                        <div class="col-sm-2">
                          <label><?php echo $order_status['name']; ?></label>
                        </div>
                        <div class="col-sm-6">
                          <?php foreach ($languages as $language) { ?>
                          <div class="input-group">
                            <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                            <textarea name="gixocnotifications_langdata[<?php echo $language['language_id']; ?>][orders_<?php echo $messenger; ?>][<?php echo $order_status['order_status_id']; ?>]" rows="7" placeholder="<?php echo $help_orders_ex; ?>" class="form-control"><?php echo !empty($gixocnotifications_langdata[$language['language_id']]['orders_' . $messenger][$order_status['order_status_id']]) ? $gixocnotifications_langdata[$language['language_id']]['orders_' . $messenger][$order_status['order_status_id']] : $help_orders_ex; ?></textarea>
                          </div>
                          <?php } ?>
                        </div>
                        <div class="col-sm-4">
                          <table class="table table-bordered table-hover">
                            <tbody>
                              <?php foreach ($ordervar as $key => $list) { ?>
                              <tr>
                                <td class="text-left"><?php echo $key; ?></td>
                                <td class="text-left"><?php echo $list; ?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    <?php } ?>           
                  </fieldset>
                </div>
        <?php } ?>
        </div>
           </div>
            <div class="tab-pane" id="tab-logs">
              <ul class="nav nav-tabs">
              <?php foreach ($messengers as $keys => $messenger) { ?>
                <li <?php if ($keys == '1') { ?> class="active"<?php } ?>><a href="#tab-<?php echo $messenger; ?>_logs" data-toggle="tab"><?php echo $messengers_text[$keys]; ?></a></li>
              <?php } ?>
              </ul>
              <div class="tab-content">
              <?php foreach ($messengers as $keys => $messenger) { ?>
                <div class="tab-pane <?php if ($keys == '1') { ?> active <?php } ?>" id="tab-<?php echo $messenger; ?>_logs">
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
                    <div class="col-sm-7">
                      <select name="gixocnotifications_logs[<?php echo $messenger; ?>]" id="input-status" class="form-control">
                      <?php foreach ($logs as $key => $value) { ?>
                        <?php if ($key == $gixocnotifications_logs[$messenger]) { ?>
                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                      <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <a class="btn btn-danger" onclick="clearLog('<?php echo $messenger; ?>');"><i class="fa fa-download"></i> <?php echo $button_delete; ?></a>
                      <a class="btn btn-primary" onclick="downloadLog('<?php echo $messenger; ?>');"><i class="fa fa-download"></i> <?php echo $button_download; ?></a>
                    </div>
                  </div>
                  <div class="form-group">
                    <textarea id="log_<?php echo $messenger; ?>" wrap="on" rows="15" readonly class="form-control"><?php echo $logs_file[$messenger]; ?></textarea>
                  </div>
                </div>
              <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-help">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $text_developer; ?></label>
                <div class="col-sm-10">GixOC: <a target="_blank" href="https://gixoc.ru" class="btn btn-link"><i class="fa fa-globe"></i> GixOC.ru</a>|<a target="_blank" href="tg://resolve?domain=GixOC_NotificationsBot" class="btn btn-link"><i class="fa fa-paper-plane"></i> @GixOC_NotificationsBot</a>|<a target="_blank" href="viber://pa/info?uri=GixOC_NotificationsBot" class="btn btn-link"><i class="fa fa-phone"></i> @GixOC_NotificationsBot</a></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $help_license; ?></label>
                <div class="col-sm-10"><a class="btn btn-link">GNU General Public License version 3 (GPLv3)</a></div>
              </div>
            </div>
          </div>  
        </form>
      </div>
    </div>  
  </div>
</div>
<div data-backdrop="static" id="ModalBox" class="modal fade">
  <div class="modal-dialog" style="width: 90%;">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h3 class="modal-title"><?php echo $entry_wait; ?></h3>
    </div>  
      <div class="modal-body">       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $button_close; ?></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function webhook(key) {
  $(".modal-body").html('');
  $(".modal-title").html('<?php echo $entry_wait; ?>');
  $("#ModalBox").modal('show');
  bot_key = $('#' + key + '_key').val();

  timeout = $('input[name="gixocnotifications_' + key + '_timeout"]').val();

  $.ajax({  
    url: 'index.php?route=extension/module/gixocnotifications/set_webhook&token=<?php echo $token; ?>',
    type: 'post',
    dataType: 'json',
    data: 'key=' + key + '&bot_key=' + bot_key + '&timeout=' + timeout + '&proxydata=' + proxydata,
  success: function(json) {
    if (json['error']) {
        $(".modal-title").html('Error!');
        $(".modal-body").html('<div class="h4" style="color:red;text-align:center;">' + json['error'] + '</div>');
    }
          
    if (json['success']) {
        $(".modal-title").html('Success!');
        $(".modal-body").html('<div class="h4" style="color:green;text-align:center;">' + json['success'] + '</div>');
    }
    
    if (json['webhook']) {
        $('input[name="gixocnotifications_' + key + '_webhook"]').val(json['webhook']);
    }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      $("#ModalBox").modal('hide');
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);    
    }
  });
}
//--></script>
<script type="text/javascript">
function clearLog(key) {
  $(".modal-body").html('');
  $("#ModalBox").modal('show');
  $.ajax({
    url: 'index.php?route=extension/module/gixocnotifications/clearLog&token=<?php echo $token; ?>',
    type: 'post',
  dataType: 'json',
    data: 'key=' + key,
    success: function(json) {
    if (json['error']) {
        $(".modal-title").html('Error!');
        $(".modal-body").html('<div class="h4" style="color:red;text-align:center;">' + json['error'] + '</div>');
    }

    if (json['success']) {
      $('#log_' + key).val('');
        $(".modal-title").html('Success!');
        $(".modal-body").html('<div class="h4" style="color:green;text-align:center;">' + json['success'] + '</div>');
    }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }  
  });
}
//--></script>
<script type="text/javascript"><!--
function downloadLog(key) {
  $(".modal-body").html('');
  $("#ModalBox").modal('show');
  $.ajax({
    url: 'index.php?route=extension/module/gixocnotifications/downloadLog&token=<?php echo $token; ?>' + '&key=' + key,
    type: 'GET',
    success: function(json) {
      if (json['error']) {
        $(".modal-title").html('Error!');
        $(".modal-body").html('<div class="h4" style="color:red;text-align:center;">' + json['error'] + '</div>');
      }
      else {
        $("#ModalBox").modal('hide');
        window.location = 'index.php?route=extension/module/gixocnotifications/downloadLog&token=<?php echo $token; ?>' + '&key=' + key;
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }  
  });
}
//--></script>
<?php echo $footer; ?>