<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) {
    return $modx->error->failure($modx->lexicon('cmp.feed_err_ns'));
}

$album = $modx->getObject('jgSlideshowAlbum',$scriptProperties['id']);
if (empty($album)) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_notfound'));
}
// requried
if (empty($scriptProperties['title']) ) {
    $modx->error->addField('title',$modx->lexicon('slideshowmanager.album_err_required'));
}
if ( empty($scriptProperties['description']) ) {
    $modx->error->addField('description',$modx->lexicon('slideshowmanager.album_err_required'));
} 
if ( empty($scriptProperties['file_size_limit']) ) {
    $modx->error->addField('file_size_limit',$modx->lexicon('slideshowmanager.album_err_required'));
}
if ( empty($scriptProperties['file_width']) ) {
    $modx->error->addField('file_width',$modx->lexicon('slideshowmanager.album_err_required'));
}
if ( empty($scriptProperties['file_height'])  ) {
    $modx->error->addField('file_height',$modx->lexicon('slideshowmanager.album_err_required'));
}
if ( empty($scriptProperties['constrain']) ) {
    $scriptProperties['constrain'] = 0;
}
if ($modx->error->hasError()) {
    return $modx->error->failure();
}

/* set fields */
$album->fromArray($scriptProperties);

/* save */
if ($album->save() == false) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_save'));
}


return $modx->error->success('',$album);