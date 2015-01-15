<?php
namespace Phak;
/**
 * The response object
 */
class Response {

  /**
   * HTTP response code
   * @var Int
   */
  private $_responseCode;

  /**
   * HTTP response headers
   * @var Array
   */
  private $_responseHeaders;

  /**
   * Response body
   * @var String
   */
  private $_responseBody;

  /**
   * Handlebars engine instance
   * @var Handlebars
   */
  private $_hbEngine;

  /**
   * Initialize default values
   */
  public function __construct()
  {
    $this->_responseCode = 200;
    $this->_responseHeaders = [];
    $this->_responseBody = '';
    $this->_hbEngine = new \Handlebars\Handlebars([
        'loader' => new \Handlebars\Loader\FilesystemLoader(Config::get('templates.dir')),
        'partials_loader' => new \Handlebars\Loader\FilesystemLoader(
            Config::get('templates.dir'),
            array(
                'prefix' => '_'
            )
        )
    ]);
  }

  /**
   * Set request body to contents
   * @param String $contents Contents of body
   */
  public function setBody($contents)
  {
    $this->_responseBody = $contents;
  }

  /**
   * Get the HTTP response code
   * @return Int HTTP response code
   */
  public function getCode()
  {
    return $this->_responseCode;
  }

  /**
   * Set HTTP response code
   * @param Int $code HTTP response code
   */
  public function setCode($code) 
  {
    $this->_responseCode = $code;
  }

  /**
   * Respond to the request.
   * @return <void>
   */
  public function templatedResponse($templateName, $params = [])
  {
    //Set the headers
    foreach ($this->_responseHeaders as $name => $value) {
      header(sprintf("%s: %s", $name, $value));
    }
    //Set the proper response code
    http_response_code($this->getCode());
    //Output the templated response
    echo $this->_hbEngine->render($templateName, array_merge($this->_authed, $params));
  }

  public function error($message) 
  {
    $this->templatedResponse('error', ['error_message' => $message]);
    exit();
  }

  public function notAuthed() {
    $this->redirect('index');
    exit();
  }

  public function redirect($action) 
  {
    header(
      sprintf('Location: %s?action=%s', Config::get('gen.baseUrl'), $action)
    );
    die();
  }

  public function setAuthed($authed)
  {
    $this->_authed = [
      'baseUrl' => Config::get('gen.baseUrl'), 
      'authed' => $authed
    ];
  }

}