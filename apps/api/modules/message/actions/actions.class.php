<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * message actions.
 *
 * @package    OpenPNE
 * @subpackage message
 * @author     Shouta Kashiwagi <kashiwasan@gmail.com>
 */
class messageActions extends opJsonApiActions
{
 /**
  * Executes list action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeList(sfWebRequest $request)
  {
    if (isset($request['member_id']))
    {
      $memberId = $request['member_id'];
    }
    $count = $request->getParameter('count', 20);
    $maxId = $request->getParameter('max_id', null);
    $sinceId = $request->getParameter('since_id', null);
    $this->detail = true;

    $this->q = Doctrine::getTable('SendMessageData')
      ->createQuery('m')
      ->select('m.*')
      ->addFrom('MessageSendList m2')
      ->whereIn('m.member_id', array($this->getUser()->getMemberId(), $memberId))
      ->andWhereIn('m2.member_id', array($this->getUser()->getMemberId(), $memberId))
      ->andWhere('m.id = m2.message_id');
    if ('ASC' === $request['order_by'])
    {
      $this->q->orderBy('m.id ASC');
    }
    else
    {
      $this->q->orderBy('m.id DESC');
    }

    $this->q->limit($count);

    $this->messages = $this->q->execute();

    $this->setTemplate('array');
  }

 /**
  * Executes listInbox action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeListInbox(sfWebRequest $request)
  {
    $this->detail = $request->getParameter('detail', false);
    $pageId = $request['page_id'] ? $request['page_id'] : 1;
    $count = $request['count'] ? $request['count'] : 20;
    $offset = ($pageId - 1) * $count;
    if ($request['max_id'])
    {
      $maxId = $request['max_id'];
    }

    $query = Doctrine::getTable('SendMessageData')->createQuery('m')
      ->select('m.*, max(m.id) as m.message_id');
    if ($request['max_id'])
    {
      $maxId = $request['max_id'];
      $query->where('m.id <= ?', $maxId);
    }

    $query->where('m.is_deleted = ?', 0);

    $query->groupBy('m.member_id')
      ->orderBy('m.id DESC')
      ->limit($count)
      ->offset($offset);

    $this->messages = $query->execute();
    $this->setTemplate('array');
  }

 /**
  * Executes post action
  *
  * @param sfWebRequest $request A request object
  */
  public function executePost(sfWebRequest $request)
  {
    $this->forward400Unless(isset($request['member_id']), 'member_id parameter not specified.');
    $this->forward400Unless(is_numeric($request['member_id']), 'member_id parameter must be numeric.');
    $this->forward400Unless(isset($request['body']), 'body parameter not specified.');
    $memberId = $request['member_id'];
    $body = $request['body'];
    $subject = $request->getParameter('subject', null);
    $threadMessageId = (int)$request->getParameter('thread_message_id', 0);
    $returnMessageId = (int)$request->getParameter('return_message_id', 0);
    $messageTypeId = (int)$request->getParameter('message_type_id', 1);
    $foreignId = (int)$request->getParameter('foreign_id', 0);

    $message = new SendMessageData();
    $message->setMemberId($this->getUser()->getMember());
    $message->setSubject($subject);
    $message->setBody($body);
    $message->setIsDeleted(0);
    $message->setIsSend(1);
    $message->setThreadMessageId($threadMessageId);
    $message->setReturnMessageId($returnMessageId);
    $message->setMessageTypeId($messageTypeId);
    $message->setForeignId($foreignId);
    $message->save();

    return $this->renderJSON(array('status' => 'success'));
  }
}
