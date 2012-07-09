<?php
$xpdo_meta_map['MessageGroup']= array (
  'package' => 'message',
  'version' => '1.1',
  'table' => 'message_group',
  'composites' => 
  array (
    'Sermons' => 
    array (
      'class' => 'MessageSermons',
      'local' => 'id',
      'foreign' => 'group_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'fields' => 
  array (
    'create_date' => NULL,
    'name' => NULL,
    'description' => NULL,
    'default_group' => 'No',
  ),
  'fieldMeta' => 
  array (
    'create_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
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
    'default_group' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'Yes\',\'No\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'No',
    ),
  ),
);
