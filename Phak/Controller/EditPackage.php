<?php
namespace Phak\Controller;
use \Phak\Model\Package;
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
    $user = $this->_request->getSessUser();
    if ($user->id == $values['receiverId']) {
      $params['receiver'] = true;
      var_dump('hola!');
    }
    $this->_response->templatedResponse('addpackage', [
      'subtitle' => 'Edit package',
      'values' => $values
    ]);
  }
}