<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_notset'));
}
$album = $modx->getObject('jgSlideshowAlbum',$scriptProperties['id']);
if (empty($album)) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_notfound'));
}

/* remove */
if ($album->remove() == false) {
    return $modx->error->failure($modx->lexicon('socialstream.album_err_remove'));
}

return $modx->error->success('',$album);