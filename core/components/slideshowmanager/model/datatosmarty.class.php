<?php
/**
 *
 * Copyright 2011 by Joshua Gulledge <jgulledge19@hotmail.com>
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * Pupose: This class is written to load form data into forms, works with formvalidate.php
 * Objectives: 
 *   1. Load default DB data into proper Lexicon form
 *   2. Load error into a smarty capible array, the following form data for each form element
 *      value - the actual value ex: ex: {$_frm.name.value}
 *      name.selected - for radio buttons ex smarty useage: {$_frm.name.selected.value}
 *      cheched - for checkboxes ex: {$_frm.name.checked}
 *      errorMsg - for error messages ex: {$_frm.name.errorMsg}
 *      isError - bool ex: {if $_frm.name.isError }<span>{$_frm.name.errorMsg}</span>{/if}
 *      errorNumber - the number of the error ex: {if $_frm.name.isError }<span>{$_frm.name.errorNumber}</span>{/if}
 * 
 * Date: 3/21/2011
 * 
 * @package slideshowmanager
 * @author Joshua Gulledge  
 */
class dataToSmarty {
    /**
     * @var array $errors A collectoin of error for the form, as in name => boolean
     * @access protected
     */
    protected $is_error_array = array();
    /**
     * @var array $errors A collection of all the processed error messages as in name => error
     * @access protected
     */
    protected $error_msg_array = array();
    /**
     * @var array $error_no_array A collection of all the processed errors grouped by error as in number => error
     * @access protected
     */
    protected $error_no_array = array();
    /**
     * @var array $error_list A list of errors grouped by error as in number => error
     * @access protected
     */
    protected $error_list = array('');
    /**
     * @var array $default_data The data loaded from the database or basic/default
     * @access protected
     */
    protected $default_data = array();
    /**
     * @var array $form_data The data that was typed into the form by the user and submitted
     * @access protected
     */
    protected $form_data = array();
    
