<?php

namespace Colibri\Schema;

use Colibri\Exception\NotSupportedException;
use Colibri\Schema\Platform\MySQLPlatform;

/**
 * Class Platform
 * @package Colibri\Schema
 */
abstract class Platform
{
    
    /**
     * @const array
     */
    const PLATFORMS = [
        'mysql' => MySQLPlatform::class,
    ];
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * Platform constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    /**
     * @param $platform
     *
     * @return mixed
     * @throws NotSupportedException
     */
    public static function factory($platform)
    {
        if (array_key_exists($platform, Platform::PLATFORMS)) {
            $class = Platform::PLATFORMS[$platform];
            
            return new $class;
        }
        
        throw new NotSupportedException('Platform :platform is not supported yet', [
            'platform' => $platform,
        ]);
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
}