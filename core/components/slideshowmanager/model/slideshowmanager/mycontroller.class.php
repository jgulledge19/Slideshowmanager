<?php
/**
 * @description This is a generic controller for a CMP so you don't have to rename it each time 
 * you create an extra.  Note you don't need to change things here unless you want more config 
 * options or something
 */
class myController {
    /**
     * @param $modx
     * @param $config - array() of config options like array('corePath'=>'Path.../core/)
     */
    function __construct(modX &$modx,array $config = array()) {
    	$this->modx =& $modx;
        $package_name = ( isset($config['packageName']) ? $config['packageName'] : 'package');
        
        $corePath = $modx->getOption($package_name.'.core_path',null,$modx->getOption('core_path').'components/'.$package_name.'/');
        $assetsPath = $modx->getOption($package_name.'.assets_path',null,$modx->getOption('assets_path').'components/'.$package_name.'/');
        $assetsUrl = $modx->getOption($package_name.'.assets_url',null,$modx->getOption('assets_url').'components/'.$package_name.'/');

        $this->config = array_merge(array(
            'basePath' => $corePath,
            'corePath' => $corePath,
            'chunksPath' => $corePath.'elements/chunks/',
            'modelPath' => $corePath.'model/',
            'processorsPath' => $corePath.'processors/',
            'uploadPath' => $assetsPath.'uploads/',
            'templatesPath' => $corePath.'templates/',
            
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
            'imagesUrl' => $assetsUrl.'images/',
            'uploadUrl' => $assetsUrl.'uploads/',
        ),$config);
                
        $this->modx->addPackage($package_name,$this->config['modelPath']);
        if ($this->modx->lexicon) {
            $this->modx->lexicon->load($package_name.':default');
        }
    }

    /**
     * Initializes manager based on a specific context.
     *
     * @access public
     * @param string $ctx The context to initialize in.
     * @return string The processed content.
     */
    public function initialize($ctx = 'mgr') {
        $output = '';
        switch ($ctx) {
            case 'mgr':
                // mycontrollerrequest.class.php
                if (!$this->modx->loadClass($this->config['packageName'].'.request.mycontrollerrequest',$this->config['modelPath'],true,true)) {
                    return 'Could not load controller request handler. '.$this->config['modelPath'].
                    $this->config['packageName'].'.request.myControllerRequest';
                    // communitygroupscontrollerrequest.class.php
                    // myControllerRequest 
                }
                // need to make this configurable: 
                $this->request = new myControllerRequest($this);
                $output = $this->request->handleRequest();
                break;
        }
        return $output;
    }
    
    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name,$properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }

    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name) {
        $chunk = false;
        $f = $this->config['chunksPath'].strtolower($name).'.chunk.tpl';
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
}
