<?php
$xpdo_meta_map['MessageSermons']= array (
  'package' => 'message',
  'version' => '1.1',
  'table' => 'message_sermons',
  'aggregates' => 
  array (
    'Group' => 
    array (
      'class' => 'MessageGroup',
      'local' => 'group_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'composites' => 
  array (
    'Media' => 
    array (
      'class' => 'MessageMedia',
      'local' => 'id',
      'foreign' => 'sermon_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'fields' => 
  array (
    'group_id' => NULL,
    'create_date' => NULL,
    'sermon_date' => NULL,
    'title' => NULL,
    'speaker' => NULL,
    'description' => NULL,
    'tags' => NULL,
    'active' => 'Yes',
  ),
  'fieldMeta' => 
  array (
    'group_id' => 
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
    'sermon_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'speaker' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'tags' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
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
  ),
);
