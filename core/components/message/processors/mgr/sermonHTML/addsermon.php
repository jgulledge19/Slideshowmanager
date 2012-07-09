<?php
/**
 * 
 */
if ( !isset($edit_me) ){
    $edit_me = false;
} 

//$modx->regClientStartupScript($cmpController->config['jsUrl'].'mgr/widgets/'.$cmpController->config['packageName'].'.js');
//$modx->regClientStartupScript('assets/components/slideshowmanager/slideshowmanager.js');
/**
 * add new record 
 */
$show_form = true;
// what are the possbile form options, name => validation method
$option_array = array(//fields array 
        'sermon_id' => 'numeric',  
        'group_id' => 'numeric',
        'sermon_date' => 'date',
        'create_date' => 'set_current_date_time',
        'active' => 'text',
        //'url' => 'text & links',
        'title' => 'text',
        'speaker' => 'text',
        'description' => 'text & links',
        'tags' => 'text', 
        
        'upload_time' => 'set_current_date_time',
        'upload_audio' => 'file',
        'upload_video' => 'file'
    );

$require_array = array(
        'title', 
        //'description',
        'sermon_date',
        'speaker',
    );

if ($edit_me) {
    unset($option_array['create_date']);
    $require_array[] = 'sermon_id';
} else {
    //$require_array[] = 'upload_video';
    unset($option_array['id']);
} 
// load the album data NEED THIS!
$group_id = $_REQUEST['group_id'];
$sermonGroup = $modx->getObject('MessageGroup', array('id' => $_REQUEST['group_id']));
$group_data = array();
if ( is_object($sermonGroup) ) {
    $group_data = $sermonGroup->toArray();
    // replace the | with a comma
    $file_allowed = array();
    /*
    $tmp = explode( ',', str_replace('|',',',$group_data['file_allowed']));
    foreach( $tmp as $ext ) {
        if ( empty($ext)){
            continue;
        }
        $file_allowed[] = trim($ext);
    }
    */
    $smartyData = new dataToSmarty();
    $smartyData->loadData($group_data);
    // assign the form data to the template
    //$modx->smarty->assign($smartyData->buildSmarty('_album', true));
    //$modx->smarty->assign(array('a' => $a ) );
} else {
    return '<h2>Page Not Found</h2>';
}

// now call on validate, load the class
$validate = new formValidate($option_array, $require_array);

$audio_allowed = array('mp3', 'wav');
// set the file upload rules - name, file size, allowed extentions
$validate->setFileRules('upload_audio', 50*1024*1024, $audio_allowed);//, 0, 0, $this->cmpController->config['uploadPath'].'tmp/' );

$video_allowed = array('flv', 'mp4', 'mpeg', 'mov', 'wmv');
$validate->setFileRules('upload_video', 180*1024*1024, $video_allowed);

