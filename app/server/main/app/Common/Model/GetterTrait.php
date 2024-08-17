<?php declare(strict_types=1);


namespace App\Common\Model;


use Swoft\Stdlib\Helper\Str;

trait GetterTrait
{
    public static function handleItemByGetter($item, string $getterClass, array $fields = [])
    {
        if (is_array($item)) {
            $methods = get_class_methods($getterClass);
            foreach ($methods as $method) {
                if (substr($method,0,3) == 'get' && substr($method,-4) == 'Attr') {
                    $key = str_replace('get','',$method);
                    $key = str_replace('Attr','',$key);
                    $key = Str::snake($key);
                    if (!empty($fields) && !in_array($key,$fields)) {
                        continue;
                    }
                    $getterRes = $getterClass::$method($item[$key] ?? null,$item);
                    if (!is_null($getterRes)) {
                        $item[$key] = $getterRes;
                    }
                }
            }
        }
        return $item;
    }
}