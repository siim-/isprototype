<?php
namespace Phak;
/**
 * An abstract BaseController
 */
abstract class BaseController {

  protected $_request;
  protected $_response;

  public $requiresAuth = [
    'get' => False,
    'post' => False
  ];

  /**
   * Build the controller
   * @param Request  $request   Request instance
   * @param Response &$response Response instance
   */
  public function __construct($request, &$response)
  {
    $this->_request = $request;
    $this->_response = $response;
  }

  //These must be defined by extending classes
  abstract public function get();
  abstract public function post();

}