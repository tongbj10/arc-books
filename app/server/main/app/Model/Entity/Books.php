<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class Books
 *
 * @since 2.0
 *
 * @Entity(table="books")
 */
class Books extends Model
{
    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 图书编号
     *
     * @Column()
     *
     * @var string
     */
    private $no;

    /**
     * 书名
     *
     * @Column()
     *
     * @var string
     */
    private $title;

    /**
     * 作者
     *
     * @Column()
     *
     * @var string
     */
    private $author;

    /**
     * 类型
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 价格
     *
     * @Column()
     *
     * @var float
     */
    private $price;

    /**
     * 出版日期
     *
     * @Column(name="publish_date", prop="publish_date")
     *
     * @var string
     */
    private $publishDate;

    /**
     * 评价评级
     *
     * @Column()
     *
     * @var int
     */
    private $level;

    /**
     * 创建时间戳
     *
     * @Column(name="created_at", prop="created_at")
     *
     * @var int
     */
    private $createdAt;

    /**
     * 修改时间戳
     *
     * @Column(name="updated_at", prop="updated_at")
     *
     * @var int
     */
    private $updatedAt;

    /**
     * 删除时间戳
     *
     * @Column(name="deleted_at", prop="deleted_at")
     *
     * @var int
     */
    private $deletedAt;

    /**
     * @param string $author
     *
     * @return self
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @param int $createdAt
     *
     * @return self
     */
    public function setCreatedAt(int $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param int $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(int $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param int $level
     *
     * @return self
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @param string $no
     *
     * @return self
     */
    public function setNo(string $no): self
    {
        $this->no = $no;

        return $this;
    }

    /**
     * @param float $price
     *
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @param string $publishDate
     *
     * @return self
     */
    public function setPublishDate(string $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param int $type
     *
     * @return self
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(int $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getDeletedAt(): ?int
    {
        return $this->deletedAt;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getNo(): ?string
    {
        return $this->no;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getPublishDate(): ?string
    {
        return $this->publishDate;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }

}
