<?php
namespace Phak\Controller;
use \Phak\Model\User;

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
    $params = [
      'user' => $user,
      'subtitle' => 'Dashboard'
    ];
    switch ($user->role->id) {
      case User::COURIER:
      case User::ADMIN:
        $page = 'userpage';
        break;
      case User::CLIENT:
        $page = 'clientpage';
        break;
      case User::WHM:
      case User::DISPATCH:
        $page = 'dispatchpage';
        break;
      default:
        $page = 'whmpage';
        break;
    }
    
    $this->_response->templatedResponse($page, $params);
  }

  public function post()
  {
    $this->get();
  }
}