<?php declare(strict_types=1);


namespace App\Common\Model;


use Swoft\Db\Eloquent\Builder;
use Swoft\Db\Eloquent\Model;
use Swoft\Stdlib\Helper\Str;

abstract class BaseDao
{
    use DBTrait;

    /**
     * @param Model $model
     * @param array $updateData
     * @param array $allowUpdateField
     */
    public function updateBySetter(Model $model, array $updateData, array $allowUpdateField = [])
    {
        $notAllowUpdateField = ['id','created_at','updated_at','deleted_at'];
        foreach ($updateData as $field => $value) {
            if (in_array($field,$notAllowUpdateField)) {
                continue;
            }
            if (!empty($allowUpdateField) && !in_array($field,$allowUpdateField)) {
                continue;
            }
            if ($model->hasSetter($field)) {
                $model->setModelAttribute($field,$value);
            }
        }
    }
}