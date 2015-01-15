<?php
namespace Phak\Controller;
use \Phak\Model\Package;
use \Phak\Model\User;
use \Phak\Model\PackageStatus;
/**
 * Signout controller
 */
class Packages extends \Phak\BaseController {

  public $requiresAuth = [
    'get' => True,
    'post' => True
  ];

  public function get()
  {
    $user = $this->_request->getSessUser();
    if ($user->role->id == User::CLIENT) {
      $packages = Package::orWhere('senderId', '=', $user->id)->orWhere('receiverId', '=', $user->id)->get();
    } else if ($user->role->id == User::DISPATCH || $user->role->id == User::WHM) {
      $packages = Package::get();
    }
   
    $packages->map(function($p) use ($user) {
      $p->status = PackageStatus::where('id', '=', intval($p->status))->first();
      $p->sender = User::find($p->senderId);
      $p->receiver = User::find($p->receiverId);
      $p->awaiting_payment = $p->status->statusName === 'awaiting_payment' && $p->senderId === $user->id;
      $p->display_do = $p->receiverId === $user->id || $user->role->id == User::DISPATCH || $user->role->id == User::WHM;
      $p->display_pickup = $p->senderId === $user->id || $user->role->id == User::DISPATCH || $user->role->id == User::WHM;
    });
    $this->_response->templatedResponse('packages', [
      'subtitle' => 'List packages', 'packages' => $packages->toArray(),
      'user' => $user
    ]);
  }

  public function post()
  {
    
  }
}