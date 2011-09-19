<?php

/**
 * Loads the add album.
 *
 * @package slideshowmanager
 */
/*
$modx->regClientStartupScript($modx->getOption('manager_url').'assets/modext/util/datetime.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'widgets/template.grid.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'widgets/resource.grid.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'widgets/home.panel.js');
$modx->regClientStartupScript($batcher->config['jsUrl'].'sections/home.js');
$output = '<div id="batcher-panel-home-div"></div>';
*/

/*
 * 
 */
// load all of the lexicon values for translation
//$modx->smarty->assign( '_lang', $tmp_data = $this->modx->lexicon->fetch() );

// load slideshowmanager lexicon settings:
$slide_lexicon = new dataToSmarty();
$my_lexicon = $slide_lexicon->smartyLexicon($modx->lexicon->fetch('slideshowmanager'));
$modx->smarty->assign('_lang', $my_lexicon );

/*
 * should there be any default values?
 */
 
// urls:
$a_url = 'addalbum';
if ( isset($edit_me) && $edit_me ) {
    $a_url = 'editalbum';
}
$url_array = array( 'album_add' => '?a='.$a.'&amp;action='.$a_url);
$modx->smarty->assign('_url',$url_array);

// load the form

// now load all db/form params
$settings = array();
//$modx->smarty->assign('_params',$settings);

return $modx->smarty->fetch( MODX_CORE_PATH.'components/slideshowmanager/templates/managealbum.tpl' ); 
 




