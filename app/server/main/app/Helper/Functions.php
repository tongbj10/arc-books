<?php
declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

use Swoft\Validator\Exception\ValidatorException;

if (!function_exists('validates')) {
    /**
     * @param array $data
     * @param $validatorName
     *
     * @return array
     * @throws ValidatorException
     */
    function validates(
        array $data,
        $validatorName
    ): array {
        /* @var \Swoft\Validator\Validator $validator */
        $validator = \Swoft\Bean\BeanFactory::getBean('validator');
        if (!is_array($validatorName) && !is_string($validatorName)) {
            throw new ValidatorException('validatorName must be string or array');
        }
        if (is_string($validatorName)) {
            $validatorName = [
                $validatorName => [
                    'type' => \Swoft\Validator\Annotation\Mapping\ValidateType::BODY
                ]
            ];
        } elseif (is_array($validatorName)) {
            foreach ($validatorName as $name => $validate) {
                if (array_key_exists('type',$validate)) {
                    $validatorName[$name]['type'] = \Swoft\Validator\Annotation\Mapping\ValidateType::BODY;
                }
            }
        }
        return $validator->validateRequest($data,$validatorName)[0];
    }
}

if (!function_exists('batch_snake_2_camel')) {
    function batch_snake_2_camel(array $fields) {
        foreach ($fields as $index => $field) {
            $fields[$index] = \Swoft\Stdlib\Helper\Str::camel($field);
        }
        return $fields;
    }
}

