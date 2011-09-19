<?php
/**
 * @package CMP 
 * @subpackage controllers
 * 
 * This file is only called on by /core/components/YOUR-EXTRA/index.php 
 */
/** the doodles example code
require_once dirname(dirname(__FILE__)).'/model/doodles/doodles.class.php';
$doodles = new Doodles($modx);
return $doodles->initialize('mgr');
*/
// my code, I replaced names to make them common and easier to copy an extra and then make a custom on from it

/* 
 * you should only need to change the Package Name var!  Not keep all folder/files lowercase
 * and no spaces or hyphen(-)
 */
$package_name = 'slideshowmanager';
$config = array( 
        'packageName' => $package_name
    );
// load the controller class - mycontroller.class.php
define('CMP_MODEL_DIR', dirname(dirname(__FILE__)).'/model/' );
require_once CMP_MODEL_DIR.$package_name.'/mycontroller.class.php';

$cmpController = new myController($modx, $config );
return $cmpController->initialize('mgr');