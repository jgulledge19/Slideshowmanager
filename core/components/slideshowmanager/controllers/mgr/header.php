<?php
/**
 * Loads the header for mgr pages.
 *
 * @package cmpController
 * @subpackage controllers
 * 
 * No need to edit this file
 */
$album_id = 1;
if ( isset($_REQUEST['album_id']) && is_numeric($_REQUEST['album_id']) ) {
    $album_id = $_REQUEST['album_id'];
}
$modx->regClientStartupScript($cmpController->config['jsUrl'].'mgr/'.$cmpController->config['packageName'].'.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Cmp'/*.ucfirst($cmpController->config['packageName'])*/.'.config = '.$modx->toJSON($cmpController->config).';
});
    var cmpAlbumId = '.$album_id.';
    var cmpSlideSort = \'current\';
</script>');

return '';

/* ORG Code: 
$modx->regClientStartupScript($doodles->config['jsUrl'].'mgr/doodles.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Doodles.config = '.$modx->toJSON($doodles->config).';
});
</script>');


return '';
 */