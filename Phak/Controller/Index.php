<?php
namespace Phak\Controller;

/**
 * Index controller
 */
class Index extends \Phak\BaseController {

  public function get()
  {
    if ($this->_request->isAuthed()) {
      $this->_response->redirect('userPage');
    }
    $this->_response->templatedResponse(
      'index', [
        'subtitle' => 'Sign in'
    ]);
  }

  public function post()
  {
    $input = $this->_request->post();
    $params = [];
    $user = \Phak\Model\User::where('email', '=', $input['email'])->first();
    if (!is_null($user) && $user->signIn($input['password'])) {
      $hash = $user->startSession();
      if ($hash) {
        setcookie('Phak_login', $hash, 0);
        $this->_response->redirect('userPage');
      } else {
        $params['error'] = [
          'signin' => 'Failed to sign You in!'
        ];
      }
    } else {
      $params['error'] = [
        'signin' => 'Wrong username/password'
      ];
    }

    $this->_response->templatedResponse('index', $params);
  }
}