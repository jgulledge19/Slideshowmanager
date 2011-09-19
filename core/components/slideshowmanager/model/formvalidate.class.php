<?php
/**
 *
 * Copyright 2010 by Joshua Gulledge <jgulledge19@hotmail.com>
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * Date: 9/18/2007 rewritten for MODX 3/17/2011
 * Class purpose: this class is made to validate(process) forms 
 * 
 * @package slideshowmanager
 */
/**
 * undocumented class
 *
 * @package slideshowmanager
 * @author Joshua Gulledge  
 */
class formValidate{
    protected $option_array = array(); // name = type
    protected $require_array = array();// just the names of the required fields
    //protected $return_array = array();
    
    /**
     * undocumented class variable
     *
     * @var string
     */
    protected $input_type = 'text';//int, phone, email, html, ??
    protected $error_array = array();
    protected $validate = false;
    protected $validated_array = array();// name = value & addslashes
    protected $add_slashes = false;
    protected $method = "post";
    protected $informix_date = false;
    protected $allow_file_types = array();
    protected $size_limit = 300;//300kb is default
    protected $allow_type = array('gif','jpeg','jpg','png');// default is images
    
    
    /**
     * The constructor for formValidate
     *
     * @access public
     * @param array $option_array The data in name => value pairs
     *      where value is the validation method choose from:
     *       date, date_unix, date_select, date_select_unix, date_time, date_time_unix, 
     *       time, time_unix, set_current_date, set_current_date_unix, 
     *       set_current_date_time, set_current_date_time_unix, 
     *       HTML, text, text & links, email, checkbox_array, file
     *       numeric, SSN, zip, phone, price, fax 
     * @param array $require_array This is an array will all required fields,
     *      ex: array('feild1', 'feild2')
     * @param string $method This is the submitted form method: get, post
     *      @default is post
     * @return boolean
     */
    public function __construct($option_array, $require_array, $method="post"){
        $this->option_array = $option_array;
        $this->require_array = $require_array;
        $this->method = $method;
    }
    
