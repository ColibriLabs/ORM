<?php

// \stdClass means entity class which should been observable

return
    [
        'extensions' => [
            
            'sluggable'      => [
                \stdClass::class => [
                    'slug' => [
                        'properties' => ['name',],
                        'prefix'     => null,
                        'suffix'     => null,
                        'separator'  => '-',
                    ],
                ],
            ],
            'timestampable'  => [
                \stdClass::class => [
                    'created'  => [
                        'on' => [
                            'create',
                        ],
                    ],
                    'modified' => [
                        'on' => [
                            'update',
                            'create',
                        ],
                    ],
                ],
            ],
            'versionable'    => [
                \stdClass::class => [
                    'properties' => [
                        'version',
                    ],
                ],
            ],
            'dataFilter'     => [
                \stdClass::class => [
                    'name' => [
                        'filters' => [
                            \Colibri\Filters\ClearHtmlFilter::class => [[],], // clear all
                        ],
                    ],
                ],
            ],
            'resourceLogger' => [
                // not implemented yet...
            ],
        ],
    ];