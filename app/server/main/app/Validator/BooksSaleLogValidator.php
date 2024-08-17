<?php


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class BooksSaleLogValidator
 * @Validator()
 */
class BooksSaleLogValidator
{
	/**
	 * @var string
	 * @IsString(name="no", message="图书编号必须为字符串")
	 * @Required()
	 * @NotEmpty(message="图书编号不能为空")
	 */
	protected $no;

    /**
     * @var int
     * @IsInt(message="数量必须为整型")
     * @Required()
     * @NotEmpty(message="数量不能为空")
     */
    protected $num;

    /**
     * @var string
     * @IsString(name="date", message="日期必须为字符型")
     * @Required()
     * @NotEmpty(message="日期不能为空")
     */
    protected $date;
}