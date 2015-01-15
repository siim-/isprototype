<?php
namespace Phak\Controller;

/**
 * Signout controller
 */
class Signout extends \Phak\BaseController {

  public $requiresAuth = [
    'get' => True,
    'post' => True
  ];

  public function get()
  {
    $this->_request->endSession();
    $this->_response->redirect('index');
  }

  public function post()
  {
    
  }
}