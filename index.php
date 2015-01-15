<?php
//Let Composer do the heavy lifting regarding autoloading
require 'vendor/autoload.php';
require 'config.php';

use \Phak\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => Config::get('db.host'),
    'database'  => Config::get('db.database'),
    'username'  => Config::get('db.user'),
    'password'  => Config::get('db.password'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => Config::get('db.prefix'),
]);

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Setup the Eloquent ORM
$capsule->bootEloquent();

//Build a new request instance
$request = new \Phak\Request();
//And a response instance
$response = new \Phak\Response();

//Dispatch the request
\Phak\Router::dispatch($request, $response);
