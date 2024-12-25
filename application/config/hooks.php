<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/
/* $hook['pre_controller'] = array(
    'class' => 'Downserver',
    'function' => 'check_suspend_status',
    'filename' => 'Downserver.php',
    'filepath' =>'hooks',
    'params' => array('param1','param2','param3')
); */


$hook['post_system'] = array(
    'class' => 'Downserver',
    'function' => 'check_suspend_status',
    'filename' => 'Downserver.php',
    'filepath' =>'hooks',
    'params' => array()
);
