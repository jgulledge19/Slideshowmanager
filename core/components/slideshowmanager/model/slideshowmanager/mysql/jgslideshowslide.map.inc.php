<?php
$xpdo_meta_map['jgSlideshowSlide']= array (
  'package' => 'slideshowManager',
  'version' => '1.1',
  'table' => 'slideshow_slide',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'slideshow_album_id' => 0,
    'web_user_id' => 0,
    'start_date' => NULL,
    'end_date' => NULL,
    'edit_time' => NULL,
    'sequence' => 0,
    'slide_status' => 'TBD',
    'version' => 1,
    'options' => NULL,
    'url' => '',
    'title' => '',
    'description' => NULL,
    'notes' => NULL,
    'html' => NULL,
    'upload_time' => NULL,
    'file_path' => '',
    'file_size' => 0,
    'file_type' => '',
  ),
  'fieldMeta' => 
  array (
    'slideshow_album_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'web_user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '8',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'start_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'end_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'edit_time' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'sequence' => 
    array (
      'dbtype' => 'int',
      'precision' => '8',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'slide_status' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'live\',\'archive\',\'deleted\',\'restore_point\',\'TBD\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'TBD',
    ),
    'version' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '3',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
    ),
    'options' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'url' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
    ),
    'notes' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'html' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'upload_time' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'file_path' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'file_size' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'file_type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
  'indexes' => 
  array (
    'slideshow_album_id' => 
    array (
      'alias' => 'slideshow_album_id',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'slideshow_album_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'Search' => 
    array (
      'alias' => 'Search',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'slideshow_album_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'start_date' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'end_date' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'slide_status' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Album' => 
    array (
      'class' => 'jgSlideshowAlbum',
      'local' => 'slideshow_album_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
