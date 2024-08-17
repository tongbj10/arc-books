<?php declare(strict_types=1);


namespace App\Common\Model;


use Swoft\Db\Query\Builder;

abstract class BaseSearcher
{
    use FieldNameTrait;

    /**
     * 日期查询表达式
     * @var array
     */
    const TIME_RULE = [
        'today'      => ['today', 'tomorrow -1second'],
        'yesterday'  => ['yesterday', 'today -1second'],
        'week'       => ['this week 00:00:00', 'next week 00:00:00 -1second'],
        'last week'  => ['last week 00:00:00', 'this week 00:00:00 -1second'],
        'month'      => ['first Day of this month 00:00:00', 'first Day of next month 00:00:00 -1second'],
        'last month' => ['first Day of last month 00:00:00', 'first Day of this month 00:00:00 -1second'],
        'year'       => ['this year 1/1', 'next year 1/1 -1second'],
        'last year'  => ['last year 1/1', 'this year 1/1 -1second'],
    ];

    /**
     * 获取本季度 time
     * @param int $ceil
     * @return array
     */
    private static function getQuarterStartAndEndDay(int $ceil = 0)
    {
        if ($ceil != 0) {
            $season = ceil(date('n') / 3) - $ceil;
        } else {
            $season = ceil(date('n') / 3);
        }
        $season = (int)$season;
        $firstday = date('Y-m-01', mktime(0, 0, 0, ($season - 1) * 3 + 1, 1, (int)date('Y')));
        $lastday = date('Y-m-t', mktime(0, 0, 0, $season * 3, 1, (int)date('Y')));
        return [$firstday, $lastday];
    }

    /**
     * @param string $timeKey
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     */
    protected static function _searchTime(string $timeKey, $query, $value, array $data, string $tableName = '')
    {
        if (empty($value)) {
            return;
        }
        $timeKey = self::getFieldNameWithTableName($timeKey,$tableName);
        switch ($value) {
            case 'today':
            case 'week':
            case 'month':
            case 'year':
            case 'yesterday':
            case 'last year':
            case 'last week':
            case 'last month':
                $rule = self::TIME_RULE[$value];
                $query->whereBetween($timeKey, [strtotime($rule[0]),strtotime($rule[1])]);
                break;
            case 'quarter':
                list($startTime, $endTime) = self::getQuarterStartAndEndDay();
                $query->whereBetween($timeKey, [$startTime, $endTime]);
                break;
            case 'lately7':
                $query->whereBetween($timeKey, [strtotime("-7 day"), time()]);
                break;
            case 'lately30':
                $query->whereBetween($timeKey, [strtotime("-30 day"), time()]);
                break;
            default:
                if (is_string($value)) {
                    $value = json_decode($value,true);
                }
                if (is_array($value)) {
                    $startTime = $value[0] ?? null;
                    $endTime = $value[1] ?? null;
                    if ($startTime && $endTime) {
                        if (!is_numeric($startTime)) {
                            $start = strtotime($startTime);
                        } else {
                            $start = $startTime;
                        }
                        if (!is_numeric($endTime)) {
                            if ($startTime == $endTime) {
                                if (strlen($startTime) == 10) {
                                    $end = $start + 86400;
                                } else {
                                    $end = $start;
                                }
                            } else {
                                $end = strtotime($endTime);
                            }
                        } else {
                            $end = $endTime;
                        }
                        $query->whereBetween($timeKey, [$start, $end]);
                    } else if (!$startTime && $endTime) {
                        if (!is_numeric($endTime)) {
                            if (strlen($endTime) == 10) {
                                $end = strtotime($endTime) + 86400;
                            } else {
                                $end = strtotime($endTime);
                            }
                        } else {
                            $end = $endTime;
                        }
                        $query->where($timeKey, '<', $end);
                    } else if ($startTime && !$endTime) {
                        if (!is_numeric($startTime)) {
                            if (strlen($startTime) == 10) {
                                $start = strtotime($startTime . ' 00:00:00');
                            } else {
                                $start = strtotime($startTime);
                            }
                        } else {
                            $start = $startTime;
                        }
                        $query->where($timeKey, '>=', $start);
                    }
                }
                break;
        }
    }

