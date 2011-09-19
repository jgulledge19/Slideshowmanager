<?php
/**
 * @package doodle
 * @subpackage processors
 */

/* get obj */
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('suggestedsearch.feed_err_ns'));
$feed = $modx->getObject('jgSearchSuggestions',$scriptProperties['id']);
if (empty($feed)) return $modx->error->failure($modx->lexicon('suggestedsearch.feed_err_nf'));

/* set fields */
unset($scriptProperties['post_date']);
$feed->fromArray($scriptProperties);

/* save */
if ($feed->save() == false) {
    return $modx->error->failure($modx->lexicon('suggestedsearch.feed_err_save'));
}


return $modx->error->success('',$feed);