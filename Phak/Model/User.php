<?php
namespace Phak\Model;

use \Phak\Config;

class User extends \Illuminate\Database\Eloquent\Model {

  //Roles
  const ADMIN = 1;
  const DISPATCH = 2;
  const WHM = 3;
  const COURIER = 4;
  const CLIENT = 5;

  protected $table = 'User';

  public $includes = [
    'role'
  ];


  /**
   * Generate a salted, peppered hash
   * @param  String $password Password to protect
   * @return String           hash
   */
  private function protect($password)
  { 
    $pepper = Config::get('gen.pepper');
    return hash('sha512', $pepper.$password.$this->salt);
  }

  /**
   * Generate a salt
   * @return String 64bit salt
   */
  private function generateSalt()
  {
    $salt = '';
    for($i = 0; $i < 8;$i++) {
      $salt = $salt.chr(rand(33, 126));
    }
    return $salt;
  }

  /**
   * Sign in user.
   * @param  String $username
   * @param  String $password 
   * @return User           
   */
  public function signIn($password) {
    if ($this->protect($password) === $this->password) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Start session for user
   * @return Boolean || String
   */
  public function startSession()
  {
    $session = new \Phak\Model\Session();
    return $session->createSession($this);
  }

  public function getSalt()
  {
    return $this->salt;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getRoleAttribute()
  {
    $query = self::join('UserRole',
      function($j) {
        $j->on('user_id', '=', 'User.id');
    })->join('Role',
      function($j) {
        $j->on('role_id', '=', 'Role.id');
    })->select('Role.roleName', 'Role.id')->where('User.id', '=', $this->id)->first();
    return $query;
  }

}