    /**
     * @param string $dateKey
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     */
    protected static function _searchDate(string $dateKey, $query, $value, array $data, string $tableName = '')
    {
        if (empty($value)) {
            return;
        }
        $dateKey = self::getFieldNameWithTableName($dateKey,$tableName);
        switch ($value) {
            case 'today':
                $query->where($dateKey, date('Y-m-d'));
                break;
            case 'week':
            case 'month':
            case 'year':
            case 'yesterday':
            case 'last year':
            case 'last week':
            case 'last month':
                $rule = self::TIME_RULE[$value];
                $query->whereBetween($dateKey, [date('Y-m-d',strtotime($rule[0])),date('Y-m-d',strtotime($rule[1]))]);
                break;
            case 'quarter':
                list($startTime, $endTime) = self::getQuarterStartAndEndDay();
                $query->whereBetween($dateKey, [date('Y-m-d',$startTime), date('Y-m-d',$endTime)]);
                break;
            case 'lately7':
                $query->whereBetween($dateKey, [date('Y-m-d',strtotime("-7 day")), date('Y-m-d',time())]);
                break;
            case 'lately30':
                $query->whereBetween($dateKey, [date('Y-m-d',strtotime("-30 day")), date('Y-m-d',time())]);
                break;
            default:
                if (is_string($value)) {
                    $value = json_decode($value,true);
                }
                if (is_array($value)) {
                    $startTime = $value[0] ?? null;
                    $endTime = $value[1] ?? null;
                    if ($startTime && $endTime) {
                        if (!is_numeric($startTime)) {
                            $start = strtotime($startTime);
                        } else {
                            $start = $startTime;
                        }
                        if (!is_numeric($endTime)) {
                            if ($startTime == $endTime) {
                                $end = $start;
                            } else {
                                $end = strtotime($endTime);
                            }
                        } else {
                            $end = $endTime;
                        }
                        $startDate = date('Y-m-d',$start);
                        $endDate = date('Y-m-d',$end);
                        if ($startDate == $endDate) {
                            $query->where($dateKey, $startDate);
                        } else {
                            $query->whereBetween($dateKey, [$startDate, $endDate]);
                        }
                    } else if (!$startTime && $endTime) {
                        if (!is_numeric($endTime)) {
                            if (strlen($endTime) == 10) {
                                $end = strtotime($endTime) + 86400;
                            } else {
                                $end = strtotime($endTime);
                            }
                        } else {
                            $end = $endTime;
                        }
                        $query->where($dateKey, '<', date('Y-m-d',$end));
                    } else if ($startTime && !$endTime) {
                        if (!is_numeric($startTime)) {
                            if (strlen($startTime) == 10) {
                                $start = strtotime($startTime . ' 00:00:00');
                            } else {
                                $start = strtotime($startTime);
                            }
                        } else {
                            $start = $startTime;
                        }
                        $query->where($dateKey, '>=', date('Y-m-d',$start));
                    }
                }
                break;
        }
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     */
    public static function searchCreatedAt($query, $value, array $data, string $tableName = '')
    {
        self::_searchTime('created_at', $query, $value, $data, $tableName);
    }

    /**
     * @param Builder|\Swoft\Db\Eloquent\Builder $query
     * @param $value
     * @param array $data
     * @param string $tableName
     */
    public static function searchId($query, $value, array $data, string $tableName = '')
    {
        $field = self::getFieldNameWithTableName('id',$tableName);
        if (is_array($value)) {
            if (!empty($value)) {
                $query->whereIn($field,$value);
            } else {
                $query->where($field,0);
            }
        } elseif (is_numeric($value)) {
            $query->where($field, $value);
        }
    }
}