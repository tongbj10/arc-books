<?php declare(strict_types=1);


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class PageParamsValidator
 * @Validator()
 */
class PageParamsValidator implements ValidatorInterface
{

    /**
     * @inheritDoc
     */
    public function validate(array $data, array $params): array
    {
        $pageIndex = $data['page'] ?? 1;
        $pageSize = $data['pageSize'] ?? 15;
        if (!is_int($pageIndex) || !is_int($pageSize) || $pageIndex <= 0 || $pageSize <= 0) {
            throw new ValidatorException('分页参数需为大于0的正整数');
        }
        if ($pageSize > 100) {
            throw new ValidatorException('每次拉取数据不可大于100条');
        }
        return $data;
    }
}