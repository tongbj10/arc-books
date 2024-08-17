<?php declare(strict_types=1);


namespace App\Common\Model;


use Swoft\Db\Query\Builder;
use Swoft\Stdlib\Helper\Str;

trait BuildQueryTrait
{
    use FieldNameTrait;

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param array $pageParams
     * @return mixed
     */
    public static function buildQueryWithPageParams($query, array $pageParams)
    {
        if (empty($pageParams)) {
            return $query;
        }
        $page = $pageParams['page'] ?? 1;
        $pageSize = $pageParams['pageSize'] ?? 15;
        $query->forPage($page,$pageSize);
        return $query;
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @return Builder|\Swoft\Db\Eloquent\Builder
     */
    public static function buildQueryWithOrderByParams($query, array $orderByParams, array $allowOrderByFields = [], string $tableName = '')
    {
        if (empty($orderByParams)) {
            $orderByParams = [
                'id' => 'desc'
            ];
        }
        foreach ($orderByParams as $field => $sortType) {
            if (!empty($allowOrderByFields) && !in_array($field,$allowOrderByFields)) {
                continue;
            }
            $field = self::getFieldNameWithTableName($field,$tableName);
            $query->orderBy($field,$sortType);
        }
        return $query;
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param string $softDeleteKey
     * @param int $softDeleteValue
     * @param string $tableName
     * @return Builder|\Swoft\Db\Eloquent\Builder
     */
    public static function buildQueryWithSoftDeleteKey($query, string $softDeleteKey = 'deleted_at', $softDeleteValue = 0, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName($softDeleteKey,$tableName);
        return $query->where($field,'=',$softDeleteValue);
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param array $condition
     * @param string $searcherClass
     * @param array $allowSearchFields
     * @return Builder|\Swoft\Db\Eloquent\Builder
     */
    public static function buildQueryWithSearchCondition($query, array $condition, string $searcherClass, array $allowSearchFields = [], string $tableName = '')
    {
        foreach ($condition as $key => $value) {
            if (!empty($allowSearchFields) && !in_array($key,$allowSearchFields)) {
                continue;
            }
            $methodName = 'search' . Str::camel($key,true);
            if (method_exists($searcherClass,$methodName)) {
                $searcherClass::$methodName($query,$value,$condition, $tableName);
            }
        }
        return $query;
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param array $condition
     * @param string $searcherClass
     * @param array $allowSearchFields
     * @return Builder|\Swoft\Db\Eloquent\Builder
     */
    public static function buildQueryWithContext($query)
    {
        if (context()->get('useWritePdo',false)) {
            $query->useWritePdo();
        }
        return $query;
    }
}