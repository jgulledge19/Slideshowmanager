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
    return $modx->error->failure($modx->lexicon('message.sermon_err_notset'));
}
$sermon = $modx->getObject('MessageSermons',$_DATA['id']);
if (empty($sermon)) {
    return $modx->error->failure($modx->lexicon('message.sermon_err_notfound'));
}

/* set fields */
unset($_DATA['create_date']);
// format the sermon date
list($m,$d, $year) = explode('/',$_DATA['sermon_date']);
$_DATA['sermon_date'] = $year.'-'.$m.'-'.$d;
$sermon->fromArray($_DATA);

/* save */
if ($sermon->save() == false) {
    return $modx->error->failure($modx->lexicon('message.sermon_err_save'));
}


return $modx->error->success('',$sermon);