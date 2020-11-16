<?php

namespace Kl;

class User
{
    public int $id;

    public float $balance;

    public string $email;

    public function __construct(int $id, float $balance, string $email)
    {
        $this->id = $id;
        $this->balance = $balance;
        $this->email = $email;
    }

    public function toArray($conversionRule = 'underscore')
    {
        $result = [];

        $vars = get_object_vars($this);

//        if ($conversionRule === 'camelCase') {
//            foreach ($vars as $field => $value) {
//                $newField = preg_replace('/[^a-z0-9]+/i', ' ', $field);
//                $newField = trim($newField);
//                $newField = ucwords($newField);
//                $newField = str_replace(' ', '', $newField);
//                $newField = lcfirst($newField);
//
//                $result[$newField] = $value;
//            }
//            return $result;
//        } elseif ($conversionRule === 'underscore') {
//            foreach ($vars as $field => $value) {
//                $newField = preg_replace('/[^a-z0-9]+/i', ' ', $field);
//                $newField = trim($newField);
//                $newField = str_replace(' ', '_', $newField);
//                $newField = strtolower($newField);
//                $result[$newField] = $value;
//            }
//        }

        switch ($conversionRule) {
            case 'camelCase':
                foreach ($vars as $field => $value) {
                    $newField = preg_replace('/[^a-z0-9]+/i', ' ', $field);
                    $newField = trim($newField);
                    $newField = ucwords($newField);
                    $newField = str_replace(' ', '', $newField);
                    $newField = lcfirst($newField);

                    $result[$newField] = $value;
                }

                break;
            case 'underscore':
                foreach ($vars as $field => $value) {
                    $newField = preg_replace('/[^a-z0-9]+/i', ' ', $field);
                    $newField = trim($newField);
                    $newField = str_replace(' ', '_', $newField);
                    $newField = strtolower($newField);
                    $result[$newField] = $value;
                }
                break;
        }

        return $result;
    }
}
