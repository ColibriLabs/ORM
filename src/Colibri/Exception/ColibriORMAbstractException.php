<?php

namespace Colibri\Exception;

/**
 * Class ColibriORMAbstractException
 * @package Colibri\Exception
 */
abstract class ColibriORMAbstractException extends \Exception
{
    
    /**
     * DbException constructor.
     *
     * @param string     $message
     * @param array      $placeholders
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message, array $placeholders = [], $code = 0, \Exception $previous = null)
    {
        parent::__construct($this->format($message, $placeholders), $code, $previous);
    }
    
    /**
     * @param       $message
     * @param array $placeholders
     *
     * @return string
     */
    protected function format($message, array $placeholders = [])
    {
        foreach ($placeholders as $name => $value) {
            $placeholders[":$name"] = $value;
            unset($placeholders[$name]);
        }
        
        return strtr($message, $placeholders);
    }
    
}