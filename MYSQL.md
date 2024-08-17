
#### 图书表
```
CREATE TABLE `books` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '图书编号',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '书名',
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '作者',
  `type` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `publish_date` date NOT NULL COMMENT '出版日期',
  `level` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '评价评级',
  `created_at` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  `updated_at` int unsigned NOT NULL DEFAULT '0' COMMENT '修改时间戳',
  `deleted_at` int unsigned NOT NULL DEFAULT '0' COMMENT '删除时间戳',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_key` (`no`,`deleted_at`),
  KEY `title` (`title`),
  KEY `author` (`author`),
  KEY `type` (`type`),
  KEY `no` (`no`),
  KEY `publish_data` (`publish_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
```

## insert sql
```
INSERT INTO books (`no`,`title`,`author`,`type`,`price`,`publish_date`,`level`,`created_at`, `updated_at`) 
VALUES('books1','第一本书','tbj',1,'19.9','2024-08-17',5, 1723901179，1723901179);
```

## update sql
```
UPDATE books SET `no` = 'book111', `title` = 'title111', ... WHERE `id` = 1;
```

## delete sql(本次设计的软删除，并未使用到delete sql)
```
DELETE FROM books WHERE `id` = 5;
```

#### 图书售卖日志表
```
CREATE TABLE `books_sale_log` (
`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
`no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '' COMMENT '图书编号',
`date` date NOT NULL COMMENT '日期',
`num` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '售卖数量',
`created_at` int unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
`updated_at` int unsigned NOT NULL DEFAULT '0' COMMENT '修改时间戳',
`deleted_at` int unsigned NOT NULL DEFAULT '0' COMMENT '删除时间戳',
PRIMARY KEY (`id`),
KEY `no` (`no`),
KEY `data` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
```