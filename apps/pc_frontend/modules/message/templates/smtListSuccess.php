<script type="text/javascript" src="/opMessagePlugin/js/smt_message_list.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.divlink').pushLink();
});
</script>

<script id="messageReceiveListTemplate" type="text/x-jquery-tmpl">

    <div class="row push">
      <div class="divlink row" data-location-url="<?php echo url_for('message/show'); ?>?id=${member.id}">
      <hr class="toumei">
      <div class="span3" >
        <img style="margin-left: 5px; margin-bottom: 5px;" src="${member.profile_image}" class="rad4" width="48" height="48"><!-- FIXME -->
      </div>
      <div class="span9" style="margin-left: -13px;"><!-- FIXME -->
        <div class="link_other">
        <a href="<?php echo url_for('@homepage', array('absolute' => true)); ?>/member/${member.id}"><b>${member.name}</b></a> ${body}<br />
        </div>
      </div>
      </div>
    </div>
    <hr class="gray">

</script>

<div class="row">
  <div class="gadget_header span12">メッセージ受信リスト</div>
</div>

<div id="messageReceiveList" class="hide">
</div>

<div class="center" id="messageReceiveListLoading">
<?php echo op_image_tag('ajax-loader.gif', array()) ?>
</div>

