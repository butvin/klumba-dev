<?php

namespace Kl;

trait DataConversion
{
    /**
     * RegEx patterns.
     *
     * @var string
     */
    public string $pattern = '/[^a-z0-9]+/i';
    public string $pattern2underscore = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';

    /**
     * Gets objects properties and create associative array
     * on its base.
     *
     * @param  object  $obj
     * @param  null  $conversionRule
     * @return array
     */
    public function toArray(object $obj, $conversionRule = null) :array
    {
        $result = [];

        $classProperties = get_object_vars($obj);

        if ($conversionRule === 'camelCase') {
            foreach ($classProperties as $prop => $value) {
                $newField = trim(preg_replace($this->pattern, ' ', $prop));
                $newField = ucwords($newField);
                $newField = str_replace(' ', '', $newField);
                $newField = lcfirst($newField);
                $result[$newField] = $value;
            }
        }
        elseif ($conversionRule === 'underscore') {
            foreach ($classProperties as $prop => $value) {
                $result[$this->toUnderscore($prop)] = $value;
            }
        }
        else {
            foreach ($classProperties as $prop => $value) {
                $newField = trim(preg_replace($this->pattern, ' ', $prop));
                $newField = str_replace(' ', '', $newField);
                $result[$newField] = $value;
            }
        }

        return $result;
    }

    /**
     * Converse camelCase to underscore (camel_case) format.
     *
     * @param  string  $value
     * @return string
     */
    public function toUnderscore(string $value) {
        preg_match_all($this->pattern2underscore, $value, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}