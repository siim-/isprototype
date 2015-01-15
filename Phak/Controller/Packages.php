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
    $packages = Package::orWhere('senderId', '=', $user->id)->orWhere('receiverId', '=', $user->id)->get();
    $packages->map(function($p) use ($user) {
      $p->status = PackageStatus::where('id', '=', intval($p->status))->first();
      $p->sender = User::find($p->senderId);
      $p->receiver = User::find($p->receiverId);
      $p->awaiting_payment = $p->status->statusName === 'awaiting_payment' && $p->receiverId !== $user->id;
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