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
        if ( $this->allow_file_types[$file]['width'] > 0 && $this->allow_file_types[$file]['height'] > 0 ) {
            // move file to tmp
            list($width, $height) = getimagesize($_FILES[$file]['tmp_name']);
            // width
            // height
            // echo 'W: '.$width.' - '.$this->allow_file_types[$file]['width'].' H: '.$height.' - '.$this->allow_file_types[$file]['height'];
            if ( $width != $this->allow_file_types[$file]['width'] || $height != $this->allow_file_types[$file]['height']) {
                $this->error_array[$file] = 'Incorrect file width or height';
                return FALSE;
            }
        }
        $this->validate = TRUE;
        return TRUE;
    }
    /**
     * Set file rules for the check function
     * 
     * @return void()
     */
    public function setFileRules($file, $size_limit, $type_array, $width=0, $height=0, $tmp_directory='' ) {
        $this->allow_file_types[$file]['size'] = $size_limit;// in bytes
        $this->allow_file_types[$file]['allow'] = $type_array;
        $this->allow_file_types[$file]['width'] = $width;
        $this->allow_file_types[$file]['height'] = $height;
        $this->allow_file_types[$file]['tmp_dir'] = $tmp_directory;
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
} // END
?>
