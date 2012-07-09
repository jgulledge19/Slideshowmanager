<?php
/**
 * Loads the home page.
 *
 * @package doodles
 * @subpackage controllers
 * 
 * You will need to edit this file
 */

$modx->regClientStartupScript($cmpController->config['jsUrl'].'mgr/widgets/group.grid.js');
$modx->regClientStartupScript($cmpController->config['jsUrl'].'mgr/widgets/sermon.grid.js');
$modx->regClientStartupScript($cmpController->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($cmpController->config['jsUrl'].'mgr/sections/index.js');

$output = '<div id="'./*$cmpController->config['packageName'].*/'cmp-panel-home-div"></div>';

return $output;

/* ORG example 
$modx->regClientStartupScript($doodles->config['jsUrl'].'mgr/widgets/doodles.grid.js');
$modx->regClientStartupScript($doodles->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($doodles->config['jsUrl'].'mgr/sections/index.js');

$output = '<div id="doodles-panel-home-div"></div>';

return $output;
*/