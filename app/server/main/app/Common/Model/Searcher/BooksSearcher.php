<?php declare(strict_types=1);


namespace App\Common\Model\Searcher;


use App\Common\Model\BaseSearcher;
use Swoft\Db\Query\Builder;

class BooksSearcher extends BaseSearcher
{
    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     * @param string $tableName
     * @return void
     */
    public static function searchTitle($query, $value, array $data, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName('title', $tableName);
        if (is_string($value) && strlen($value) > 0) {
            $query->where($field, '=', $value);
        }
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     * @param string $tableName
     */
    public static function searchAuthor($query, $value, array $data, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName('author', $tableName);
        if (is_string($value) && strlen($value) > 0) {
            $query->where($field, 'like', "%{$value}%");
        }
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     * @param string $tableName
     */
    public static function searchNo($query, $value, array $data, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName('no', $tableName);
        if (is_numeric($value)) {
            $query->where($field, $value);
        }
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     * @param string $tableName
     */
    public static function searchType($query, $value, array $data, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName('type', $tableName);
        if (is_numeric($value)) {
            $query->where($field, $value);
        }
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     * @param string $tableName
     */
    public static function searchPublishDate($query, $value, array $data, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName('publish_date', $tableName);
        if (is_numeric($value)) {
            $query->where($field, $value);
        }
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     * @param string $tableName
     */
    public static function searchLevel($query, $value, array $data, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName('level', $tableName);
        if (is_numeric($value)) {
            $query->where($field, $value);
        }
    }
}