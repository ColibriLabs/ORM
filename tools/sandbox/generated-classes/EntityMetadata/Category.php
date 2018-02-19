<?php

return array (
  'entityClass' => 'ProCard\\Models\\Category',
  'entityRepositoryClass' => 'ProCard\\Models\\CategoryRepository',
  'tableName' => 'categories',
  'identifier' => 'id',
  'rawSQLNames' => 
  array (
    'id' => 'categories.id',
    'parent_id' => 'categories.parent_id',
    'left_key' => 'categories.left_key',
    'right_key' => 'categories.right_key',
    'depth' => 'categories.depth',
    'name' => 'categories.name',
    'label' => 'categories.label',
    'description' => 'categories.short_description',
    'created' => 'categories.created',
    'modified' => 'categories.modified',
  ),
  'names' => 
  array (
    'id' => 'id',
    'parent_id' => 'parent_id',
    'left_key' => 'left_key',
    'right_key' => 'right_key',
    'depth' => 'depth',
    'name' => 'name',
    'label' => 'label',
    'description' => 'short_description',
    'created' => 'created',
    'modified' => 'modified',
  ),
  'relations' => 
  array (
  ),
  'enumerations' => 
  array (
  ),
  'default' => 
  array (
  ),
  'nullables' => 
  array (
  ),
  'unsigned' => 
  array (
    'id' => 'id',
    'parent_id' => 'parent_id',
    'left_key' => 'left_key',
    'right_key' => 'right_key',
    'depth' => 'depth',
  ),
  'primary' => 
  array (
    'id' => 'id',
  ),
  'instances' => 
  array (
    'id' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'id',
       'name' => 'id',
       'type' => 
      Colibri\Schema\Types\IntegerType::__set_state(array(
         'length' => 11,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => true,
       'nullable' => false,
       'autoIncrement' => true,
       'primaryKey' => true,
       'identity' => false,
    )),
    'parent_id' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'parent_id',
       'name' => 'parent_id',
       'type' => 
      Colibri\Schema\Types\IntegerType::__set_state(array(
         'length' => 11,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => true,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'left_key' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'left_key',
       'name' => 'left_key',
       'type' => 
      Colibri\Schema\Types\IntegerType::__set_state(array(
         'length' => 11,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => true,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'right_key' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'right_key',
       'name' => 'right_key',
       'type' => 
      Colibri\Schema\Types\IntegerType::__set_state(array(
         'length' => 11,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => true,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'depth' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'depth',
       'name' => 'depth',
       'type' => 
      Colibri\Schema\Types\IntegerType::__set_state(array(
         'length' => 11,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => true,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'name' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'name',
       'name' => 'name',
       'type' => 
      Colibri\Schema\Types\StringType::__set_state(array(
         'length' => 32,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => false,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'label' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'label',
       'name' => 'label',
       'type' => 
      Colibri\Schema\Types\StringType::__set_state(array(
         'length' => 32,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => false,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'description' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'short_description',
       'name' => 'description',
       'type' => 
      Colibri\Schema\Types\StringType::__set_state(array(
         'length' => 64,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => false,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'created' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'created',
       'name' => 'created',
       'type' => 
      Colibri\Schema\Types\DatetimeType::__set_state(array(
         'length' => 0,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => false,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
    'modified' => 
    Colibri\Schema\Field::__set_state(array(
       'column' => 'modified',
       'name' => 'modified',
       'type' => 
      Colibri\Schema\Types\DatetimeType::__set_state(array(
         'length' => 0,
         'precision' => 0,
         'extra' => NULL,
      )),
       'default' => NULL,
       'unsigned' => false,
       'nullable' => false,
       'autoIncrement' => false,
       'primaryKey' => false,
       'identity' => false,
    )),
  ),
);