<?php
$xpdo_meta_map['jgSlideshowSlide']= array (
  'package' => 'slideshowmanager',
  'version' => NULL,
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
    'slide_status' => 'tbd',
    'version' => 1,
    'options' => '',
    'url' => '',
    'title' => '',
    'description' => '',
    'notes' => '',
    'html' => '',
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
      'index' => 'index',
    ),
    'end_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
      'index' => 'index',
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
      'index' => 'index',
    ),
    'slide_status' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'live\',\'replace\',\'future\',\'archive\',\'deleted\',\'tbd\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'tbd',
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
      'default' => '',
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
      'index' => 'index',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'notes' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'html' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
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
