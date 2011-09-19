<?php
	####################
	#	Date: 12/11/08
	#	Author: Joshua Gulledge
	#	Purpose: this is make a directory tree like windows explorer
	####################
	
	
class dir_tree{
	protected $base_dir = NULL;
	protected $public_path = NULL;
	protected $debug = false;
	protected $id = NULL;
	protected $folder_id_list = array();
	protected $html_files = 0;
	protected $php_files = 0;
	protected $pdf_files = 0;
	protected $img_files = 0;
	
	public function __construct($base_dir, $public_path, $id='tree_list'){
		$this->base_dir = $base_dir;
		$this->public_path = $public_path;
		$this->id = $id;
	}
	public function set_base_dir($base_dir){
		$this->base_dir = $base_dir;
	}
	public function base_dir(){
		return $this->base_dir;
	}
	public function public_path(){
		return $this->public_path;
	}
	public function debug($set=true){
		$this->debug = $set;
	}
	# Get folders/directories
	# Get files in diectory - file types to show?
	public function get_folder() {
		$text .= '
		<div id="'.$this->id.'">
			<a href="'.$this->public_path.'" class="top_folder">'.$this->public_path.'</a>
			'.$this->directory_files($this->base_dir).'
		</div>
		<p>'.$this->file_totals().'</p>';
		return $text;
	}
	private function directory_files($current_dir, $folder_id=NULL){
		$current_dir;// this is the base 
		// Array that will hold the dir/folders names.
		$dir_array = array();
		//$dir_info_array = array();
		$file_array = array();
		$file_info_array = array();
		
		$open_dir = opendir( $current_dir ) ;
		// count files:
		$this->count_files($current_dir);
		
		while ( $tmp_file = readdir( $open_dir ) ) {
			if ( $tmp_file != '.' && $tmp_file != '..' ) {
				# dir
				if( $this->debug ){
					echo '<br>'.$tmp_file;
				}
				if ( is_dir( $current_dir.$tmp_file ) ) {
					// what about doing some recurion here?
					$dir_array[] = $tmp_file;
					// count files
					//$this->count_files($current_dir.$tmp_file);
				}
				# files
				elseif( is_file($current_dir.$tmp_file) ) {
					$file_size = @filesize( $current_dir.$tmp_file ) ;
					if ( !$file_size ) {
						$file_size = 0 ;
					}
					if ( $file_size < 1024*1024) {
						$file_size = round( $file_size / 1024 ).'kb';
						if ( $file_size < 1 ) {
							$file_size = '1kb';
						}
					}
					else{
						$file_size = round( $file_size/(1024*1024) ).'mb';
					}
					$file_array[] = $tmp_file;
					$file_info_array[$tmp_file] = array(
							'type' => '', // jpg, html, php, ect.
							'size' => $file_size,
							'date' => date("M/j/Y g:ia",filemtime($current_dir.$tmp_file)) );
				}
			}
		}
		closedir($open_dir);
		# Create the folder ordered list
		$folder_text = '
		<ul id="'.$folder_id.'">';
		# now sort the folders with human sorting
		natcasesort( $dir_array ) ;
		foreach ( $dir_array as $folder ) {
			$folder_id = str_replace(' ','',$folder).rand(0,5000);
			$this->folder_id_list[] = $folder_id;
			$folder_text .= 
			'<li class="folder">
				<a href="javascript:vis('."'visible', '".$folder_id."', 'auto', 'inline'".');" 
			id="s_'.$folder_id.'" title="Expand Folder" ><img src="/events/images/plus.gif" alt="+" border="0" /></a>
			<a href="javascript:vis('."'hidden', '".$folder_id."', '0', 'none'".')" id="h_'.$folder_id.'" title="Hide Folder" ><img src="/events/images/minus.gif" alt="-" border="0" /></a>
				<span>'.$folder.$this->directory_files($current_dir.$folder.'/', $folder_id).'</span>
			</li>';
		}
		
		# get the base URL for these files
		$base_url = $this->public_path.str_replace($this->base_dir,'',$current_dir);
		if( $this->debug ){
			echo '
			<br>Base URL: '.$base_url.' -> Public: '.$this->public_path;
		}
		# Sort the files
		natcasesort( $file_array ) ;
		foreach ( $file_array as $tmp_file ) {
			# what about default, index pages?
			$folder_text .= 
			'<li class="file">
				<span><a href="'.$base_url.$tmp_file.'">'.$tmp_file.'</a> <span class="note">'.$file_info_array[$tmp_file]['size'].
				' - '.$file_info_array[$tmp_file]['date'].'</span></span>
			</li>';
		}
		$folder_text .= '
		</ul>';
		// Close the "Folders" node.
		return $folder_text;
	}
	
