<?php

namespace Kl;

trait DataConversion
{
    /**
     * @var string
     */
    public string $pattern = '/[^a-z0-9]+/i';

    /**
     * Gets objects properties and create associative array
     * on its base.
     *
     * @param  object  $obj
     * @param  string  $conversionRule
     * @return array
     */
    public function toArray(object $obj, $conversionRule = 'underscore') :array
    {
        $result = [];

        $classProperties = get_object_vars($obj);

        if ($conversionRule == 'camelCase') {
            foreach ($classProperties as $prop => $value) {
                $newField = trim(preg_replace($this->pattern, ' ', $prop));
                $newField = ucwords($newField);
                $newField = str_replace(' ', '', $newField);
                $newField = lcfirst($newField);

                $result[$newField] = $value;
            }
        }

        if ($conversionRule == 'underscore') {
            foreach ($classProperties as $prop => $value) {
                $newField = trim(preg_replace($this->pattern, ' ', $prop));
                $newField = str_replace(' ', '_', $newField);
                $newField = strtolower($newField);

                $result[$newField] = $value;
            }
        }

        return $result;
    }
}