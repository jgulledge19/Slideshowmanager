<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) {
    return $modx->error->failure($modx->lexicon('message.group_err_notset'));
}
$group = $modx->getObject('MessageGroup',$scriptProperties['id']);
if (empty($group)) {
    return $modx->error->failure($modx->lexicon('message.group_err_notfound'));
}

/* remove */
if ($group->remove() == false) {
    return $modx->error->failure($modx->lexicon('message.group_err_remove'));
}

return $modx->error->success('',$group);