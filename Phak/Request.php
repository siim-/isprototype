<?php
namespace Phak;
/**
 * Request wrapper. Nothing fancy
 */
class Request {

  private $_headers;
  private $_post;
  private $_get;
  private $_method;

  private $_authed;
  private $_session;

  /**
   * Build the request object
   */
  public function __construct()
  {
    $this->_headers = getallheaders();
    $this->_post = $_POST;
    $this->_get = $_GET;
    $this->_method = strtolower($_SERVER['REQUEST_METHOD']);
    $this->checkAuthentication();
  }

  /**
   * Try to find the specified value from one of the private arrays
   * @param  String $type [description]
   * @param  String $key  Value key
   * @return Multiple The function may return different types of value
   */
  private function _readFromArray($type, $key = null) 
  {
    switch ($type) {
      case 'get':
        $array = &$this->_get;
      break;
      case 'post':
        $array = &$this->_post;
      break;
      case 'headers':
        $array = &$this->_headers;
      break;
    }

    if (is_null($key)) {
      return $array;
    } else {
      return isset($array[$key]) ? $array[$key] : null;
    }

  }

  /**
   * Fetch the specified GET variable or all available
   * @param  String $key GET variable name
   * @return Multiple The function may return different types of value
   */
  public function get($key = null)
  {
    return $this->_readFromArray('get', $key);
  }

  /**
   * Analog of get for POST variables
   * @param  String $key POST variable name
   * @return Multiple The function may return different types of value
   */
  public function post($key = null) 
  {
    return $this->_readFromArray('post', $key);
  }

  /**
   * Analog of get for header variables
   * @param  String $key Header name
   * @return Multiple The function may return different types of value
   */
  public function header($key = null) 
  {
    return $this->_readFromArray('headers', $key);
  }

  /**
   * Request method
   * @return String Method name
   */
  public function method()
  {
    return $this->_method;
  }

  /**
   * Check authentication
   * @return void
   */
  public function checkAuthentication()
  {
    if (isset($_COOKIE['Phak_login'])) {
      $publicHash = $_COOKIE['Phak_login'];
    }  else {
      $publicHash = False;
    } 
    if ($publicHash) {
      $sess = \Phak\Model\Session::checkSession($publicHash);
      if (!is_null($sess)) {
        $this->_authed = true;
        $this->_session = $sess;
        return;
      }
    }
    $this->_authed = false;
    $this->_session = null;
  }

  public function isAuthed()
  {
    return $this->_authed;
  }

  public function getSessUser()
  {
    return !is_null($this->_session) ? $this->_session->getUser() : null;
  }

  public function endSession()
  {
    $this->_session->delete();
    setcookie("Phak_login", "", time()-3600);
  }
}