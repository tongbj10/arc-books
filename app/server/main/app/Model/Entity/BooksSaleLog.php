<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class BooksSaleLog
 *
 * @since 2.0
 *
 * @Entity(table="books_sale_log")
 */
class BooksSaleLog extends Model
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
     * 售卖数量
     *
     * @Column()
     *
     * @var int
     */
    private $num;

    /**
     * 日期
     *
     * @Column()
     *
     * @var string
     */
    private $date;

    /**
     * 创建时间戳
     *
     * @Column(name="created_at", prop="created_at")
     *
     * @var int
     */
    private $createdAt;

    /**
     * 删除时间戳
     *
     * @Column(name="deleted_at", prop="deleted_at")
     *
     * @var int
     */
    private $deletedAt;

    /**
     * 修改时间戳
     *
     * @Column(name="updated_at", prop="updated_at")
     *
     * @var int
     */
    private $updatedAt;


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
     * @param string $date
     *
     * @return self
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

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
     * @param int $num
     *
     * @return self
     */
    public function setNum(int $num): self
    {
        $this->num = $num;

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
     * @return int
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDate(): ?string
    {
        return $this->date;
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
     * @return string
     */
    public function getNo(): ?string
    {
        return $this->no;
    }

    /**
     * @return int
     */
    public function getNum(): ?int
    {
        return $this->num;
    }

    /**
     * @return int
     */
    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }

}
