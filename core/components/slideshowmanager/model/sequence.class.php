<?php
	#######################################
	#	This is a PHP Class for 5.2 and above using MySQL
	#	
	#	Author: Joshua Gulledge 
	#	Date: 1/8/08
	#	Purpose: This class orders a table/category
	#######################################
	
class Sequence{
    /**
     * @var modx
     */
    protected $modx;
    /**
     * @var string the primiary key column
     */
	protected $primiary=''; 
    /**
     * @var array xpdo conditions
     */
	protected $conditions=NULL;
    /**
     * @var string the name of the column(must be int) that has the sequence/rank
     */
	protected $sequence_column = 'sequence';
    /**
     * @var int
     */
	protected $new_sequence=NULL;
	/**
     * @var int
     */
	protected $current_sequence=NULL;
	/**
     * @var total number of units to sequence
     */
	protected $total=NULL;
	/**
     * @var array holding the temp ID array
     */ 
	protected $id_array = array();
    /**
     * @var int the current ID to be moved
     */ 
	protected $current_id=NULL;
    /**
     * @var string the class name of the table you wish to order
     */ 
	protected $table_class;
	/**
     * @access public
     * @param class modx
     * @param string $table_class: the class name of the table you wish to order
     * @param string $sequence_column: the name of the column(must be int) that has the sequence/rank
     * @param string $primiary: the primiary key column of the table class, default is id
     * 
     * returns Sequence object
     */
	public function __construct(&$modx, $table_class, $sequence_column='sequence', $primiary='id' ){
	    $this->modx = $modx;
		$this->table_class = $table_class;// object
		$this->sequence_column = $sequence_column;
		$this->primiary = $primiary;
	}
	/**
     * @array $conditions an array of conditions like array('category_id' => 10 )
     * 
     * return void
     */
    public function addConditions( array $conditions) {
        $this->conditions = $conditions;
    }
    
    /**
     * @description $this->modx query and switch 2 values
     * 
     * @int $id the id of the row the will be moving up(from 2 to 1)/down(from 1 to 2)
     * @string $direction this can be up or down
     * 
     * @return bool, true on success and false on falure
     */
	public function moveItem($id, $direction='up' ) {
		// This method will switch 2 id's in the sequence 
		$this->current_id = $id;
		// 1. Always reset the order-Select the articles for that day
		$this->_reorder();
		
		// 2. Now change the order - only if there is more then 1 and it is inside the peramitors
		// echo 'Nrows: '.$nrows.'<br />Current: '.$currentSequence.'<br />Command: '.$dir;
		if( $this->current_sequence ){ 
			// get the ID of the one below or above
			$update = true;
            $switch = true;
			if ( $direction == 'up' ) {
				if ( $this->current_sequence > 1) {
					$this->new_sequence = $this->current_sequence - 1;
				} elseif ( $this->current_sequence == 1) {
					$this->new_sequence = $this->total+1;// move to end
					$switch = false;
				}
			// down in the sequence number
			} elseif ( $direction == 'down') {
				if ( $this->current_sequence < $this->total) {
					$this->new_sequence = $this->current_sequence + 1;
				} elseif ( $this->current_sequence == $this->total) {
					$this->new_sequence = 0;// move to first
					$switch = false;
				}
			} else {
				$update = false;	
			}
			if ( $update ) { 
				// the orginal update the sequence
				$current = $this->modx->getObject($this->table_class, $this->current_id);
				$current->set($this->sequence_column, $this->new_sequence);
                if (!$current->save() ){
                    // did not save
                    echo 'Error '.__LINE__;
                    return false;
                }
				//echo mysql_error();
				if ( !$switch ) {
					//now reorder
					$this->_reorder();
				} else {
					// the one that is switching update the sequence
                    $other = $this->modx->getObject($this->table_class, $this->id_array[$this->new_sequence]);
                    if ( is_object($other) ) {
                        $other->set($this->sequence_column, $this->current_sequence);
                        if (!$other->save() ){
                            // did not save
                            echo 'Error '.__LINE__;
                            return false;
                        }
                    }
				}
			}
		}
		return true;
	}
    /**
     * @param
     * 
     * @return boolean
     */
    public function order($id, $sequence ) {
        $this->current_id = $id; 
        $this->_reorder();
        // get new sequence of the current id
        $tmp_seq = array_search($this->current_id,$this->id_array);
        if ( $tmp_seq === false ) {
            return true;
        }
        // adjust if it is +1
        if ( $tmp_seq > $sequence ) { 
            return $this->moveItem($this->current_id, 'up');
        } elseif ( $tmp_seq < $sequence ) {
            return $this->moveItem($this->current_id, 'down');
        }
    }
    /**
     * 
     * @return bool, true on success and false on falure
     */
	private function _reorder(){
        // Now list all stories for this category
        $query = $this->modx->newQuery($this->table_class);
        if ( is_array($this->conditions) ) {
            $query->where($this->conditions);
        }
        $query->sortby($this->sequence_column, 'ASC');
        //$c->limit(5);
        $collection = $this->modx->getCollection($this->table_class,$query);
        //$this->modx->setLogTarget($oldTarget);
        
		$x=0;
        //echo 'SQL:<br>'.$query->toSQL();
        foreach ( $collection as $row ) {
			$tmp_seq = ++$x;
			//echo '<br />Error 2: '.mysql_error();
			$this->id_array[$tmp_seq] = $row->get($this->primiary);// the temp id
			
			if ( $this->id_array[$tmp_seq] == $this->current_id) {
				$this->current_sequence = $tmp_seq;
			}
			// Now update the sequence
			$row->set($this->sequence_column, $tmp_seq);
            
            if (!$row->save() ) {
				return false;
			}
		}
		return true;
	}
	/**
	 * @description This method takes the input of every item then orders by the input, format: "name_id"
     * 
     * @int $id the id of the item that will have its sequence updated
     * @int $sequence the sequence number that you wish to have for this item
     * 
     * @return string
	 */
	public function inputSequence( $id, $sequence=1 ) {
		$current = $this->modx->getObject($this->table_class, $id);
        $current->set($this->sequence_column, $sequence);
        if (!$current->save() ){
            // did not save
            return false;
        }
		// 2. Always reset the order-Select
		return $this->order($id, $sequence);
	}
	/**
	* @description get the next sequence number available
     * 
     * @return int the next sequence number
	*/
	public function nextSequence(){
		// Now list all stories for this category
        $query = $this->modx->newQuery($this->table_class);
        if ( is_array($this->conditions) ) {
            $query->where($this->conditions);
        }
        $query->sortby($this->sequence_column,'ASC');
        //$c->limit(5);
        $count = $this->modx->getCount($this->table_class,$query);
        //$this->modx->setLogTarget($oldTarget);
        
        return $count + 1;
	}
}


?>