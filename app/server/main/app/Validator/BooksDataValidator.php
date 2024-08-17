<?php


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;

/**
 * Class BooksDataValidator
 * @Validator()
 */
class BooksDataValidator implements ValidatorInterface
{
	public function validate(array $data, array $params): array
	{
		$validateData = [];
		if (array_key_exists('no', $data)) {
			$validateData['no'] = $data['no'];
		}
		if (array_key_exists('title', $data)) {
			$validateData['title'] = $data['title'];
		}
        if (array_key_exists('author', $data)) {
            $validateData['author'] = $data['author'];
        }
        if (array_key_exists('type', $data)) {
            $validateData['type'] = intval($data['type']);
        }
        if (array_key_exists('price', $data)) {
            $validateData['price'] = $data['price'];
        }
        if (array_key_exists('publish_date', $data)) {
            $validateData['publish_date'] = $data['publish_date'];
        }
        if (array_key_exists('level', $data)) {
            $validateData['level'] = intval($data['level']);
        }
		validate($validateData, BooksValidator::class, batch_snake_2_camel(array_keys($validateData)));
		return $data;
	}
}