<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH.'/third_party/vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorJPG;
class Barcode_jpg extends BarcodeGeneratorJPG {
    public function __construct() {
        parent::__construct();
    }
}