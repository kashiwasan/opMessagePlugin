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
 * @author     Maki TAKAHASHI
 */
class messageActions extends opMessagePluginMessageActions
{
 /**
  * set friend nav
  *
  * @param integer $memberId
  */
  protected function setFriendNav($memberId)
  {
    sfConfig::set('sf_nav_type', 'friend');
    sfConfig::set('sf_nav_id', $memberId);
  }

 /**
  * Executes list action
  *
  * @param opWebRequest A request object
  */
  public function executeList(opWebRequest $request)
  {
    $this->forwardIf($request->isSmartphone(), 'message', 'smtList');
    return parent::executeList($request);
  }

 /**
  * Executes smtList action
  *
  * @param opWebRequest A request object
  */
  public function executeSmtList(opWebRequest $request)
  {
  }

 /**
  * Executes show action
  *
  * @param opWebRequest A request object
  */
  public function executeShow(opWebRequest $request)
  {
    $this->forwardIf($request->isSmartphone(), 'message', 'smtShow');
    return parent::executeShow($request);
  }

 /**
  * Executes send to frind action
  *
  * @param sfWebRequest A request object
  */
  public function executeSmtShow(opWebRequest $request)
  {
    $this->memberId = (int)$request['id'];
    $this->member = Doctrine::getTable('Member')->find($this->memberId);
    if (!$this->member || $this->member->getId() === $this->getUser()->getMember()->getId())
    {
      $this->forward404();
    }
    $this->getResponse()->setDisplayMember($this->member);
  }

 /**
  * Executes send to frind action
  *
  * @param sfWebRequest A request object
  */
  public function executeSendToFriend(sfWebRequest $request)
  {
    $result = parent::executeSendToFriend($request);
    $this->setFriendNav($this->sendMember->getId());
    return $result;
  }

 /**
  * Executes edit message action
  *
  * @param sfWebRequest A request object
  */
  public function executeEdit(sfWebRequest $request)
  {
    $result = parent::executeEdit($request);
    $this->setFriendNav($this->sendMember->getId());
    return $result;
  }

 /**
  * Executes reply message action
  *
  * @param sfWebRequest A request object
  */
  public function executeReply(sfWebRequest $request)
  {
    $result = parent::executeReply($request);
    $this->setFriendNav($this->sendMember->getId());
    return $result;
  }

}
