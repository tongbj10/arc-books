<?php declare(strict_types=1);


namespace App\Common\Model;


trait HandleColumnTrait
{
    public static function setColumnIfEmpty(array &$column = [])
    {
        if (empty($column)) {
            $column = ['*'];
        }
    }

    public static function setColumnIfFieldExist(array &$column = [], array $ifExistColumn = [], array $setColumn = [])
    {
        $originColumn = $column;
        $extraColumn = array_intersect($column,$ifExistColumn);
        if (!empty($extraColumn)) {
            $column = array_diff($column,$extraColumn);
            $column = array_merge($column,$setColumn);
            if (!empty(array_intersect($originColumn,$extraColumn)) && count($originColumn) == count($extraColumn)) {
                $column = [];
            }
        }
        return $extraColumn;
    }
}