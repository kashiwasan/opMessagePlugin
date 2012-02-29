<div class="row">
  <h3 class="span12">メッセージを送信</h3>
</div>

<?php use_helper('Javascript') ?>
<div class="row">
 <?php link_to($member->getName().'さんにメッセージを送信する', 'message/show?id='.$id) ?>
</div>

