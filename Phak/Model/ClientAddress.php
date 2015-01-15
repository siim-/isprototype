<?php
namespace Phak\Model;

use \Phak\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

class ClientAddress extends \Illuminate\Database\Eloquent\Model {
  public $table = 'ClientAddress';
  protected $primaryKey = 'userId';
  public $timestamps = false;
}