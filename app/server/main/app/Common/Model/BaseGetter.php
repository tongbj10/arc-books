<?php declare(strict_types=1);


namespace App\Common\Model;


abstract class BaseGetter
{
    public static function getCreatedAtStrAttr($value, $item)
    {
        if (!array_key_exists('created_at',$item)) {
            return null;
        }
        if (!empty($item['created_at'])) {
            return date('Y-m-d H:i:s',$item['created_at']);
        } else {
            return '';
        }
    }

    public static function getUpdatedAtStrAttr($value, $item)
    {
        if (!array_key_exists('updated_at',$item)) {
            return null;
        }
        if (!empty($item['updated_at'])) {
            return date('Y-m-d H:i:s',$item['updated_at']);
        } else {
            return '';
        }
    }
}