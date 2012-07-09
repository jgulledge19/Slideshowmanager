<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) {
    return $modx->error->failure($modx->lexicon('cmp.feed_err_ns'));
}

$slide = $modx->getObject('jgSlideshowSlide',$scriptProperties['id']);
if (empty($slide)) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_notfound'));
}
// requried
if (empty($scriptProperties['title']) ) {
    $modx->error->addField('title',$modx->lexicon('slideshowmanager.slide_err_required'));
}
if ( empty($scriptProperties['description']) ) {
    $modx->error->addField('description',$modx->lexicon('slideshowmanager.slide_err_required'));
} 
if ( empty($scriptProperties['start_date']) ) {
    $modx->error->addField('start_date',$modx->lexicon('slideshowmanager.slide_err_required'));
}
if ( empty($scriptProperties['sequence']) ) {
    $modx->error->addField('sequence',$modx->lexicon('slideshowmanager.slide_err_required'));
}
if ( empty($scriptProperties['slide_status'])  ) {
    $modx->error->addField('slide_status',$modx->lexicon('slideshowmanager.slide_err_required'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

/* set fields */
$slide->fromArray($scriptProperties);

/* save */
if ($slide->save() == false) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_save'));
}


return $modx->error->success('',$slide);