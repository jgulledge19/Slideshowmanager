<?php
/**
 * 
 */
if ( !isset($edit_me) ){
    $edit_me = false;
} 
/**
 * add new record 
 */
$show_form = true;
// what are the possbile form options
$file_checkboxes = array(
        'file_allowed_jpg' => 'text',
        'file_allowed_png' => 'text',
        'file_allowed_gif' => 'text' 
   );
$option_array = array(//fields array 
        'album_id' => 'numeric',  
        'title' => 'text', 
        'description' => 'text',
        // 'file_allowed' => 'text', // the actual DB column name
        'file_size_limit' => 'numeric', 
        'file_width' => 'numeric', 
        'file_height' => 'numeric',
        'icon_path' => 'text'
       // 'date_created' => 'set_current_date_time'
    );
$option_array = array_merge($option_array,$file_checkboxes);

$require_array = array(
        'title', 
        'description',
        'file_size_limit',
        'file_width',
        'file_height'
    );

if ($edit_me) {
    unset($option_array['date_created']);
    $require_array[] = 'id';
} else {
    unset($option_array['id']);
    
}
// at least one file type is required

// now call on validate, load the class

$validate = new formValidate($option_array, $require_array);
if( $command == 2 ){
    // set the file upload rules - name, file size, allowed extentions
    $validate->setFileRules('flash_image', 102400, array('jpg', 'jpeg') );
}

if( $validate->validate() ) {
    //this are no errors
    $input_data = $validate->validatedData();
    // create the file_allowed column
    $input_data['file_allowed'] = '';
    foreach ( $file_checkboxes as $name => $value ) {
        if ( empty($value) ) {
            continue;
        }
        if ( !empty($input_data['file_allowed']) ) {
            $input_data['file_allowed'] .= '|';
        }
        $input_data['file_allowed'] .= $input_data[$name];
    } 
    
    $no_error = true;
    //$edit_me = true;
    //$input_data;
    if ( $edit_me ) {
        // save data
        $slideAlbum = $modx->getObject('jgSlideshowAlbum', array('id' => $input_data['album_id']));
        $default_data = array();
        if ( is_object($slideAlbum) ) {
            $default_data = $slideAlbum->toArray();
        } else {
            // error
            $modx->log(modX::LOG_LEVEL_ERROR,'Invalid query or missing ID for slideshow_album' );
        }
    } else {
        // create new object
        $slideAlbum = $modx->newObject('jgSlideshowAlbum');
    }
    // http://rtfm.modx.com/display/XPDO10/fromArray
    $slideAlbum->fromArray($input_data,'',true);
    //echo 'Title: '.$slideAlbum->get('title');
    // debug:
    /*
    $modx->setDebug(true);    
    $modx->setLogLevel(LOG_LEVEL_DEBUG);// xPDO_LOG_LEVEL_DEBUG
    */
    
    if ( $slideAlbum->save() ) {
        //echo $slideAlbum->get('id');
        // if repeating:
        if ( $edit_me ) {
            $message .= '<h3>The slideshow album has been updated.</h3>';
            
        } else {
            $message .= '<h3>The slideshow album has been added.</h3>';
        }
        $this->action = 'home';
        return $message;
    } else {
        // saving error
        //$errors = $modx->getErrors();
        //$modx->setLogLevel(xPDO_LOG_LEVEL_INFO);// xPDO_LOG_LEVEL_DEBUG
        //$modx->log(modX::LOG_LEVEL_ERROR,'Did not save slideshow_album' );
        $errors = $modx->log(LOG_LEVEL_ERROR,'Did not save slideshow_album, code: '.$modx->errorCode() );
        
        $message .= '<h3>The slideshow album could not be saved, please try again.</h3>';
    }
    // fill in the form data:
    $smartyData = new dataToSmarty();
    // load the form data from $_POST
    $smartyData->loadForm();
    // assign the form data to the template
    $modx->smarty->assign($smartyData->buildSmarty());
    
} else {
    $message .= '<h3 class="errors">There are errors on the page, please revise.</h3>'; // call back on form 
    
        
    // fill in the form data:
    $smartyData = new dataToSmarty();
    // load the form data from $_POST
    $smartyData->loadForm();
    // load the error messages
    $error_list = $smartyData->loadErrors($validate->errors());
    // $smartyData->loadData($input_data,'form_data');
    // assign the form data to the template
    $modx->smarty->assign($smartyData->buildSmarty());
    
    $message .= '
    <ul class="error_list">
        '.$error_list.'
    </ul>';
    /*
    foreach( $validate->errors() as $n => $v ){
        $text .= '<li>N: '.$n.' => '.$v.'</li>';
    } */
}

return $message;

if ( $show_form ){
    // call on the form template
    
} else {
    // show success message and manage page
    
}
