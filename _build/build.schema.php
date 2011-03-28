<?php
/**
 * Build Schema script
 *
 * @package storefinder
 * @subpackage build
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

require_once dirname(__FILE__) . '/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php'; 
$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

// The folders below must be manually created, before running the script
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'core' => $root.'core/components/'.DB_MODEL_FOLDER.'/',
    'model' => $root.'core/components/'.DB_MODEL_FOLDER.'/model/',
    'assets' => $root.'assets/components/'.DB_MODEL_FOLDER.'/',
    'schema' => $root.'_build/schema/',
);

// load xPDOManager and xPDOGenerator, two classes we'll need to build our schema map files.
$manager= $modx->getManager();
$generator= $manager->getGenerator();

// And finally, we want to actually parse the DB schema file we created into a file:
$generator->parseSchema($sources['schema'].DB_MODEL_FOLDER.'.mysql.schema.xml', $sources['model']);

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";

exit ();

?>