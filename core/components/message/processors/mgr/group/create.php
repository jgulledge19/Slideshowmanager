<?php
/**
 * @package CMP
 * @subpackage processors
 * This file needs to be customized
 */

if (empty($scriptProperties['name']) ) {
    $modx->error->addField('name',$modx->lexicon('message.group_err_required'));
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
    $modx->error->addField('description',$modx->lexicon('message.group_err_required'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

$group = $modx->newObject('MessageGroup');
$scriptProperties['icon_path'] = '';
$group->fromArray($scriptProperties);
// 
/* save */
if ( $group->save() == false) {
    return $modx->error->failure($modx->lexicon('message.group_err_save'));
}

return $modx->error->success('',$group);