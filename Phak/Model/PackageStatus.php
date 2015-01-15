<?php
namespace Phak\Model;

use \Phak\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

class PackageStatus extends \Illuminate\Database\Eloquent\Model {
  public $table = 'PackageStatus';
  protected $primaryKey = 'statusName';
}