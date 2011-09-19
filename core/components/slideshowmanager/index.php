<?php
/**
 * 
 *
 * @Joshua Gulledge 
 * @version $0$
 * @copyright 2011
 * @package slideshowmanager
 */

/**
 * This extra will be a slide show manager custom page in the MODX Revolution manager
 * it will allow multipul slide shows and a snippet will to call the slideshow images
 * 
 * http://rtfm.modx.com/display/revolution20/Custom+Manager+Pages
 * http://rtfm.modx.com/display/revolution20/Internationalization
 */


if ( !isset($a) ) {
    if ( isset($_REQUEST['a']) ) {
        $a = $_REQUEST['a'];
    }
    //echo 'Test 2 A: '.$a;
}
$o = include dirname(__FILE__).'/controllers/index.php';
return $o;