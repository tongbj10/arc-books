<?php declare(strict_types=1);


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class OrderByParamsValidator
 * @Validator()
 */
class OrderByParamsValidator implements ValidatorInterface
{

    /**
     * @inheritDoc
     */
    public function validate(array $data, array $params): array
    {
        $orderBy = $data['order_by'] ?? '';
        if (is_null($orderBy) || !is_array($orderBy)) {
            throw new ValidatorException('排序字段格式不正确');
        }
        foreach ($orderBy as $field => $sortType) {
            if (empty($field) || !in_array($sortType,[
                    'asc',
                    'desc'
                ])) {
                throw new ValidatorException('排序字段格式不正确');
            }
        }
        return $data;
    }
}