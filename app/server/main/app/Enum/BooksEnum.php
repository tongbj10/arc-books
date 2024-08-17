<?php declare(strict_types=1);

namespace App\Enum;


class BooksEnum
{
   // 图书类型 例如
   const TYPE_NEWS = 1;
   const TYPE_LANGUAGE = 2;
   const TYPE_MAP = [
       self::TYPE_NEWS => '新闻',
       self::TYPE_LANGUAGE => '语言'
   ];

   // 评论等级
   const LEVEL_ONE = 1;
   const LEVEL_TWO = 2;
   const LEVEL_THREE = 3;
}