    public function informixDate(){
        $this->informix_date = true;
    }
    public function isValid(){
        return $this->validate;
    }
    public function setError($field, $error_message){
        $this->error_array[$field] = $error_message;
        $this->validate = false;
    }
    public function errors(){
        return $this->error_array;
    }
    /*
     * public validate 
     * @returns bool
     */
    public function validate(){
        //this does all the work!!
        
        foreach($this->option_array as $name=>$type){
            $value = $this->requestValue($name);
            switch($type){
                case "date":
                    $this->_checkDate($name, $type, 'date');
                    break;
                case "date_unix":
                    $this->_checkDate($name, $type, 'unix');
                    break;
                case "date_select":
                    $this->_checkDateSelect($name, $type, 'date');
                    break;
                case "date_time":
                    $this->_checkDateTime($name, $type, 'date' );
                    break;
                case "date_time_unix":
                    $this->_checkDateTime($name, $type,  'unix' );
                    break;
                case "date_select_unix":
                    $this->_checkDateSelect($name, $type, 'unix');
                    break;
                case "time":
                    $this->_checkTime($name, $type, 'date');
                    break;
                case "time_unix":
                    $this->_checkTime($name, $type, 'unix');
                    break;
                case "set_current_date":
                case "set_current_date_unix":
                case "set_current_date_time":
                case "set_current_date_time_unix":
                    $this->_setCurrentTime($name, $type);
                    break;
                case "HTML":
                case "text":
                case "text & links":
                    $this->_checkHtml($name, $value, $type );
                    break;
                case "checkbox_array":
                    $this->_checkboxArray($name, $value, $type );
                    break;
                case "numeric":
                case "SSN":
                case "zip":
                case "phone":
                case 'price':
                case "fax":
                    $this->_checkNumeric($name, $value, $type );
                    break;
                case "email":
                    $this->_checkEmail($name, $value, $type);
                    break;
                case "file":
                    $this->checkFile($name);
                    break;
                default:
                    $this->_isRequired($name, $value);
                    break;
            }
        }
        if ( count($this->error_array ) > 0) {
            // this failed
            $this->validate = false;
        } else {
            // this passed
            $this->validate = true;
            //echo ' - - True - - ';
        }
        return $this->validate;
    }
    /*
     * @return void
     */
    public function checkFile($file){
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
        if ( $error_code == UPLOAD_ERR_NO_FILE ) {
            $this->_isRequired($file, '');
            return;
        } elseif($error_code !== UPLOAD_ERR_OK) { 
            //echo '<br />Error: '.$file;
            $this->error_array[$file] = $upload_errors[$error_code].' '.$error_code;
            return;
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
            return;
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
                $this->error_array[$file] = 'Incorrect file type - ext: '.$file_ext.' mime type should be: '.$this->_getFileType($file_ext).' but it is: '.$_FILES[$file]['type'];
                return;
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
                return;
            }
        }
        
        
    }
    public function setFileRules($file, $size_limit, $type_array, $width=0, $height=0, $tmp_directory='' ) {
        $this->allow_file_types[$file]['size'] = $size_limit;// in bytes
        $this->allow_file_types[$file]['allow'] = $type_array;
        $this->allow_file_types[$file]['width'] = $width;
        $this->allow_file_types[$file]['height'] = $height;
        $this->allow_file_types[$file]['tmp_dir'] = $tmp_directory;
    }
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
    public function fileExt($file) {
        return $this->allow_file_types[$file]['ext'];
    }
    /*
     * Date functions: 
     */
    private function _setCurrentTime($name, $type) {
        $time = '';
        switch($type) {
            case "set_current_date_time":
                $time = ' '.date("H:i:s");
            case "set_current_date":
                $date = date("Y-m-d").$time;
                break;
            case "set_current_date_unix":
                $date = strtotime( date("m/d/Y") );
            case "set_current_date_time_unix":
                $date = time();
                break;
        }
        if ( $this->informix_date ) {
            switch($type){
                case "set_current_date_time":
                    $time = ' '.date("H:i:s");
                case "set_current_date":
                    $date = date("m/d/Y").$time;
                    break;
            }
        }
        $this->setRequestValue($name, $date);
    }
    private function _checkDateSelect($name, $type, $format='unix' ) {
        $var = array('_m', '_d', '_y');
        for ($x = 0; $x < 3; $x++) {
            if ( !$this->_isRequired($name.$var[$x], $this->requestValue($name.$var[$x])) ){
                //this is required and it failed 
            } else {
                $this->_checkNumeric($name.$var[$x], $this->requestValue($name.$var[$x]) , $type);
            }
        }
        // assign to date
        if ( $format == 'unix' ) { 
            $tmp = strtotime($this->requestValue($name."_m")."/".$this->requestValue($name."_d")."/".$this->requestValue($name.'_y') );
        } else {
            $tmp = $this->requestValue($name.'_y')."-".$this->requestValue($name."_m")."-".$this->requestValue($name."_d");
            if ( $this->informix_date ) {
                $tmp = $this->requestValue($name."_m")."/".$this->requestValue($name."_d")."/".$this->requestValue($name.'_y');
            }
            
        }
        if ( $tmp == '-- ::00' || (!$this->issetName($name."_m") && !$this->issetName($name."_d") && !$this->issetName($name.'_y') ) ) {
            unset($this->option_array[$name]);
        } else {
            $this->setRequestValue($name, $tmp);
        }
        return $tmp; 
    }
    # 1 date input
    private function _checkDate($name, $type, $format='unix' ){
        if( !$this->_isRequired($name, $this->requestValue($name)) ){
            return;
        }
        $tmp = 'NULL';
        // is it a date formated correctly?
        if ( $this->requestValue($name) != NULL ) {
            list($m,$d,$y) = explode('/', $this->requestValue($name) );
            if ( !is_numeric($m) || !is_numeric($d) || !is_numeric($y) || $m > 12 || $d > 31 || strlen($y) < 4 || strlen($y) > 4  ){
                // ERROR!
                $this->error_array[$name] = 'Date is not formatted properly, please set to: MM/DD/YYYY ';
                return;
            }
            // assign to date
            if ($format == 'unix') {
                $tmp = strtotime($this->requestValue($name));
            } else {
                $tmp = $y."-".$m."-".$d;
                if( $this->informix_date ){
                    $tmp = $m."/".$d."/".$y;
                }
            }
        }
        $this->setRequestValue($name, $tmp);
        return $tmp; 
    }
    /*
     * Time
     */
    private function _checkTime($name, $type, $format='unix') {
        $var = array('_hr', '_min', '_am');
        //$name.'_am' // radio am or pm
        //Validate data
        for ($x = 0; $x < 3; $x++) {
            if ( !$this->_isRequired($name.$var[$x], $this->requestValue($name.$var[$x])) ) {
                //this is required and it failed 
            } elseif ($x < 2 ) {
                $this->_checkNumeric($name.$var[$x], $this->requestValue($name.$var[$x]) , $type);
            }
        }
        
        if (strtolower($this->requestValue($name.'_am')) == 'pm' && $this->requestValue($name.'_hr') != '12' ) {
            //$_REQUEST[$name.'_hr'] += 12;
            $this->setRequestValue($name.'_hr', ($this->requestValue($name.'_hr')+12) );
        }
        if ($format == 'unix') {
            //$_REQUEST[$name] 
            $tmp = $this->requestValue($name."_hr")*3600 + $this->requestValue($name."_min")*60;
        } else {
            //$_REQUEST[$name]
            $tmp = $this->requestValue($name."_hr").':'.$this->requestValue($name."_min").':00';
        }
        $this->setRequestValue($name, $tmp);
        return $tmp;
    }
    /*
    *    Date & Time
    */
    private function _checkDateTime($name, $type, $format='unix') {
        $time = $this->_checkTime($name, $type, $format);
        $date = $this->_checkDateSelect($name, $type, $format);
        //echo '<br>Date: '.$date.' -  time: '.$time;
        
        if ($format == 'unix' ) {
            //$_REQUEST[$name] = $date + $time;
            $this->setRequestValue($name, ($date + $time) );
        } else {
            //$_REQUEST[$name] = $date.' '.$time;
            $this->setRequestValue($name, ($date.' '.$time) );
        }
        return;
    }
    
    /*
    * check HTML
    *  This function simply returns false if there is an HTML or HTTP links in the value! 
    */
    private function _checkHtml($name, $value, $type) {
        if ( !$this->_isRequired($name, $value ) ) {
            //this is required and it failed 
        } elseif ( $type == "HTML") {
            return true;
        } elseif ( strlen($value) != strlen(strip_tags($value) ) ) {
            //echo "string contains HTML";
            $this->error_array[$name] = 'Remove HTML tags ex: &lt;strong&gt;';
        }
        // Note our use of ===.  Simply == would not work as expected
        // because the position of 'h' was the 0th (first) character.
        //elseif($pos === true &&  $type != 'text & links' ) {
        elseif ( (substr_count($value, 'http://') > 0 || substr_count($value, 'HTTP://') > 0) &&  $type != 'text & links' ) {
           $this->error_array[$name] = 'Remove Links ex: http://www.bethelcollege.edu';
        }
        return true;
    }
    private function _checkboxArray($name, $value, $type ) {
        // this will go though and check all in the array
        switch (strtoupper($this->method) ) {
            case 'POST':
                $name_array = $_POST[$name];
                /*foreach( $_POST[$name] as $name => $value ){
                    //echo '<br />Name: '.$name.' -- '.$value;
                }*/
                break;
            case 'GET':
                $name_array = $_GET[$name];
                break;
            default:
                $name_array = $_REQUEST[$name];
                break;
        }
        $this->_checkRequiredArray($name, $name_array);
        return true;
    }
    private function _checkRequiredArray($name, $name_array) {
        // return true or flase
        $failed = false;
        if (is_array($name_array) ) {
            foreach ( $name_array as $tmp_name => $tmp_value) {
                //check if NULL
                //echo '<br />N: '.$tmp_name.' -- V: '.$tmp_value;
                
                if ($tmp_value == NULL && in_array($name, $this->require_array, empty($tmp_value) && $tmp_value !== '0') ) {
                    // this is failed
                    //echo "<br />Failed!!!!";
                    $failed = true;
                } else {
                    return true;
                }
            }
        }
        if ( $failed || in_array($name, $this->require_array, empty($tmp_value) && $tmp_value !== '0') ) {
            $this->error_array[$name.'[]'] = 'Required';
        }
        return true;
    }
    private function _checkNumeric($name, $value, $type=NULL) {
        //    this function checks if the value is numeric or phone #
        //strip spaces
        $tmp = $value;
        $differance = 1;//dottes?
        if ($type=='phone' || $type == 'fax' ) {    
            $tmp = str_replace(" ","",$value);
            $tmp_len = strlen($tmp);
            $tmp = str_replace("+","",$tmp);// international
            //strip (
            $tmp = str_replace("(","",$tmp);
            //strip )
            $tmp = str_replace(")","",$tmp);
            //strip hashes
            $tmp = str_replace("-","",$tmp);

            //strip periods
            $tmp = str_replace(".","",$tmp);
            $differance = 4;
        } elseif ($type=='price' ) {    
            //strip periods
            $tmp = str_replace(".","",$tmp);
            $tmp = str_replace(",","",$tmp);
        } elseif ($type=='zip' ) {    
            //strip hashes
            //
            $tmp = str_replace("-","",$tmp);
            //if( !eregi("[0-9]{5}(-[0-9]{4})?|[ABCEGHJKLMNPRSTVXY]\d[A-Z] *\d[A-Z]\d?", $tmp ) && $tmp != NULL ) {
            if( strlen(trim($tmp)) < 4 && $this->_isRequired($name, $value) && $tmp != '' ){
                $this->error_array[$name] = 'Invalid Zip Code';
            }
            return false;
        } elseif ($type == 'SSN' ) {
            // SSN 111-11-1111
            $tmp_len = strlen(trim($tmp));
            if ( $tmp_len > 11 ) {
                $valid_ssn = false;
            } elseif ( $tmp_len > 0 ) {
                $valid_ssn = false;
                list($st, $mid, $last) = explode('-',$tmp);
                if( is_numeric($st) && is_numeric($mid) && is_numeric($last)){
                    if( strlen($st) == 3 && strlen($mid) == 2 && strlen($last) == 4 ){
                        $valid_ssn = true;
                    }
                }
            }
            if ( isset($valid_ssn) && !$valid_ssn && $this->_isRequired($name, $value) && $tmp != '' ) {
                $this->error_array[$name] = 'SSN formated incorectly, proper format: 111-11-1111';
                return false;
            }
            return true;
        }
        $tmp_len_end = strlen($tmp);
        
        if ( !$this->_isRequired($name, $value) ) {
            //this is required and it failed 
        } elseif ( (!is_numeric($tmp) && $tmp != NULL )|| ( isset($tmp_len) && (( $tmp_len - $tmp_len_end ) > $differance) )  ) {
            if ($type=='phone') {
                $this->error_array[$name] = 'Invalid Phone Number';
            } elseif ($type=='fax') {
                $this->error_array[$name] = 'Invalid Fax Number';
            } elseif ($type == 'zip') {
                $this->error_array[$name] = 'Invalid Zip Code';
            } else {
                $this->error_array[$name] = 'Invalid Number';//.$name;
            }
        }
        return true;
    }
    
    private function _checkEmail($name, $email) {
        // This function just checks the format of the email
        if ( !$this->_isRequired($name, $email) ) {
            //this is required and it failed 
        }
        // http://www.linuxjournal.com/article/9585
        /*
        Validate an email address.
        Provide email address (raw input)
        Returns true if the email address has the email 
        address format and the domain exists.
         */
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex+1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
             // local part length exceeded
             $isValid = false;
            } else if ($domainLen < 1 || $domainLen > 255) {
                // domain part length exceeded
                $isValid = false;
            } else if ($local[0] == '.' || $local[$localLen-1] == '.') {
                // local part starts or ends with '.'
                $isValid = false;
            } else if (preg_match('/\\.\\./', $local)) {
                // local part has two consecutive dots
                $isValid = false;
            } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                // character not valid in domain part
                $isValid = false;
            } else if (preg_match('/\\.\\./', $domain)) {
                // domain part has two consecutive dots
                $isValid = false;
            } elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
                // character not valid in local part unless 
                // local part is quoted
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
                    $isValid = false;
                }
            }
            if ( $isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
                // domain not found in DNS
                $isValid = false;
            }
        }
        if ( !$isValid ) {
            $this->error_array[$name] = 'Invalid e-mail';
        }
        
        /* OLD:
        elseif( !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email ) && $email != NULL ) {
            $this->error_array[$name] = 'Invalid e-mail';
        }*/
        return true;
    }
    
    private function _isRequired($name, $value, $require =NULL ){
        // return true or flase
        if ($value == NULL && in_array($name, $this->require_array, empty($value) && $value !== '0') ) {
            $this->error_array[$name] = 'Required';
            //echo 'REQUIRED!!!!!';
            return false;
        }
        return true;
    }
    /*
    * @return validated data array( nam=>value)
    */
    public function validatedData($add_slashes=true) {
        foreach ($this->option_array as $name=>$type ) {
            if ( $add_slashes ) {
                //add slashes to array
                $this->validated_array[$name] = addslashes($this->requestValue($name));
            } else {
                $this->validated_array[$name] = $this->requestValue($name);
            }
        }
        return $this->validated_array;
    }
    /*
     * General $_GET[], $_POST[], and $_REQUEST[] fuctions
     * 
     */
    public function requestValue($name){
        switch (strtoupper($this->method) ){
            case 'POST':
                if ( isset($_POST[$name]) ) {
                    return $_POST[$name];
                }
                break;
            case 'GET':
                if ( isset($_GET[$name]) ) {
                    return $_GET[$name];
                }
                break;
            default:
                if ( isset($_REQUEST[$name]) ) {
                    return $_REQUEST[$name];
                }
                break;
        }
        return NULL;
    }
    /**
     * @access public
     * 
     */
    public function setRequestValue($name, $value) {
        switch (strtolower($this->method) ) {
            case 'post':
                $_POST[$name] = $value;
                break;
            case 'get':
                $_GET[$name] = $value;
                break;
            default:
                $_REQUEST[$name] = $value;
                break;
        }
    }
    public function unsetRequestValue($name) {
        switch (strtolower($this->method) ) {
            case 'post':
                unset($_POST[$name]);
                break;
            case 'get':
                unset($_GET[$name]);
                break;
            default:
                unset($_REQUEST[$name]);
                break;
        }
    }
    public function issetName($name) {
        //return isset
        switch (strtolower($this->method) ) {
            case 'post':
                return isset($_POST[$name]);
                break;
            case 'get':
                return isset($_GET[$name]);
                break;
            default:
                return isset($_REQUEST[$name]);
                break;
        }
    }
    private function _validFileType($ex, $mime) {
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