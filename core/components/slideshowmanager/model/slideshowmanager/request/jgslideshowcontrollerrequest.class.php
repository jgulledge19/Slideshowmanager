<?php
/**
 * Slideshow Manager
 * 
 * @package slideshowmanager
 */
require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php';
/**
 * Encapsulates the interaction of MODx manager with an HTTP request.
 *
 * {@inheritdoc}
 *
 * @package slideshowmanager
 * @extends modRequest
 */
class jgslideshowControllerRequest extends modRequest {
    public $jgSlideshow = null;
    public $actionVar = 'action';
    public $defaultAction = 'home';

    function __construct(jgSlideshow &$jgSlideshow) {
        parent :: __construct($jgSlideshow->modx);
        $this->jgSlideshow =& $jgSlideshow;
    }

    /**
     * Extends modRequest::handleRequest and loads the proper error handler and
     * actionVar value.
     *
     * {@inheritdoc}
     */
    public function handleRequest() {
        $this->loadErrorHandler();

        /* save page to manager object. allow custom actionVar choice for extending classes. */
        $this->action = isset($_REQUEST[$this->actionVar]) ? $_REQUEST[$this->actionVar] : $this->defaultAction;

        return $this->_respond();
    }

    /**
     * Prepares the MODx response to a mgr request that is being handled.
     *
     * @access public
     * @return boolean True if the response is properly prepared.
     */
    private function _respond() {
        $modx =& $this->modx;
        $jgSlideshow =& $this->jgSlideshow;
        $viewHeader = '';//include $this->jgSlideshow->config['corePath'].'controllers/mgr/header.php';
        $viewOutput = '';
        // load the DB package that is used for this component
        
        // This will add the package to xPDO, and allow you to use all of xPDO's functions with your model. 
        $modx->addPackage('slideshowmanager', $this->jgSlideshow->config['modelPath']);
        
        // include some custom classes to help handle the forms
        require_once $this->jgSlideshow->config['modelPath'].'datatosmarty.class.php';
        require_once $this->jgSlideshow->config['modelPath'].'formvalidate.class.php';
        
        // get the a - modxAction id
        if ( !isset($a) ) {
            if ( isset($_REQUEST['a']) ) {
                $a = $_REQUEST['a'];
            }
        }
        // if form has been submitted then process it
        if ( isset($_POST) ) {
            $folder = isset($_REQUEST['pfolder']) ? str_replace(array('/','\\','..'),'',$_REQUEST['pfolder']) : '';
            $f = $this->jgSlideshow->config['corePath'].'processors/mgr/'.$folder.'/'.$this->action.'.php';
            if (file_exists($f)) {
                //$viewHeader .= 'Process me';
                $viewOutput .= include $f;
                if ( !empty($viewOutput)){
                    $viewOutput = '<div id="jgMessage">'.$viewOutput.'</div>';
                }
            }
        } 
        
        
        // call on a template page
        $f = $this->jgSlideshow->config['corePath'].'controllers/mgr/'.$this->action.'.php';
        if (file_exists($f)) {
            $viewOutput .= include $f;
        } else {
            $viewOutput .= 'Action not found: '.$f;
        }

        return $viewHeader.$viewOutput;
    }
}