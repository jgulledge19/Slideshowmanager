<?php
/**
 * Loads the data into the form and then call on addalbum.php
 *
 * @package slideshow-manager
 */
// load default data 
if ( isset($_GET['album_id']) && is_numeric($_GET['album_id'])) {
    $slideAlbum = $modx->getObject('jgSlideshowAlbum', array('id' => $_GET['album_id']));
    $default_data = array();
    if ( is_object($slideAlbum) ) {
        $default_data = $slideAlbum->toArray();
        // make the check box options
        // what are the possbile form options - these must be the same name => value as in the managealbum.tpl
        $file_checkboxes = array(
                'file_allowed_jpg' => 'jpg, jpeg',
                'file_allowed_png' => 'png',
                'file_allowed_gif' => 'gif' 
           );
        
        $tmp = explode('|',$default_data['file_allowed']);
        foreach ( $tmp as $str ){
            if (empty($str) ){
                continue;
            }
            //echo 'Str: '.$str;
            if ( $key = array_search($str, $file_checkboxes) ){
                //echo '<br>K: '.$key;
                $default_data[$key] = $str;
            }
        }
        $smartyData = new dataToSmarty();
        // load the form data from $_POST
        $smartyData->loadData($default_data);
        //print_r($default_data);
        // assign the form data to the template
        $modx->smarty->assign($smartyData->buildSmarty('_frm', true));
        $modx->smarty->assign(array('edit_me' => true ) );
        $edit_me = true;
        
    }
}
return include 'addalbum.php';