<?php


namespace Kl;


class UserPayment
{
    public $id;

    public $userId;

    public $type;

    public $balanceBefore;

    public $amount;

    public function __construct($userId, $type, $balanceBefore, $amount, $id = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->type = $type;
        $this->balanceBefore = $balanceBefore;
        $this->amount = $amount;
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