<?php
/**
 * 
 */
if ( !isset($edit_me) ){
    $edit_me = false;
} 
$message = '';
//$modx->regClientStartupScript($cmpController->config['jsUrl'].'mgr/widgets/'.$cmpController->config['packageName'].'.js');
//$modx->regClientStartupScript('assets/components/slideshowmanager/slideshowmanager.js');
/**
 * add new record 
 */
$show_form = true;
// what are the possbile form options, name => validation method
$option_array = array(//fields array 
        'slide_id' => 'numeric',  
        'album_id' => 'numeric',
        'start_date' => 'date',
        'end_date' => 'date',
        'edit_time' => 'set_current_date_time',
        'sequence' => 'numeric',
        'slide_status' => 'text',
        'url' => 'text & links',
        'title' => 'text',
        'description' => 'text & links',
        'notes' => 'HTML', 
        'html' => 'HTML', 
        'options' => 'text',// text
        
        'upload_time' => 'set_current_date_time',
        'web_user_id' => 1,
        'version' => 1,
        'upload_file' => 'file',
        /*'file_path' => '',
        'file_size' => '',
        'file_type' => ''*/
    );

$require_array = array(
        'title', 
        'description',
        'start_date',
        'end_date',
        'sequence',
    );

if ($edit_me) {
    unset($option_array['date_created']);
    $require_array[] = 'slide_id';
} else {
    $require_array[] = 'upload_file';
    unset($option_array['id']);
} 
// load the album data NEED THIS!
$album_id = $_REQUEST['album_id'];
$slideAlbum = $modx->getObject('jgSlideshowAlbum', array('id' => $_REQUEST['album_id']));
$album_data = array();
if ( is_object($slideAlbum) ) {
    $album_data = $slideAlbum->toArray();
    // replace the | with a comma
    $file_allowed = array();
    $tmp = explode( ',', str_replace('|',',',$album_data['file_allowed']));
    foreach( $tmp as $ext ) {
        if ( empty($ext)){
            continue;
        }
        $file_allowed[] = trim($ext);
    }
    $smartyData = new dataToSmarty();
    $smartyData->loadData($album_data);
    // assign the form data to the template
    //$modx->smarty->assign($smartyData->buildSmarty('_album', true));
    //$modx->smarty->assign(array('a' => $a ) );
} else {
    return '<h2>Page Not Found</h2>';
}

// now call on validate, load the class
$validate = new formValidate($option_array, $require_array);

// set the file upload rules - name, file size, allowed extentions
$validate->setFileRules('upload_file', $album_data['file_size_limit'], $file_allowed, 
        $album_data['file_width'], $album_data['file_height'], $this->cmpController->config['uploadPath'].'tmp/' );

