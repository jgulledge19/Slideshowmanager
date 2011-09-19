<?php
/**
 * Loads the data into the form and then call on addalbum.php
 *
 * @package slideshowmanager
 */
// load default data 
if ( isset($_GET['slide_id']) && is_numeric($_GET['slide_id'])) {
    $slide = $modx->getObject('jgSlideshowSlide', array('id' => $_GET['slide_id']));
    $default_data = array();
    if ( is_object($slide) ) {
        //echo 'Old';
        $default_data = $slide->toArray();
        // format the date options
        require_once $this->cmpController->config['modelPath'].'datatosmarty.class.php';
        $smartyData = new dataToSmarty();
         // load the default form data from the DB
        $smartyData->loadData($default_data);
        // format dates
        $smartyData->formatData('start_date');
        $smartyData->formatData('end_date');
        //print_r($default_data);
        // assign the form data to the template
        $modx->smarty->assign($smartyData->buildSmarty('_frm', true));
        $modx->smarty->assign(array('edit_me' => true ) );
        $edit_me = true;
        
    } else {
        //echo 'New';
        $this->action = 'addslide';
        $edit_me = false;
    }
}
return include 'addslide.php';