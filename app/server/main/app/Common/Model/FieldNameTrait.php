<?php declare(strict_types=1);


namespace App\Common\Model;


trait FieldNameTrait
{
    protected static function getFieldNameWithTableName(string $field, string $tableName = '', string $prefix = '')
    {
        if (empty($tableName)) {
            return $field;
        } else {
            return $prefix . $tableName . '.' . $field;
        }
    }

    protected static function getFieldNameArrayWithTableName(array $fields = [], string $tableName = '', string $prefix = '')
    {
        if (empty($tableName)) {
            return $fields;
        }
        $newFields = [];
        foreach ($fields as $field) {
            $newFields[] = self::getFieldNameWithTableName($field,$tableName,$prefix);
        }
        return $newFields;
    }
}