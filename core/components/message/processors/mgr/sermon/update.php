<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) {
    return $modx->error->failure($modx->lexicon('message.feed_err_ns'));
}

$sermon = $modx->getObject('MessageSermons',$scriptProperties['id']);
if (empty($sermon)) {
    return $modx->error->failure($modx->lexicon('message.group_err_notfound'));
}
// requried
if (empty($scriptProperties['title']) ) {
    $modx->error->addField('title',$modx->lexicon('message.group_err_required'));
}
if ( empty($scriptProperties['description']) ) {
    $modx->error->addField('description',$modx->lexicon('message.group_err_required'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

/* set fields */
$sermon->fromArray($scriptProperties);

/* save */
if ($sermon->save() == false) {
    return $modx->error->failure($modx->lexicon('message.group_err_save'));
}


return $modx->error->success('',$sermon);