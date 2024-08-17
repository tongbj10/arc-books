<?php


namespace App\Validator;


use Swoft\Validator\Annotation\Mapping\IsFloat;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Required;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class BooksValidator
 * @Validator()
 */
class BooksValidator
{
	/**
	 * @var string
	 * @IsString(name="no", message="图书编号必须为字符串")
	 * @Required()
	 * @NotEmpty(message="图书编号不能为空")
	 */
	protected $no;

	/**
     * @var string
     * @IsString(message="书名必须为字符型")
     * @Required()
     * @NotEmpty(message="书名不能为空")
	 */
	protected $title;

    /**
     * @var string
     * @IsString(name="author", message="作者必须为字符型")
     * @Required()
     * @NotEmpty(message="作者不能为空")
     * @Length(min=1,max=100,message="作者长度不能超过100字符")
     */
    protected $author;

    /**
     * @var int
     * @IsInt(message="类型必须为整型")
     * @Required()
     * @NotEmpty(message="类型不能为空")
     */
    protected $type;

    /**
     * @var float
     * @IsFloat(message="价格必须为浮点型")
     * @Required()
     * @NotEmpty(message="价格不能为空")
     */
    protected $price;

    /**
     * @var string
     * @IsString(name="publish_date", message="发布日期必须为字符型")
     * @Required()
     * @NotEmpty(message="发布日期不能为空")
     */
    protected $publishDate;

    /**
     * @var int
     * @IsInt(message="等级必须为整型")
     * @Required()
     * @NotEmpty(message="等级不能为空")
     */
    protected $level;
}