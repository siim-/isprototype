<?php
namespace Phak\Model;

use \Phak\Config;

class Invoice extends \Illuminate\Database\Eloquent\Model {
  public $timestamps = false;
  public $table = 'Invoice';
  protected $fillable = ['amountDue', 'userId'];
}