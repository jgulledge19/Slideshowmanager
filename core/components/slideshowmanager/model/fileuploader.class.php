<?php

/*
 * Upload images and resize them if nessicary
 * 
 */
 /**
 *
 * Joshua Gulledge <jgulledge19@hotmail.com>
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * Date: 7-09-2012
 * Class purpose: upload & resize images 
 * 
 * @package slideshowmanager
 * @author Joshua Gulledge  
 */
class fileUploader{
    
    protected $error_array = array();
    protected $validate = false;
    
    protected $allow_file_types = array();
    protected $size_limit = 300;//300kb is default
    protected $allow_type = array('gif','jpeg','jpg','png');// default is images
    /**
     * @param (object) $modx 
     */
    public $modx = NULL;
    
    /**
     * @param (Array) config
     */
    protected $config = array();
    
    /**
     * @param $modx
     * @param (Array) $config
     * 
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
        $this->config = array_merge(array(

        ),$config);
    }
    
    
    public function isValid(){
        return $this->validate;
    }
    /**
     * Check if the file is in the correct format
     * 
     * @return boolean - true on success and false on falure
     */
    public function checkFile($file, $required=false){
        # error
        $upload_errors = array(
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension.',
        );
        $error_code = $_FILES[$file]['error'];
        if ( $error_code == UPLOAD_ERR_NO_FILE && $required ) {
            // @TODO: Rewrite?
            $this->error_array[$file] = 'Required';
            return FALSE;
        } else if($error_code !== UPLOAD_ERR_OK) { 
            //echo '<br />Error: '.$file;
            $this->error_array[$file] = $upload_errors[$error_code].' '.$error_code;
            return FALSE;
        }
        # extention
        $filename = $_FILES[$file]['name'];
        //$file_basename = substr($filename, 0, strripos($filename, '.')); // strip extention
        $file_ext = strtolower(substr($filename, strripos($filename, '.')+1 ));
        $this->allow_file_types[$file]['ext'] = $file_ext;
        # size
        $limit = $this->size_limit;
        if ( isset($this->allow_file_types[$file]['size']) ) {
            $limit = $this->allow_file_types[$file]['size'];
        }
        $limit = $limit*1024;// convert to bytes
        if ( $_FILES[$file]['size'] > $limit) {
            if ( $limit > 1048576) { // 1 mb
                $limit_txt = number_format(($limit/1048576),3).' Mb';
            } else {
                $limit_txt = number_format(($limit/1024),0).' Kb';
            }
            $this->error_array[$file] = 'File size is to large, it must be smaller than: '.$limit_txt;
            return FALSE;
        }
        # type
        $allow_array = $this->allow_type;
        if ( isset($this->allow_file_types[$file]['allow']) ) {
            $allow_array = $this->allow_file_types[$file]['allow'];
        }
        
        if ( !in_array($file_ext, $allow_array) || !$this->_validFileType($file_ext, $_FILES[$file]['type']) ) {
            if( $file_ext == 'rtf' && $_FILES[$file]['type'] == 'application/msword' ) {
                // do nothing!
            } else{
                $this->error_array[$file] = 'Incorrect file type - ext: '.$file_ext.' mime type should be: '.$this->allow_file_types[$file]['allow']./*$this->_getFileType($file_ext)*/' but it is: '.$_FILES[$file]['type'];
                return FALSE;
            }
        }
        // check for the image width and height
        if ( $this->allow_file_types[$file]['constrain'] ){
            if ( $this->allow_file_types[$file]['width'] > 0 && $this->allow_file_types[$file]['height'] > 0 ) {
                // move file to tmp
                list($width, $height) = getimagesize($_FILES[$file]['tmp_name']);
                // width
                // height
                // echo 'W: '.$width.' - '.$this->allow_file_types[$file]['width'].' H: '.$height.' - '.$this->allow_file_types[$file]['height'];
                if ( $width != $this->allow_file_types[$file]['width'] || $height != $this->allow_file_types[$file]['height']) {
                    //$this->error_array[$file] = 'Incorrect file width or height';
                    //return FALSE;
                    // resize image:
                    $this->allow_file_types[$file]['runConstrain'] = true;
                }
            }
        }
        $this->validate = TRUE;
        return TRUE;
    }
    /**
     * Set file rules for the check function
     * @param (String) $file - the upload filename - name of the html element 
     * @param (Int) $size_limit - in KB
     * @param (Array) $type_array - the allowed file extensions
     * @param (Int) $width - the width of an image
     * @param (Int) $height - the height of an image
     * @param (String) $tmp_directory - the path of a temp directory
     * @param (Boolean) $constrain - if true it will make image the set size
     * 
     * @return void()
     */
    public function setFileRules($file, $size_limit, $type_array, $width=0, $height=0, $tmp_directory='',$constrain=TRUE ) {
        $this->allow_file_types[$file]['size'] = $size_limit;// in kilobytes
        $this->allow_file_types[$file]['allow'] = $type_array;
        $this->allow_file_types[$file]['width'] = $width;
        $this->allow_file_types[$file]['height'] = $height;
        $this->allow_file_types[$file]['tmp_dir'] = $tmp_directory;
        $this->allow_file_types[$file]['constrain'] = (boolean) $constrain;
    }
    /**
     * Move the file to the deseired locaiton
     * 
     */
    public function moveFile($file, $destination, $new_name) { //file is the name of the input feild, destination is full path with name
        if ( $this->isValid() && isset($this->allow_file_types[$file]['ext']) ) {
            $org_file = $_FILES[$file]['tmp_name'];
            $new_file = $destination.$new_name.'.'.$this->allow_file_types[$file]['ext'];
            if ( move_uploaded_file ($org_file, $new_file)) {
                // constrain image?
                if ( isset($this->allow_file_types[$file]['runConstrain']) && $this->allow_file_types[$file]['runConstrain'] ) {
                    $new_file = $this->_constrainImage($new_file, $file);
                }
                return $new_file;
            }
        }
        return false;
    }
    /**
     * 
     */
    public function fileExt($file) {
        return $this->allow_file_types[$file]['ext'];
    }
    
    
    
    
    /**
     * @access protected
     * @param (string) $ext - file extenstion
     * @return (string) mime type
     */
    protected function _getFileType($ext) {
        return '';
    }
    /**
     * @access protected
     * 
     */
    protected function _validFileType($ex, $mime) {
        $file_type_array = array(
            # documents
            'doc' =>'application/msword',
            //'docx' =>'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'rtf' => 'application/rtf',
            'txt' => 'text/plain',
            'pdf' => 'application/pdf',
            # powerpoint
            'pot' => 'application/mspowerpoint',
            'pps' => 'application/mspowerpoint',
            'ppt' => 'application/mspowerpoint',
            'ppz' => 'application/mspowerpoint',
            # excel
            'csv' => 'application/octet-stream', //'application/x-msdownload',
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
            'js' => 'application/x-javascript'
        );
        if ( $file_type_array[$ex] == $mime ) {
            return true;
        }
        // IE Specific mime types:
        // http://msdn.microsoft.com/en-us/library/ms775147.aspx + http://support.microsoft.com/kb/815455
        $ie_array = array(
            # web images image/x-xbitmap
            'gif' => 'image/gif',
            'jpeg' => 'image/pjpeg',
            'jpg' => 'image/pjpeg',
            'png' => 'image/x-png', 
            'tif' => 'image/tiff',
            'tiff' => 'image/tiff',
            );
        if ( $ie_array[$ex] == $mime ) {
            return true;
        }
        return false;
    }
    
