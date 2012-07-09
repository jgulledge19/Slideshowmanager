<?php
$xpdo_meta_map['MessageMedia']= array (
  'package' => 'message',
  'version' => '1.1',
  'table' => 'message_media',
  'aggregates' => 
  array (
    'Sermon' => 
    array (
      'class' => 'MessageSermons',
      'local' => 'sermon_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'fields' => 
  array (
    'sermon_id' => NULL,
    'create_date' => NULL,
    'type' => NULL,
    'name' => NULL,
    'description' => NULL,
    'active' => 'Yes',
    'allow_download' => 'Yes',
    'file' => NULL,
    'file_ext' => NULL,
    'resource_id' => NULL,
    'url' => NULL,
  ),
  'fieldMeta' => 
  array (
    'sermon_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
    'create_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => false,
    ),
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'active' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Yes\',\'No\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Yes',
    ),
    'allow_download' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Yes\',\'No\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Yes',
    ),
    'file' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'file_ext' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '8',
      'phptype' => 'string',
      'null' => false,
    ),
    'resource_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'url' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
);