	public function count_files($dir) {
		//echo '<br />DIR: '.$dir;
		$this->html_files += count(glob($dir . "/*.html")) + count(glob($dir . "/*.htm"));
		$this->php_files += count(glob($dir. "/*.php"));
		$this->pdf_files += count(glob($dir. "/*.pdf"));
		$this->img_files += count(glob($dir. "/*.jpg")) + count(glob($dir. "/*.gif"));
	}
	public function file_totals() {
		return 'PHP files: '.$this->php_files.', Html files: '.$this->html_files.
			', PDF files: '. $this->pdf_files.' Image files: '.$this->img_files;
	}
	
	# Make the CSS
	public function css($preceed_selector=''){
		$css = '
	'.$preceed_selector.'div#'.$this->id.'{
		padding-left: 20px;
	}
	'.$preceed_selector.'div#'.$this->id.' a.top_folder{
		background: url(/admission/test/folder.jpg) no-repeat 0 3px;
		margin-left:-20px;
		padding-left: 40px;
	}
	'.$preceed_selector.'div#'.$this->id.' ul{
		border-left: 1px #a2a2a2 dashed;
		padding:0;
		margin:0 0 10px 0;
	}	
	'.$preceed_selector.'div#'.$this->id.' li{
		list-style:none;
		border-left: 1px #a2a2a2 dashed;
		margin:0;
		padding: 3px 0 3px 20px;
		line-height: 16px;
		font-size: 12px;
	}
	'.$preceed_selector.'div#'.$this->id.' li span{
		padding-left: 20px;
	}
	'.$preceed_selector.'div#'.$this->id.' li.folder span{
		padding-left: 0;
	}
	'.$preceed_selector.'div#'.$this->id.' li.folder a{
		padding-left: 15px;
	}
	'.$preceed_selector.'div#'.$this->id.' li.folder{
		background: url(/admission/test/folder.jpg) no-repeat 0 3px;
	
	}
	'.$preceed_selector.'div#'.$this->id.' li.file{
		background: url(/admission/test/web_file.jpg) no-repeat 0 3px;
	
	}
	'.$preceed_selector.'div#'.$this->id.' li span.note{
		font-size: 10px;
		margin-left; 10px;
	}
	';
		$id_list = NULL;
		$hide_list = NULL;
		foreach( $this->folder_id_list as $folder_id){
			$id_list .= '#'.$folder_id.', ';
			$hide_list .= '#h_'.$folder_id.', ';
		}
		$css .= substr($id_list,0,-2);
		$css .= '{
		visibility:hidden;
		/*height:0;*/
		display:none;
	}';
		$css .= substr($hide_list,0,-2);
		$css .= '{
		visibility:hidden;
		display:none;
	}';
		return $css;
	}
	# Make the JavaScript
	public function javascript(){
	
		$javascript = "
<script language=\"JavaScript\" type=\"text/JavaScript\">
	DHTML = (document.getElementById || document.all || document.layers)
	
	function vis(val, layername, height, display) {
		if (!DHTML) return;
		/* the description */
		var f = new getObj(layername);
		f.style.visibility = val;
		//f.style.height=height;
		f.style.display=display;
		/* now the links */
		/* this is show */
		var showVis='hidden';
		var hideVis='visible';
		var showDisplay = 'none';
		var hideDisplay = 'inline';
		if(val == 'hidden') {
			/* this is hide */
			var showVis='visible';
			var hideVis='hidden';
			var hideDisplay = 'none';
			var showDisplay = 'inline';
		}
		var show = 's_'+layername;
		var s = new getObj(show);
		s.style.visibility = showVis;
		s.style.display=showDisplay;
		
		var hide = 'h_'+layername;
		var h = new getObj(hide);
		h.style.visibility = hideVis;
		h.style.display=hideDisplay;
	}
	function getObj(name)
	{
	  if (document.getElementById)
	  {
		this.obj = document.getElementById(name);
		this.style = document.getElementById(name).style;
	  }
	  else if (document.all)
	  {
		this.obj = document.all[name];
		this.style = document.all[name].style;
	  }
	  else if (document.layers)
	  {
		this.obj = document.layers[name];
		this.style = document.layers[name];
	  }
	}
</script>";
		
		return $javascript;
	}
	
}

########################
#	End Class
########################



?>
