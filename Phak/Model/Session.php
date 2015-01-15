<?php
namespace Phak\Model;
use \Phak\Config;
use \Illuminate\Database\Capsule\Manager as Capsule;
/**
 * Model representing a session
 */
class Session extends \Illuminate\Database\Eloquent\Model {

  protected $table = 'Session';
  public $timestamps = False;
  protected $primaryKey = 'hash';

  /**
   * Check if session with specified public hash exists
   * @param  String $publicHash Public hash retrieved from cookie
   * @return Session
   */
  public static function checkSession($publicHash) 
  {
    $session = self::where(
      'hash', '=', hash('sha1', Config::get('gen.pepper').$publicHash)
    )->first();
    if (!is_null($session)) {
      return $session;
    } else {
      return null;
    }
  }

  /**
   * Create a new session for user
   * @param  User   $user User instance
   * @return String public token for this session
   */
  public function createSession($user) {
    $signinTime = time();
    $publicHash = hash(
      'sha1',$user->getSalt().$user->getEmail().strval($signinTime)
    );
    $this->hash = hash('sha1', Config::get('gen.pepper').$publicHash);
    $this->user_id = $user->getId();
    if ($this->save()) {
      return $publicHash;
    } else {
      return False;
    }
  }


  public function getUser()
  {
    return User::where('id', '=', $this->user_id)->first();
  }
  
}