if( $validate->validate() ) {
    //this are no errors, get the validated Data
    $input_data = $validate->validatedData(false);
    //$input_data = $modx->sanatize($input_data);
    //$input_data['group_id'] = $input_data['group_id'];
    
    $input_data['web_user_id'] = $modx->user->get('id');//$modx->user_id();
    
    
    $no_error = true;
    //$edit_me = true;
    //$input_data;
    if ( $edit_me ) {
        // save data
        $sermon = $modx->getObject('MessageSermons', array('id' => $input_data['sermon_id']));
        $default_data = array();
        if ( is_object($sermon) ) {
            $default_data = $sermon->toArray();
            $input_data['version'] = $default_data['version'] + 1;
        } else {
            // error
            $modx->log(modX::LOG_LEVEL_ERROR,'Invalid query or missing ID for slideshow_slide' );
        }
    } else {
        // create new object
        $sermon = $modx->newObject('MessageSermons');
        $input_data['version'] = 1;
    }
    // adjust the slide_status
    
    // http://rtfm.modx.com/display/XPDO10/fromArray
    $sermon->fromArray($input_data,'',true);
    //echo 'Title: '.$slideAlbum->get('title');
    // debug:
    /*
    $modx->setDebug(true);    
    $modx->setLogLevel(LOG_LEVEL_DEBUG);// xPDO_LOG_LEVEL_DEBUG
    */
    
// redirect log output to echo'd HTML
$oldTarget = $modx->setLogTarget('HTML');

    if ( $sermon->save() ) {
        
    
        // upload audio file
        if( isset($_FILES['upload_audio']['tmp_name']) && strlen($_FILES['upload_audio']['tmp_name']) > 4 ) {
            //echo 'UPLOADING';
            // just the file name
            // ;
            $file = str_replace( $this->cmpController->config['uploadPath'], '', 
                $validate->moveFile('upload_audio', $this->cmpController->config['uploadPath'], 
                    'audio_'.$group_data['id'].'_'.$sermon->get('id').'_'.$validate->cleanName($sermon->get('title')) ) );
            
            $file = str_replace($this->cmpController->config['uploadPath'], '', $file);
            
            $input_data['file_size'] = filesize($file_data['file']);
            //$file_data['upload_time'] = $input_data['date_time'];
            
            $audio_data = array(
                'sermon_id' => $sermon->get('id'),
                'create_date' => $input_data['upload_time'],
                'type' => 'audio',
                'file_ext' => $validate->fileExt('upload_audio'),
                'name' => $sermon->get('title'),
                'description' => 'Audio file',
                'active' => 'Yes',
                'allow_download' => 'Yes',
                'file' => $file
            );
            $audioFile = $modx->newObject('MessageMedia');
            $audioFile->fromArray($audio_data);
            $audioFile->save();
        }
        // upload video file
        if( isset($_FILES['upload_video']['tmp_name']) && strlen($_FILES['upload_video']['tmp_name']) > 4 ) {
            //echo 'UPLOADING';
            // just the file name
            // ;
            $file = str_replace( $this->cmpController->config['uploadPath'], '', 
                $validate->moveFile('upload_video', $this->cmpController->config['uploadPath'], 
                    'video_'.$group_data['id'].'_'.$sermon->get('id').'_'.$validate->cleanName($sermon->get('title')) ) );
            
            $file = str_replace($this->cmpController->config['uploadPath'], '', $file);
            
            $input_data['file_size'] = filesize($file_data['file']);
            //$file_data['upload_time'] = $input_data['date_time'];
            
            $audio_data = array(
                'sermon_id' => $sermon->get('id'),
                'create_date' => $input_data['upload_time'],
                'type' => 'video',
                'file_ext' => $validate->fileExt('upload_video'),
                'name' => $sermon->get('title'),
                'description' => 'Video file',
                'active' => 'Yes',
                'allow_download' => 'Yes',
                'file' => $file
            );
            $audioFile = $modx->newObject('MessageMedia');
            $audioFile->fromArray($audio_data);
            $audioFile->save();
        } 
        
        
    
        // if repeating:
        if ( $edit_me ) {
            $message .= '<h3>The sermon '.$sermon->get('title').' has been updated.</h3>';
            
        } else {
            $message .= '<h3>The sermon  '.$sermon->get('title').' has been added.</h3>';
        }
        $this->action = 'sermons';
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
    $smartyData->formatData('sermon_date', 'form_data');
    //$smartyData->formatData('end_date', 'form_data');
    // assign the form data to the template
    $modx->smarty->assign($smartyData->buildSmarty());
    
} else {
    $message .= '<h3 class="errors">There are errors on the page, please revise.</h3>'; // call back on form 
    
    // fill in the form data:
    $smartyData = new dataToSmarty();
    // load the form data from $_POST
    $smartyData->loadForm();
    $smartyData->formatData('sermon_date', 'form_data');
    // load the error messages
    $errors = $validate->errors();
    $error_list = $smartyData->loadErrors($errors);
    // $smartyData->loadData($input_data,'form_data');
    // assign the form data to the template
    $modx->smarty->assign($smartyData->buildSmarty());
    
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