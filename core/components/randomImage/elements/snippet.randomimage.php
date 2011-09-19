<?php
/**
 * display a random image for a selected directory
 */
$image_path = '';

/**
 * 1. get all of the image files in the directory
 * 2. randomly pick one and send the path back
 */
$current_dir = '';
$site_path = str_replace('core/', '', $modx->getOption('core_path'));
$base_url = 'assets/content/backgrounds/';

$current_dir = $site_path.$base_url;// this is the base 

$allowed_types = array('gif', 'jpeg', 'jpg', 'png');

$file_type_array = array(
        # documents
        'doc' =>'application/msword',
        'docx' =>'application/msword',
        //'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'rtf' => 'application/rtf',
        'txt' => 'text/plain',
        'pdf' => 'application/pdf',
        # powerpoint
        'pot' => 'application/mspowerpoint',
        'pps' => 'application/mspowerpoint',
        'ppt' => 'application/mspowerpoint',
        'ppz' => 'application/mspowerpoint',
        # excel
        'csv' => 'application/x-msdownload',
        'xlc' => 'application/vnd.ms-excel',
        'xls' => 'application/vnd.ms-excel',
        # web images
        'gif' => 'image/gif',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png', 
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        # web files
        'css' => 'text/css',
        'htm' => 'text/html',
        'html' => 'text/html',
        'xml' => 'text/xml',
        'js' => 'application/x-javascript',
        # video
        'avi' => 'video/x-msvideo',
        'dl' => 'video/dl',
        'fli' => 'video/fli',
        'fli' => 'video/x-fli',
        'flv' => 'video/flv',
        'gl' => 'video/gl',
        'mp2' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mov' => 'video/quicktime',
        'qt' => 'video/quicktime',
        'viv' => 'video/vnd.vivo', 
        'vivo' => 'video/vnd.vivo', 
        'wmv' => 'video/x-ms-wmv',
        'wmx' => 'video/x-ms-wmx',
        'wvx' => 'video/x-ms-wvx',
        'asf' => 'video/x-ms-asf',
        'asx' => 'video/x-ms-asx',
        'movie' => 'video/x-sgi-movie'
    );


// Array that will hold the dir/folders names.
$dir_array = array();
//$dir_info_array = array();
$file_array = array();
$file_info_array = array();

$open_dir = opendir( $current_dir ) ;

while ( $tmp_file = readdir( $open_dir ) ) {
    if ( $tmp_file != '.' && $tmp_file != '..' ) {
        # dir
        if ( is_dir( $current_dir.$tmp_file ) ) {
            $dir_array[] = $tmp_file;
        # files
        } elseif ( is_file($current_dir.$tmp_file) ) {
            $file_size = @filesize( $current_dir.$tmp_file ) ;
            if ( !$file_size ) {
                $file_size = 0 ;
            }
            if ( $file_size < 1024*1024) {
                $file_size = round( $file_size / 1024 ).'kb';
                if ( $file_size < 1 ) {
                    $file_size = '1kb';
                }
            } else {
                $file_size = round( $file_size/(1024*1024) ).'mb';
            }
            
            # get the type of file
            $file_ext = substr($tmp_file, strripos($tmp_file, '.')+1 );
            
            if ( in_array($file_ext, $allowed_types) ){
                $file_array[] = $tmp_file;
                $file_info_array[$tmp_file] = array(
                    'type' => '', // jpg, html, php, ect.
                    'content_type' => $file_type_array[$file_ext],
                    'size' => $file_size,
                    'date' => date("M/j/Y g:ia",filemtime($current_dir.$tmp_file)) );
            } else {
                continue;
            }
        }
    }
}
closedir($open_dir);

$image_path = $base_url.( $file_array[array_rand($file_array)] );

return $image_path;
