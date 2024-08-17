<?php declare(strict_types=1);


namespace App\Common\Model;


abstract class BaseLogic
{
	use BuildQueryTrait;

	use HandleColumnTrait;

	use GetterTrait;

    use DBTrait;
}