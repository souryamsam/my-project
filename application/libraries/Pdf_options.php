<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH.'/third_party/vendor/autoload.php';
use Dompdf\Options;
class Pdf_options extends Options {
    public function __construct() {
        parent::__construct();
    }
}