<?php
use_helper('Javascript');

$json = array(
  'member_id_to' => $member->getId(),
  'message_list_api' => app_url_for('api', 'message_list_json'),
  'message_post_api' => app_url_for('api', 'message_post_json'),
);

echo javascript_tag('
var message = '.json_encode($json, defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0).';
')
?>
<?php use_javascript('/opMessagePlugin/js/smt_message.js') ?>
<?php include_javascripts() ?>
<div class="row" style="margin-bottom: 8px;">
  <div class="gadget_header span12"><?php echo __('Private Messages between %1% and %2%', array('%1%' => $member->getName(), '%2%' => $sf_user->getMember()->getName())); ?></div>
</div>

<script id="messageListTemplate" type="text/x-jquery-tmpl">
{{if member.self}}
<div class="x-chatItem outgoingItem x-outgoingItem" id="message-${id}">
{{else}}
<div class="x-chatItem incomingItem x-incomingItem" id="message-${id}">
{{/if}}
  <table width="100%">
    <tbody>
      <tr>
        <td valign="top">
          <a href="${member.profile_url}"><img src="${member.profile_image}" alt="" title="${member.name}" class="x-avatar"></a>
          <div class="x-myBubble">
            <div class="x-indicator"></div>
            <table class="x-tableBubble" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td class="x-tl"></td>
                  <td class="x-tr"></td>
	        </tr>
                <tr>
                  <td class="x-message">
                    ${body}
                    <div class="x-timeStamp">${member.name} @ ${created_at}</div>
                  </td>
                  <td class="x-messageRight"></td>
                </tr>
                <tr>
                  <td class="x-bl"></td>
                  <td class="x-br"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

</script>

<div id="messageList" class="hide" style="padding-bottom: 35px;">
</div>


<div id="messageListLoading" class="center">
<?php echo op_image_tag('ajax-loader.gif', array()) ?>
</div>


<div style="position: fixed; left: 0px; bottom: 0; width: 100%; background: #000000;">
<div class="center">
  <input type="text" name="text" id="messageSendText" value="" style="height: 25px;"/> <input id="messageSendButton" type="submit" name="submit" class="btn primary small" value="送信" style="height: 25px; width: 45px; padding-top: 5px;" />
</div>
</div>
