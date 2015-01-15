<?php
namespace Phak\Controller;
use \Phak\Model\Package;
use \Phak\Model\User;
/**
 * Signout controller
 */
class EditPackage extends \Phak\BaseController {

  public $requiresAuth = [
    'get' => True,
    'post' => True
  ];

  public function get()
  {
    $values = Package::find($this->_request->get('id'))->toArray();
    $params = [
      'subtitle' => 'Edit package',
      'values' => $values
    ];
    $user = $this->_request->getSessUser();
    if ($user->id == $values['receiverId']) {
      $params['receiver'] = true;
    }
    if ($user->role->id == User::DISPATCH) {
      $params['privileged'] = true;
      $params['users'] = User::join('UserRole',
        function($j) {
          $j->on('UserRole.user_id', '=', 'User.id');
      })->where('UserRole.role_id', '=', User::CLIENT)->get();
      $params['users']->map(function($e) use ($values) {
        $e->sender = $values['senderId'] == $e->id;
        $e->receiver = $values['receiverId'] == $e->id;
      });
    }
    $this->_response->templatedResponse('addpackage', $params);
  }

  public function post()
  {
    $package = Package::find($this->_request->get('id'));
    $input = $this->_request->post();
    foreach ($input as $k => $i) {
      $package->setAttribute($k, $i);
    }
    $package->save();
    $values = Package::find($this->_request->get('id'))->toArray();
    $params = [
      'subtitle' => 'Edit package',
      'values' => $values,
      'receiver' => $receiver
    ];
    $user = $this->_request->getSessUser();
    if ($user->id == $values['receiverId']) {
      $params['receiver'] = true;
    } else {
      $params['receiver'] = false;
    }
    if ($user->role->id == User::DISPATCH) {
      $params['privileged'] = true;
      $params['users'] = User::join('UserRole',
        function($j) {
          $j->on('UserRole.user_id', '=', 'User.id');
      })->where('UserRole.role_id', '=', User::CLIENT)->get();
      $params['users']->map(function($e) use ($values) {
        $e->sender = $values['senderId'] == $e->id;
        $e->receiver = $values['receiverId'] == $e->id;
      });
    }
    $this->_response->templatedResponse('addpackage', $params);
  }
}