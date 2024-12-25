<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH.'/third_party/vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;
class Barcode_png extends BarcodeGeneratorPNG {
    public function __construct() {
        parent::__construct();
    }
}