<?php
namespace Phak\Controller;
/**
 * AddPackage controller
 */
class AddPackage extends \Phak\BaseController {

  public $requiresAuth = [
    'get' => True,
    'post' => True
  ];

  public function get()
  {
    $user = $this->_request->getSessUser();
    $this->_response->templatedResponse('addpackage', ['subtitle' => 'Add a package!', 'user' => $user]);
  }

  public function post()
  {
    $input = $this->_request->post();
    $params = [];
    $params['user'] = $this->_request->getSessUser();
    foreach ($input as $el) {
      if (strlen($el) === 0) {
        $params['error'] = 'Mandatory field may not be empty!';
        break;
      }
    }
    if (!isset($params['error'])) {
      $user = \Phak\Model\User::where('email', '=', $input['email'])->first();
      if (is_null($user)) {
        $params['error'] = 'No such user found - DEMO limitation';
      } else if ($user->id === $params['user']->id) {
        $params['error'] = 'Can\'t send a package to yourself';
      } else {
        if (!\Phak\Model\Package::addNew($params['user'], $user, $input)) {
          $params['error'] = 'Failed to add package!';
        } else {
          var_dump('Success!');
        }
      }
    }
    
    $this->_response->templatedResponse('addpackage', $params);
  }
}