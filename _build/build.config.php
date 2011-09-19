<?php
// http://rtfm.modx.com/display/revolution20/Using+Custom+Database+Tables+in+your+3rd+Party+Components
//define('MODX_BASE_PATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . 'test/');
define('MODX_BASE_PATH', dirname(dirname(__FILE__)).'/' );
define('MODX_CORE_PATH', MODX_BASE_PATH . 'core/');
define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'manager/');
define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'connectors/');
define('MODX_ASSETS_PATH', MODX_BASE_PATH . 'assets/');

define('DB_MODEL_FOLDER', 'slideshowmanager');
// echo 'MODX_BASE_PATH: '.MODX_BASE_PATH;
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'assets' => $root.'assets/components/'.DB_MODEL_FOLDER.'/',
    'build' => $root .'_build/',
    'core' => $root.'core/components/'.DB_MODEL_FOLDER.'/',
    'data' => $root . '_build/data/',
    'docs' => $root.'core/components/'.DB_MODEL_FOLDER.'/docs/',
    'lexicon' => $root . 'core/components/'.DB_MODEL_FOLDER.'/lexicon/',
    'model' => $root.'core/components/'.DB_MODEL_FOLDER.'/model/',
    'resolvers' => $root . '_build/resolvers/',
    'source_core' => $root.'core/components/'.DB_MODEL_FOLDER.'',
    'source_assets' => $root.'assets/components/'.DB_MODEL_FOLDER.'',
    'schema' => $root.'_build/schema/',
);
?>