<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH.'/third_party/vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorHTML;
class Barcode extends BarcodeGeneratorHTML {
    public function __construct() {
    }
}