<?php
namespace Phak\Controller;
use \Phak\Model\ClientAddress;
/**
 * Signout controller
 */
class EditAddress extends \Phak\BaseController {

  public $requiresAuth = [
    'get' => True,
    'post' => True
  ];

  public function get()
  {
    $user = $this->_request->getSessUser();
    $values = ClientAddress::find($user->id);
    $this->_response->templatedResponse('editaddy', ['values' => $values]);
  }

  public function post()
  {
    $user = $this->_request->getSessUser();
    $addy = ClientAddress::find($user->id);
    $input = $this->_request->post();
    if (is_null($addy)) {
      $addy = new ClientAddress();
    }
    foreach ($input as $k => $v) {
      $addy->setAttribute($k, $v);
    }
    $addy->setAttribute('userId', $user->id);
    $addy->save();
    $values = ClientAddress::find($user->id);
    $this->_response->templatedResponse('editaddy', ['values' => $values]);
  }
}