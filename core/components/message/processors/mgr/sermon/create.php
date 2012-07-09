<?php
/**
 * package CMP
 * subpackage processors
 * This file needs to be customized
 
*/
if (empty($scriptProperties['title']) ) {
    $modx->error->addField('title',$modx->lexicon('message.group_err_required'));
}
if (empty($scriptProperties['speaker']) ) {
    $modx->error->addField('speaker',$modx->lexicon('message.group_err_required'));
}
if (empty($scriptProperties['sermon_date']) ) {
    $modx->error->addField('sermon_date',$modx->lexicon('message.group_err_required'));
}
if (empty($scriptProperties['sermon_status']) ) {
    $modx->error->addField('sermon_status',$modx->lexicon('message.group_err_required'));
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
    $modx->error->addField('description',$modx->lexicon('message.sermon_err_required'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

$sermon = $modx->newObject('MessageSermons');
$scriptProperties['icon_path'] = '';
$sermon->fromArray($scriptProperties);
// 
/* save */
if ( $sermon->save() == false) {
    return $modx->error->failure($modx->lexicon('message.sermon_err_save'));
}

return $modx->error->success('',$sermon);