<?php
/**
 * package CMP
 * subpackage processors
 * This file needs to be customized
 

if (empty($scriptProperties['display_title'])) {
    $modx->error->addField('display_title',$modx->lexicon('suggestedsearch.account_err_ns_name'));
} else {
    $alreadyExists = $modx->getObject('jgSearchSuggestions',
        array(
            'display_title' => $scriptProperties['display_title'],
            'resource_id' => $scriptProperties['resouce_id'],
            )
        );
    if ($alreadyExists) {
        $modx->error->addField('display_title',$modx->lexicon('suggestedsearch.account_err_ae'));
    }
}


if ($modx->error->hasError()) {
    return $modx->error->failure();
}

$suggestion = $modx->newObject('jgSearchSuggestions');
$suggestion->fromArray($scriptProperties);

/* save 
if ($suggestion->save() == false) {
    return $modx->error->failure($modx->lexicon('suggestedsearch.account_err_save'));
}

return $modx->error->success('',$suggestion);*/
/**
 * @package CMP
 * @subpackage processors
 * This file needs to be customized
 */

if ( empty($scriptProperties['title']) ) {
    $modx->error->addField('title',$modx->lexicon('slideshowmanager.slide_err_required'));
}
if ( empty($scriptProperties['description']) ) {
    $modx->error->addField('description',$modx->lexicon('slideshowmanager.slide_err_required'));
} 
if ( empty($scriptProperties['start_date']) ) {
    $modx->error->addField('start_date',$modx->lexicon('slideshowmanager.slide_err_required'));
}
if ( empty($scriptProperties['end_date']) ) {
    $modx->error->addField('end_date',$modx->lexicon('slideshowmanager.slide_err_required'));
}
if ( empty($scriptProperties['slide_status']) ) {
    $modx->error->addField('slide_status',$modx->lexicon('slideshowmanager.slide_err_required'));
}
if ( empty($scriptProperties['sequence'])  ) {
    $modx->error->addField('sequence',$modx->lexicon('slideshowmanager.slide_err_required'));
}


if ($modx->error->hasError()) {
    return $modx->error->failure();
}

$slides = $modx->newObject('jgSlideshowSlide');
$slides->fromArray($scriptProperties);
// 
/* save */
if ($slides->save() == false) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.slide_err_save'));
}

return $modx->error->success('',$slides);