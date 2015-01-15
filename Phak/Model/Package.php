<?php
namespace Phak\Model;

use \Phak\Config;
use Illuminate\Database\Capsule\Manager as Capsule;

class Package extends \Illuminate\Database\Eloquent\Model {
  public $timestamps = false;
  public $table = 'Package';

  protected $fillable = [
    'height', 'weight', 'depth', 'width', 'receiverId', 'senderId',
    'invoiceId', 'status', 'pickup'
  ];

  public static function addNew($sender, $receiver, $input)
  {
    Capsule::transaction(
      function() use ($sender, $receiver, $input) {
        $invoice = Invoice::create([
          'amountDue' => 3.5,
          'userId' => $sender->id
        ]);
        $status = PackageStatus::find('awaiting_payment');
        $package = self::create([
          'height' => $input['height'],
          'depth' => $input['depth'],
          'weight' => $input['weight'],
          'width' => $input['width'],
          'status' => $status->id,
          'invoiceId' => $invoice->id,
          'receiverId' => $receiver->id,
          'senderId' => $sender->id,
          'pickup' => $input['pickup']
        ]);
    });
    return True;
  }

}