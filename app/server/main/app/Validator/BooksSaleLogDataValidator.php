<?php


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;

/**
 * Class BooksSaleLogDataValidator
 * @Validator()
 */
class BooksSaleLogDataValidator implements ValidatorInterface
{
	public function validate(array $data, array $params): array
	{
		$validateData = [];
		if (array_key_exists('no', $data)) {
			$validateData['no'] = $data['no'];
		}
        if (array_key_exists('num', $data)) {
            $validateData['num'] = intval($data['num']);
        }
        if (array_key_exists('date', $data)) {
            $validateData['date'] = $data['date'];
        }
		validate($validateData, BooksSaleLogValidator::class, batch_snake_2_camel(array_keys($validateData)));
		return $data;
	}
}