if( $validate->validate() ) {
    //this are no errors, get the validated Data
    $input_data = $validate->validatedData(false);
    //$input_data = $modx->sanatize($input_data);
    $input_data['slideshow_album_id'] = $input_data['album_id'];
    
    
    // upload file
    if( isset($_FILES['upload_file']['tmp_name']) && strlen($_FILES['upload_file']['tmp_name']) > 4 ) {
        // just the file name
        $input_data['file_path'] = str_replace( $this->cmpController->config['uploadPath'], '', 
            $validate->moveFile('upload_file', $this->cmpController->config['uploadPath'], 
                'album_'.$album_data['id'].'_slide_'.time() ) );
        $input_data['file_type'] = $validate->fileExt('upload_file');
        $input_data['file_size'] = filesize($input_data['file_path']);
        //$file_data['upload_time'] = $input_data['date_time'];
    } else {
        unset($input_data['upload_time']);
    }
    $input_data['web_user_id'] = $modx->user->get('id');//$modx->user_id();
    
    
    $no_error = true;
    //$edit_me = true;
    //$input_data;
    if ( $edit_me ) {
        // save data
        $slide = $modx->getObject('jgSlideshowSlide', array('id' => $input_data['slide_id']));
        $default_data = array();
        if ( is_object($slide) ) {
            $default_data = $slide->toArray();
            $input_data['version'] = $default_data['version'] + 1;
        } else {
            // error
            $modx->log(modX::LOG_LEVEL_ERROR,'Invalid query or missing ID for slideshow_slide' );
        }
    } else {
        // create new object
        $slide = $modx->newObject('jgSlideshowSlide');
        $input_data['version'] = 1;
    }
    // adjust the slide_status
    if ( $input_data['slide_status'] == 'insert' ) {
        /*
         * @todo reorder sequence in date is today
         */
        $input_data['slide_status'] = 'live';
    } elseif ( $input_data['slide_status'] == 'replace' ) {
        /*
         * @todo remove slide with same sequence and place in archive if date is today
         */
        $input_data['slide_status'] = 'live';
    }
    // http://rtfm.modx.com/display/XPDO10/fromArray
    $slide->fromArray($input_data,'',true);
    //echo 'Title: '.$slideAlbum->get('title');
    // debug:
    /*
    $modx->setDebug(true);    
    $modx->setLogLevel(LOG_LEVEL_DEBUG);// xPDO_LOG_LEVEL_DEBUG
    */
    
// redirect log output to echo'd HTML
$oldTarget = $modx->setLogTarget('HTML');
    if ( $slide->save() ) {
        //echo $slideAlbum->get('id');
        // order the slides properly 
        require_once CMP_MODEL_DIR.'sequence.class.php';
        $today = date("Y-m-d");
        $Sequence = new Sequence($modx, 'jgSlideshowSlide' );
        $Sequence->addConditions(
            array(
                'slideshow_album_id' => $album_id, 
                'slide_status' => 'live',
                'start_date:<=' => $today,
                'end_date:>=' => $today
            ));
        $Sequence->order($slide->get('id'), $slide->get('sequence'));
        
        if ( $edit_me ) {
            $message .= '<h3>The slide '.$slide->get('title').' has been updated.</h3><p>You may add another slide</p>';
            $this->action = 'addslide';
            $edit_me = false;
        } else {
            $message .= '<h3>The slide  '.$slide->get('title').' has been added.</h3><p>You may add another slide</p>';
            $this->action = 'addslide';
            $edit_me = false;
        }
        return $message;
    } else {
        // saving error
        //$errors = $modx->getErrors();
        //$modx->setLogLevel(xPDO_LOG_LEVEL_INFO);// xPDO_LOG_LEVEL_DEBUG
        //$modx->log(modX::LOG_LEVEL_ERROR,'Did not save slideshow_album' );
        $errors = $modx->log(LOG_LEVEL_ERROR,'Did not save slideshow_album, code: '.$modx->errorCode() );
        $message .= '<h3>The slide could not be saved, please try again.</h3>';
    }
// restore the default logging (to file)
$modx->setLogTarget($oldTarget);
    // fill in the form data:
    $smartyData = new dataToSmarty();
    // load the form data from $_POST
    $smartyData->loadForm();
    // format dates
    $smartyData->formatData('start_date', 'form_data');
    $smartyData->formatData('end_date', 'form_data');
    // assign the form data to the template
    $modx->smarty->assign($smartyData->buildSmarty());
    
} else {
    $message .= '<h3 class="errors">There are errors on the page, please revise.</h3>'; // call back on form 
    
    // fill in the form data:
    $smartyData = new dataToSmarty();
    // load the slide id
    $smartyData->loadData(
        array(
            'id' => $_REQUEST['slide_id'],
            //'file_path' => $path
            ));
    // load the form data from $_POST
    $smartyData->loadForm();
    $smartyData->formatData('start_date', 'form_data');
    $smartyData->formatData('end_date', 'form_data');
    // load the error messages
    $errors = $validate->errors();
    $error_list = $smartyData->loadErrors($errors);
    // $smartyData->loadData($input_data,'form_data');
    // assign the form data to the template
    $modx->smarty->assign($smartyData->buildSmarty('_frm', true));
    
    $message .= '
    <ul class="error_list">
        '.$error_list.'
    </ul>';
    /* 
    foreach( $errors as $n => $v ){
        echo '<li>N: '.$n.' => '.$v.'</li>';
    } */
}

return $message;