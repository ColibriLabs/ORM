<?php

return [
  /// ...
  'colibri_orm' => [

    'identity' => __FILE__,
    'dev_configuration' => 'config.dev.php',
    'configuration_glob_pattern' => 'glob://%s/colibri_orm/*.(php|yml|ini|json)',

    'connection_name' => 'production',
    'connection' => [
      'production' => [
        'dsn' => 'mysql:host=localhost;dbname=procart',
        'user' => 'root',
        'password' => 'dezdev7java',
      ],
    ],

    'schema_file' => 'schema.xml',
    'build' => [
      'build_path' => './../generated-classes',
      'autoload_file' => 'autoload.php',
      'metadata_file' => 'metadata.php',
    ],

  ],
];