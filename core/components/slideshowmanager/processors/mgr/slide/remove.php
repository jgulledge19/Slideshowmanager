<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_notset'));
}
$slide = $modx->getObject('jgSlideshowSlide',$scriptProperties['id']);
if (empty($slide)) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_notfound'));
}

require_once MODX_CORE_PATH.'components/slideshowmanager/model/slideshowmanager/jgslideshow.class.php';
$jgSlideshow = new jgSlideshow($modx);

$slide_file = $jgSlideshow->config['uploadPath'].$slide->get('file_path');
$album_id = $slide->get('slideshow_album_id');

/* remove */
if ($slide->remove() == false) {
    return $modx->error->failure($modx->lexicon('socialstream.slide_err_remove'));
}
// delete file:
if ( file_exists($slide_file) ) {
    unlink($slide_file);
}
// reorder:
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
$Sequence->order(0, 0);

return $modx->error->success('',$slide);