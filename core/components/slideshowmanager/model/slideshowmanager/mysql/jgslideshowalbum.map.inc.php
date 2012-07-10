<?php
$xpdo_meta_map['jgSlideshowAlbum']= array (
  'package' => 'slideshowmanager',
  'version' => NULL,
  'table' => 'slideshow_album',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'title' => '',
    'description' => NULL,
    'file_allowed' => '',
    'file_size_limit' => 0,
    'constrain' => 1,
    'file_width' => 0,
    'file_height' => 0,
    'icon_path' => NULL,
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'description' => 
    array (
      'dbtype' => 'mediumtext',
      'phptype' => 'string',
      'null' => false,
    ),
    'file_allowed' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'file_size_limit' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'constrain' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '3',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
    ),
    'file_width' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'file_height' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'icon_path' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
  ),
  'composites' => 
  array (
    'Slide' => 
    array (
      'class' => 'jgSlideshowSlide',
      'local' => 'id',
      'foreign' => 'slideshow_slide_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
