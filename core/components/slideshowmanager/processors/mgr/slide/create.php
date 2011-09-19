<?php
/**
 * @package CMP
 * @subpackage processors
 * This file needs to be customized
 */

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

/* save */
if ($suggestion->save() == false) {
    return $modx->error->failure($modx->lexicon('suggestedsearch.account_err_save'));
}

return $modx->error->success('',$suggestion);