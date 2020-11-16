<?php


namespace Kl;


class User
{
    public $id;

    public $balance;

    public $email;

    public function __construct($id, $balance, $email)
    {
        $this->id = $id;
        $this->balance = $balance;
        $this->email = $email;
    }

    public function toArray($conversionRule = 'underscore')
    {
        $result = [];
        $vars = get_object_vars($this);

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
