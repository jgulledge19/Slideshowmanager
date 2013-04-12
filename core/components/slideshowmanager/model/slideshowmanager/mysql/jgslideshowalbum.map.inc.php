<?php
$xpdo_meta_map['jgSlideshowAlbum']= array (
  'package' => 'slideshowManager',
  'version' => '1.1',
  'table' => 'slideshow_album',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'title' => '',
    'description' => NULL,
    'image_instructions' => NULL,
    'advanced_instructions' => NULL,
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
    'image_instructions' => 
    array (
      'dbtype' => 'mediumtext',
      'phptype' => 'string',
      'null' => true,
    ),
    'advanced_instructions' => 
    array (
      'dbtype' => 'mediumtext',
      'phptype' => 'string',
      'null' => true,
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
      'precision' => '4',
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
  'indexes' => 
  array (
    'title' => 
    array (
      'alias' => 'title',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'title' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
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
