<?php
$count = 1;

$folder = 'nivo/';
$current_dir = dirname(dirname(dirname(__FILE__))).'/core/components/slideshowmanager/elements/chunks/'.$folder; 
$open_dir = opendir( $current_dir ) ;

while ( $tmp_file = readdir( $open_dir ) ) {
    if ( $tmp_file != '.' && $tmp_file != '..' ) {
        # dir
        if ( is_dir( $current_dir.$tmp_file ) ) {
            continue;
        } elseif( is_file($current_dir.$tmp_file) ) {
            echo '
$chunks[++$x]= $modx->newObject(\'modChunk\');
$chunks[$x]->fromArray(array(
    \'id\' => $x,
    \'name\' => \''.str_replace('.chunk.tpl', '', $tmp_file).'\',
    \'description\' => \'\',
    \'snippet\' => file_get_contents($sources[\'source_core\'].\'/elements/chunks/'.$folder.$tmp_file.'\'),
    \'properties\' => \'\',
),\'\',true,true);
            ';

        }
    }
}
