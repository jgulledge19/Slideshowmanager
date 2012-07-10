<?php
/**
 * @package CMP
 * @subpackage processors
 * This file needs to be customized
 */

if (empty($scriptProperties['title']) ) {
    $modx->error->addField('title',$modx->lexicon('slideshowmanager.album_err_required'));
}
/*else {
    $alreadyExists = $modx->getObject('CMP-ClassObject',
        array(
            'username' => $scriptProperties['username'],
            'service' => $scriptProperties['service'],
            )
        );
    if ($alreadyExists) {
        $modx->error->addField('username',$modx->lexicon('cmp.account_err_ae'));
    }
}*/
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

$album = $modx->newObject('jgSlideshowAlbum');
$scriptProperties['icon_path'] = '';
$album->fromArray($scriptProperties);
// 
/* save */
if ($album->save() == false) {
    return $modx->error->failure($modx->lexicon('slideshowmanager.album_err_save'));
}

return $modx->error->success('',$album);