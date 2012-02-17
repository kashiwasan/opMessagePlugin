<?php
use_helper('opUtil', 'I18N');

$messageData = array();

foreach ($messages as $message)
{
  if ($detail)
  {
    $messageData[] = array(
      'id' => $message->getId(),
      'member' => op_api_member($message->getMember()),
      'title' => $message->getSubject(),
      'body' => $message->getBody(),
      'created_at' => op_format_activity_time(strtotime($message->getCreatedAt())),
    );
  }
  else
  {
    $messageData[] = array(
      'id' => $message->getId(),
      'member' => op_api_member($message->getMember()),
      'title' => $message->getSubject(),
      'created_at' => op_format_activity_time(strtotime($message->getCreatedAt())),
    );
  }
}

return array(
  'status' => 'success',
  'data' => $messageData,
);
