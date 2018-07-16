<?php

/************************************************
 * This file is part of ColibriLabs package     *
 * @copyright (c) 2016-2018 Ivan Hontarenko     *
 * @email ihontarenko@gmail.com                 *
 ************************************************/

namespace Colibri\Logger\Handler;

use Colibri\Extension\ExtensionException;
use Colibri\Logger\Handler\Mask\LogLevelMask;

/**
 * Class StreamRotatedHandler
 * @package Colibri\Logger\Handler
 */
class StreamRotatedHandler extends StreamHandler
{
    
    const MAX_LOG_SIZE = 1 << 20; // 1MiB
    
    /**
     * StreamRotatedHandler constructor.
     *
     * @param     $source
     * @param int $level
     */
    public function __construct($source, $level = LogLevelMask::MASK_ALL)
    {
        $source = $this->rotateLogFile($source);
        
        parent::__construct($source, $level);
    }
    
    /**
     * @param $filename
     *
     * @return \SplFileObject
     * @throws ExtensionException
     */
    private function rotateLogFile($filename)
    {
        if (!file_exists($filename) && !touch($filename)) {
            throw new ExtensionException(
                sprintf('Handler (%s) accept only stringable filename. Resource will converter automatically', static::class));
        }
        
        $file = new \SplFileObject($filename);
        
        if ($file->getSize() > static::MAX_LOG_SIZE) {
            
            $iterator = new \GlobIterator(sprintf('%s/%s.*.gz',
                $file->getPath(), $file->getBasename()), \FilesystemIterator::SKIP_DOTS);
            
            $gzFilepath = sprintf('%s/%s.%d.gz',
                $file->getPath(), $file->getBasename(), $iterator->count());
            
            $gzip = gzopen($gzFilepath, 'w9');
            gzwrite($gzip, $file->fread($file->getSize()));
            gzclose($gzip);
            
            unlink($file->getPathname());
            touch($file->getPathname());
        }
        
        return $filename;
    }
    
}