<?php
/**
 * @package doodle
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
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_notset'));
}
$album = $modx->getObject('jgSlideshowAlbum',$_DATA['id']);
if (empty($album)) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_notfound'));
}

/* set fields */
unset($_DATA['post_date']);
$album->fromArray($_DATA);

/* save */
if ($album->save() == false) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_save'));
}


return $modx->error->success('',$album);