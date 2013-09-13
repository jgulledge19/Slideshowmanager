<?php
/**
 * @package 
 * @subpackage processors
*/
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)){
    return $modx->error->failure('Invalid data.');
}

/* get obj */
if (empty($_DATA['id'])) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_notset'));
}
$slide = $modx->getObject('jgSlideshowSlide',$_DATA['id']);
if ( empty($slide) ) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_notfound'));
}

/* set fields */
unset($_DATA['upload_time']);
unset($_DATA['web_user_id']);
unset($_DATA['html']);
unset($_DATA['notes']);
unset($_DATA['slideshow_album_id']);
unset($_DATA['file_path']);
unset($_DATA['image_path']);
unset($_DATA['file_size']);
unset($_DATA['file_type']);
unset($_DATA['options']);
$_DATA['version'] += 1;
/*'id','', '', 'start_date', 'end_date', 
                'sequence', 'slide_status', '', '', 'url',
                'title', 'description', '','','','','', '', ''*/

if ( isset($_DATA['start_date']) && !empty($_DATA['start_date']) ) {
    if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
        $sdate = DateTime::createFromFormat($modx->getOption('manager_date_format', null, 'Y-m-d'), $_DATA['start_date']);
        if ( is_object($sdate) ) {
            $_DATA['start_date'] = $sdate->format('Y-m-d');
        }
    } else {
        $_DATA['start_date'] = date('Y-m-d', $sdate = strtotime( $scriptProperties['start_date']));
    }
}
if ( isset($_DATA['end_date']) && !empty($_DATA['end_date']) ) {
    if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
        $edate = DateTime::createFromFormat($modx->getOption('manager_date_format', null, 'Y-m-d'), $_DATA['end_date']);
        if ( is_object($edate) ) {
            $_DATA['end_date'] = $edate->format('Y-m-d');
        }
    } else {
        $_DATA['end_date'] = date('Y-m-d', $edate = strtotime( $scriptProperties['end_date']));
    }
}

if ( $sdate > $edate ) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_end_date'));
}
$slide->fromArray($_DATA);

/* save */
if ($slide->save() == false) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_save'));
} else {
    // now reorder:
    
    // reorder:
    require_once CMP_MODEL_DIR.'sequence.class.php';
    $today = date("Y-m-d");
    $Sequence = new Sequence($modx, 'jgSlideshowSlide' );
    $Sequence->addConditions(
        array(
            'slideshow_album_id' => $slide->get('slideshow_album_id'), 
            'slide_status' => 'live',
            'start_date:<=' => $today,
            'end_date:>=' => $today
        ));
    $Sequence->order($slide->get('id'),$slide->get('sequence'));
}


return $modx->error->success('',$slide);
 
 
 
 
 
 
 
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) {
    return $modx->error->failure('Invalid data.');
}

/* get obj */
if (empty($_DATA['id'])) {
    return $modx->error->failure($modx->lexicon('suggestedsearch.suggestion_err_ns'));
}
$feed = $modx->getObject('jgSearchSuggestions',$_DATA['id']);
if (empty($feed)) {
    return $modx->error->failure($modx->lexicon('suggestedsearch.suggestion_err_nf'));
}

/* set fields */
unset($_DATA['post_date']);
$feed->fromArray($_DATA);
/* save */
if ($feed->save() == false) {
    return $modx->error->failure($modx->lexicon('suggestedsearch.suggestion_err_save'));
}


return $modx->error->success('',$feed);