    /**
     * The constructor for the dataToSmarty class
     *
     * @param 
     * @return $dataToSmarty
     */
    public function __construct() {
        //??
    }
    /**
     * Loads data into an array
     *
     * @access public
     * @param array $data The data in name => value pairs
     * @param string $data_type This is the type of data that $data will be assigned 
     *      to choices are is_error, error_msg, default_data, form_data
     * @return boolean
     */
    public function loadData(array $data=array(), $data_type='default_data') {
        switch ($data_type) {
            case 'default_data':
                $this->default_data = $data;
               break;
            case 'is_error':
                $this->is_error_array = $data;
                break;
            case 'error_msg':
                $this->error_msg_array = $data;
                break;
            case 'form_data':
                $this->form_data = $data;
                break;
            default:
                return false;
        }
        return true;
    }
    /**
     * Loads errors into the $is_error_array and the error_msg_array array
     *
     * @access public
     * @param array $errors The errors array in name => value pairs, where name is the name of the form element and value is the error message.
     * @param array $error_lexicon Add translations to error messages
     * @param string $return_type Removed optional The default is List or array.
     * 
     * @return Returns HTML list items <li> with error message  
     */
    public function loadErrors(array $errors, array $error_lexicon=array() ) {
        $this->error_list[0] = '';
        foreach ( $errors as $name => $message ) {
            // name is the form name
            //echo '<br>Error: '.$name.' - '.$message;
            $err_msg = $message;
            if ( isset($error_lexicon[$message]) ){
                $err_msg = $error_lexicon[$message];
            }
            
            $this->error_msg_array[$name] = $err_msg;
            $this->is_error_array[$name] = true;
            
            if ( !in_array($err_msg, $this->error_list) ) {
                array_push($this->error_list,$err_msg);
            }
        }
        $list = '';
        foreach ($this->error_list as $key=>$message) {
            //echo '<br>List: '.$key.' - '.$message;
            if ( $key == 0 ){
                continue;
            }
            $list .= '
            <li><sup>'.$key.'</sup>'.$message.'</li>';
        }
        return $list;
    }
    /**
     * Loads form data (post, get or request) into the $form_data array
     *
     * @access public
     * @param string $method Options are post, get, request or session
     */
    public function loadForm( $method='post') {
        $form_data = $_POST;
        switch ($method ) {
            case 'get':
                $form_data = $_GET;
                break;
            case 'request':
                $form_data = $_REQUEST;
                break;
            case 'session':
                $form_data = $_SESSION;
                break;
        }
        foreach ( $form_data as $name => $value ) {
            $this->form_data[$name] = $value;
        }
    }
    /**
     * Builds Smarty template data to use with $modx->smarty->assign()
     *
     * @access public
     * @param string $pre This is what the prefix for the smarty array
     * @params boolean $load_defaults This is to load the default values into the form data, 
     *      checkboxes will not work correctly if loaded and form submitted with different results.
     * @returns a smarty array that can be placed into $modx->smarty->assign()
     */
    public function buildSmarty($pre='_frm', $load_defaults=false) {
        $smarty_array = array();
        $data = $this->form_data;
        if ( $load_defaults ){
            $data = array_merge($this->default_data,$this->form_data);// form data takes president
            
        }
        foreach ( $data as $name => $value ){
            $smarty_array[$pre][$name] = array( 
                            'value' => $value,
                            'selected' => array( $value => 'selected="selected"'),
                            'radio' => array( $value => 'checked="checked"'),
                            'checked' => 'checked="checked"',
                            'errorMsg' => (isset($this->error_msg_array[$name]) ? $this->error_msg_array[$name] : '' ),
                            'isError' => (isset($this->is_error_array[$name]) ? true : false ),
                            'errorNumber' => (isset($this->is_error_array[$name]) ? array_search($this->error_msg_array[$name], $this->error_list) : '' )
                        );
        }
        //print_r($smarty_array);
        return $smarty_array;
    }
     /**
     * Format data of already loaded data 
     *
     * @access public
     * @param string $name The name of the key/name of a loaded data object
     * @param string $data_type This is the type of data that $name will be 
     *      formated in choices are default_data or form_data
     * @param string $format This is the type of format to preform, 
     *      currently only date is supported
     * @param string $format_option An option for formating the data, not
     *     currently supported 
     * @return boolean 
     */
    public function formatData($name, $data_type='default_data', $format='date', $format_option='MM/DD/YYYY') {
        switch ($data_type) {
            case 'default_data':
                $this->default_data[$name] = $this->formatDate($this->default_data[$name]);
                break;
            case 'form_data':
                $this->form_data[$name] = $this->formatDate($this->form_data[$name]);
                break;
            default:
                return false;
        }
        return true;
    }
    /**
     * Formats a date form the MySQL format to MM/DD/YYYY
     *
     * @access public
     * @param string $date This is the date that needs formated
     * @params string $format This is the format in which the date 
     *      should be displayed - not yet implemented
     * @returns string The formated date
     */
    public function formatDate($date, $format='MM/DD/YYYY') {
        list($y, $m, $d) = explode('-',$date);
        if ( strlen($d) > 2 ){// there is the time
            list($d) = explode(' ', $d);
        }
        return $m.'/'.$d.'/'.$y;
    }
    /**
     * Builds a working Lexicon for the smarty templates for MODX namespaced compenents
     *      Don't know if I did something wrong but I could not get my lexicon file to work nativly for 2.0
     * 
     * @access public
     * @param array my_lexicon This is the custom lexicon array/object information for a custom manager page/namespace
     * @returns a lexicon array that can then be assigned to smarty templates
     */
    public function smartyLexicon($my_lexicon) {
        $lexicon = array();
        // ['namespace']['topic'] = 'value'
        foreach( $my_lexicon as $name => $value ){
            @list($nsp, $tpc) = explode('.', $name,2);
            $lexicon[$nsp][$tpc] = $value;
        }
        return $lexicon;
    }
    
} // END
