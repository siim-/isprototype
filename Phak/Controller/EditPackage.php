<?php
namespace Phak\Controller;
use \Phak\Model\Package;
use \Phak\Model\User;
use \Phak\Model\PackageStatus;
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
      $params['toggle_users'] = true;
      $params['users'] = User::join('UserRole',
        function($j) {
          $j->on('UserRole.user_id', '=', 'User.id');
      })->where('UserRole.role_id', '=', User::CLIENT)->get();
      $params['users']->map(function($e) use ($values) {
        $e->sender = $values['senderId'] == $e->id;
        $e->receiver = $values['receiverId'] == $e->id;
      });
      $params['status'] = PackageStatus::get();
      $params['status']->map(function($e) use ($values) {
        $e->current = $e->id == $values['status'];
      });
    }
    if ($user->role->id == User::WHM) {
      $params['status'] = PackageStatus::get();
      $params['status']->map(function($e) use ($values) {
        $e->current = $e->id == $values['status'];
      });
      $params['whm'] = true;
    }
    $this->_response->templatedResponse('addpackage', $params);
  }

  public function post()
  {
    $package = Package::find($this->_request->get('id'));
    $input = $this->_request->post();
    if (isset($input['receiverId']) && isset($input['senderId']) && $input['receiverId'] === $input['senderId']) {
      $this->_response->error('Receiver and sender can\'t be the same person!');
    }
    foreach ($input as $k => $i) {
      $package->setAttribute($k, $i);
    }
    $package->save();
    $values = Package::find($this->_request->get('id'))->toArray();
    $params = [
      'subtitle' => 'Edit package',
      'values' => $values
    ];
    $user = $this->_request->getSessUser();
    if ($user->id == $values['receiverId']) {
      $params['receiver'] = true;
    } else {
      $params['receiver'] = false;
    }
    if ($user->role->id == User::DISPATCH) {
      $params['toggle_users'] = true;
      $params['users'] = User::join('UserRole',
        function($j) {
          $j->on('UserRole.user_id', '=', 'User.id');
      })->where('UserRole.role_id', '=', User::CLIENT)->get();
      $params['users']->map(function($e) use ($values) {
        $e->sender = $values['senderId'] == $e->id;
        $e->receiver = $values['receiverId'] == $e->id;
      });
      $params['status'] = PackageStatus::get();
      $params['status']->map(function($e) use ($values) {
        $e->current = $e->id == $values['status'];
      });
    }
    if ($user->role->id == User::WHM) {
      $params['status'] = PackageStatus::get();
      $params['status']->map(function($e) use ($values) {
        $e->current = $e->id == $values['status'];
      });
      $params['whm'] = true;
    }
    $this->_response->templatedResponse('addpackage', $params);
  }
}