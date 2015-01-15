<?php
namespace Phak;

/**
 * The router class
 */
class Router {

  /**
   * Dispatch the proper controller for this request
   * @param  Request $request  The request instance
   * @param  Response $response The response instance
   * @return <void> 
   */
  public static function dispatch($request, &$response)
  {
    $actionName = self::getActionName($request);
    $controller = new $actionName($request, $response);
    $method = $request->method();
    if ($controller->requiresAuth[$method]) {
      if (!$request->isAuthed()) {
        $response->notAuthed();
      }
    }
    $response->setAuthed($request->isAuthed());
    call_user_func([$controller, $method]);
    return;
  }

  /**
   * Get the name of the requested action
   * @param  Request $request Request instance
   * @return String           Name of controller to dispatch
   */
  public static function getActionName($request)
  {
    $action = $request->get('action');
    if (is_null($action)) {
      //Nothing specified, dispatch index
      $action = 'index';
    }
    return '\\Phak\\Controller\\'.ucfirst($action);
  }
  
}