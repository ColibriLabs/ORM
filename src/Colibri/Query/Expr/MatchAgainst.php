<?php

namespace Colibri\Query\Expr;

use Colibri\Collection\Collection;
use Colibri\Exception\RuntimeException;
use Colibri\Query\Expression;

/**
 * Class MatchAgainst
 * @package Colibri\Query\Expr
 */
class MatchAgainst extends Expression
{
    
    const NULL_MODE                   = null;
    const BOOLEAN_MODE                = 'IN BOOLEAN MODE';
    const NATURAL_MODE                = 'IN NATURAL LANGUAGE MODE';
    const NATURAL_MODE_WITH_EXPANSION = 'IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION';
    const WITH_QUERY                  = 'WITH QUERY EXPANSION';
    
    const AGAINST_NONE             = 1;
    const AGAINST_INCLUDE          = 2;
    const AGAINST_EXCLUDE          = 4;
    const AGAINST_TRUNCATION_LEFT  = 8;
    const AGAINST_TRUNCATION_RIGHT = 16;
    const AGAINST_TRUNCATION_BOTH  = 32;
    const AGAINST_NEGATION         = 64;
    
    const AGAINST_TEMPLATES = [
        self::AGAINST_NONE             => '%s',
        self::AGAINST_INCLUDE          => '+%s',
        self::AGAINST_EXCLUDE          => '-%s',
        self::AGAINST_TRUNCATION_LEFT  => '*%s',
        self::AGAINST_TRUNCATION_RIGHT => '%s*',
        self::AGAINST_TRUNCATION_BOTH  => '*%s*',
        self::AGAINST_NEGATION         => '~%s',
    ];
    
    /**
     * @var null|string
     */
    protected $searchModifier = self::NULL_MODE;
    
    /**
     * @var Collection
     */
    protected $matchColumns;
    
    /**
     * @var Collection
     */
    protected $againstWords;
    
    /**
     * @inheritDoc
     */
    public function __construct(array $columns = [], array $against = [])
    {
        $this->matchColumns = new Collection([], Expression::class);
        $this->againstWords = new Collection();
    }
    
    /**
     * @param string $phrases
     *
     * @return $this
     */
    public function addPhrases($phrases)
    {
        return $this->addAgainst($phrases, static::AGAINST_NONE);
    }
    
    /**
     * @param null $phrase
     * @param int  $againstMode
     *
     * @return $this
     */
    public function addAgainst($phrase = null, $againstMode = self::AGAINST_NONE)
    {
        $pattern = '/\s+/ui';
        
        if (preg_match($pattern, $phrase)) {
            foreach (preg_split($pattern, $phrase) as $value) {
                $this->addAgainst($value, $againstMode);
            }
        } else {
            $this->againstWords->offsetSet($phrase, $againstMode);
        }
        
        return $this;
    }
    
    /**
     * @param string $phrases
     *
     * @return $this
     */
    public function addInclusionPhrases($phrases)
    {
        return $this->addAgainst($phrases, static::AGAINST_INCLUDE);
    }
    
    /**
     * @param string $phrases
     *
     * @return $this
     */
    public function addExclusionPhrases($phrases)
    {
        return $this->addAgainst($phrases, static::AGAINST_EXCLUDE);
    }
    
    /**
     * @param string $phrases
     *
     * @return $this
     */
    public function addRightTruncationPhrases($phrases)
    {
        return $this->addAgainst($phrases, static::AGAINST_TRUNCATION_RIGHT);
    }
    
    /**
     * @param string $phrases
     *
     * @return $this
     */
    public function addLeftTruncationPhrases($phrases)
    {
        return $this->addAgainst($phrases, static::AGAINST_TRUNCATION_LEFT);
    }
    
    /**
     * @param string $phrases
     *
     * @return $this
     */
    public function addBothTruncationPhrases($phrases)
    {
        return $this->addAgainst($phrases, static::AGAINST_TRUNCATION_BOTH);
    }
    
    /**
     * @param string $phrases
     *
     * @return $this
     */
    public function addNegationPhrases($phrases)
    {
        return $this->addAgainst($phrases, static::AGAINST_NEGATION);
    }
    
    /**
     * @return $this
     */
    public function clearAgainst()
    {
        $this->againstWords->clear();
        
        return $this;
    }
    
    /**
     * @param array $columns
     *
     * @return $this
     */
    public function addMatchColumns(array $columns = [])
    {
        foreach ($columns as $column) {
            $this->addMatchColumn($column);
        }
        
        return $this;
    }
    
    /**
     * @param Column|string $column
     *
     * @return $this
     */
    public function addMatchColumn($column)
    {
        $this->matchColumns->push($column instanceof Expression ? $column : new Column($column));
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function clearMatchColumns()
    {
        $this->matchColumns->clear();
        
        return $this;
    }
    
    /**
     * @return Collection
     */
    public function getAgainstWords()
    {
        return $this->againstWords;
    }
    
    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->toSQL();
    }
    
    /**
     * @inheritDoc
     */
    public function toSQL()
    {
        $builder = $this->getBuilder();
        $template = 'MATCH (%s) AGAINST ("%s"%s)';
        
        $against = new Collection();
        
        $this->againstWords->each(function ($value, $againstKey) use ($against) {
            $against->push(sprintf(static::AGAINST_TEMPLATES[$againstKey], $value));
        });
        
        $searchModifier = $this->getSearchModifier();
        $searchModifier = (null === $searchModifier ? null : sprintf(' %s', $searchModifier));
        
        $parameters = new Parameters($this->getMatchColumns()->toArray());
        $parameters->setBuilder($builder);
        $builder->normalizeExpression($parameters);
        
        $against = implode(' ', $against->toArray());
        
        return sprintf($template, $parameters, $against, $searchModifier);
    }
    
    /**
     * @return null|string
     */
    public function getSearchModifier()
    {
        return $this->searchModifier;
    }
    
    /**
     * @param string|null $searchModifier
     *
     * @return $this
     * @throws RuntimeException
     */
    public function setSearchModifier($searchModifier)
    {
        $modifiers = [
            self::NULL_MODE,
            self::BOOLEAN_MODE,
            self::NATURAL_MODE,
            self::NATURAL_MODE_WITH_EXPANSION,
            self::WITH_QUERY,
        ];
        
        if (false === in_array($searchModifier, $modifiers)) {
            throw new RuntimeException(sprintf('Not allowed search modifier (%s) for MATCH-AGAINST expression',
                $searchModifier));
        }
        
        $this->searchModifier = $searchModifier;
        
        return $this;
    }
    
    /**
     * @return Collection
     */
    public function getMatchColumns()
    {
        return $this->matchColumns;
    }
    
    /**
     * @inheritDoc
     */
    function __debugInfo()
    {
        return [
            'againstWords' => $this->againstWords->toArray(),
            'matchColumns' => $this->matchColumns->toArray(),
            'parent'       => parent::__debugInfo(),
        ];
    }
    
}
