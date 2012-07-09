<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) {
    return $modx->error->failure($modx->lexicon('message.feed_err_ns'));
}

$group = $modx->getObject('MessageGroup',$scriptProperties['id']);
if (empty($group)) {
    return $modx->error->failure($modx->lexicon('message.group_err_notfound'));
}
// requried
if (empty($scriptProperties['name']) ) {
    $modx->error->addField('name',$modx->lexicon('message.group_err_required'));
}
if ( empty($scriptProperties['description']) ) {
    $modx->error->addField('description',$modx->lexicon('message.group_err_required'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

/* set fields */
$group->fromArray($scriptProperties);

/* save */
if ($group->save() == false) {
    return $modx->error->failure($modx->lexicon('message.group_err_save'));
}


return $modx->error->success('',$group);