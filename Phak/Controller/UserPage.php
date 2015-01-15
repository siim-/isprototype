<?php
namespace Phak\Controller;

/**
 * User page controller
 */
class UserPage extends \Phak\BaseController {

  public $requiresAuth = [
    'get' => False,
    'post' => False
  ];

  public function get()
  { 
    $user = $this->_request->getSessUser();
    if (is_null($user) && is_null($id)) {
      $this->_response->notAuthed();
    }
    $params = [
      'user' => $user,
      'title' => 'Dashboard'
    ];
    
    $this->_response->templatedResponse('userpage', $params);
  }

  public function post()
  {
    $this->get();
  }
}