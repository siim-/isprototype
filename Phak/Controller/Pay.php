<?php
namespace Phak\Controller;
use \Phak\Model\Package;
use \Phak\Model\Invoice;
use \Phak\Model\PackageStatus;
/**
 * Signout controller
 */
class Pay extends \Phak\BaseController {

  public $requiresAuth = [
    'get' => True,
    'post' => True
  ];

  public function get()
  {
    $input = $this->_request->get();
    $package = Package::find($input['id']);
    if (!is_null($package)) {
      $invoice = Invoice::find($package->invoiceId);
      $invoice->paymentStatus = 1;
      $invoice->save();
      $status = PackageStatus::find('awaiting_pickup');
      $package->status = $status->id;
      $package->save();
      $this->_response->redirect('packages');
    }
  }

  public function post()
  {
    
  }
}