    ///////////////////////////////////////////////////////////////
    // RESIZE Stuff:
    /**
     * 1. if propution just resize
     * 2. if not proportional then resize to the largest side h or w
     *      then fill in remainder with black
     * @param (string) $image - the image path & name
     * @param (string) $file - the file name
     */
    protected function _constrainImage($image, $file) {
        // help: http://www.plus2net.com/php_tutorial/gd-border.php
        $ext = explode(".",$image);
        $ext = strtolower(end($ext));
        
        $canvas_width = $this->allow_file_types[$file]['width'];
        $canvas_height = $this->allow_file_types[$file]['height'];
        
        // resize image:
        $image = $this->_resize($image, $canvas_height, $canvas_width);
        
        //return $image;
        list($width, $height) = getimagesize($image);
        
        if ($ext == "jpg") {
            $im = imagecreatefromjpeg($image);
        } else if ($ext == "gif") {
            $im = imagecreatefromgif ($image);
        } else if ($ext == "png") {
            $im = imagecreatefrompng ($image);
        }
        
        /**
         * Create an image (canvas) that is the size we want that will be all white
        */
        $canvas = imagecreatetruecolor($canvas_width,$canvas_height);
        
        $canvas_color = imagecolorallocate($canvas, 255, 255, 255);// white
        imagefilledrectangle($canvas, 0, 0, $canvas_width, $canvas_height, $canvas_color);
        // $difference_x = ($);
        $offset_x = 0;
        if ( $canvas_width > $width ) {
            $offset_x = ($canvas_width - $width )/2;
        }
        $offset_y = 0;
        if ( $canvas_height > $height ) {
            $offset_y = ($canvas_height - $height )/2;
        }
        // Finally let us create the new image by resizing the image
        imagecopyresized($canvas, $im, $offset_x, $offset_y, 0, 0, $width, $height, $width, $height);
        
        if ($ext == "jpg" || $ext == "jpeg") {
            imagejpeg($canvas, $image);
        } else if ($ext == "gif") {
            imagegif ($canvas, $image);
        } else if ($ext == "png") {
            imagepng ($canvas, $image,0);
        }
        return $image;
    }
    
    
    /**
     * Resize the image.
     * @param (String) $image - the path and name
     * @param (Int) $newHeight
     * @param (Int) $newWidth
     * @return (boolean)
     */
    protected function _resize ($image, $newHeight, $newWidth) {
        $ext = explode(".",$image);
        $ext = strtolower(end($ext));
        list($width, $height) = getimagesize($image);
        
        $ratio = $width/$height; // 500/300 = 1.5
        $new_ratio = $newWidth/$newHeight; // 600/300 = 2
        // end result = X/300
        if ( $new_ratio == $ratio ) {
            // just resample:
        } else if ($new_ratio > $ratio){ // height is the biggest
            $newWidth = $newHeight*$ratio;
        } else if ($new_ratio < $ratio) { // width is the biggest
            $newHeight = $newWidth*$ratio;
        }
        
        $normal  = imagecreatetruecolor($newWidth, $newHeight);
        if ($ext == "jpg") {
            $src = imagecreatefromjpeg($image);
        } else if ($ext == "gif") {
            $src = imagecreatefromgif ($image);
        } else if ($ext == "png") {
            $src = imagecreatefrompng ($image);
        }
        //$this->modx->log(modX::LOG_LEVEL_ERROR,'[fileUploader()->_resize()] H: '.$height.' W: '.$width.' NH: '. $newHeight.' NW: '. $newWidth );
        $pre = $newWidth.'x'.$newHeight.'_';
        if ( imagecopyresampled($normal, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height)){
            //$this->info .= '<div>image was resized and saved.</div>';
        }   
        if ($ext == "jpg" || $ext == "jpeg") {
            imagejpeg($normal, $image);
        } else if ($ext == "gif") {
            imagegif ($normal, $image);
        } else if ($ext == "png") {
            imagepng ($normal, $image,0);
        }
        return $image;
    }
    
} // END
?>
