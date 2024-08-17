<?php declare(strict_types=1);


namespace app\Model\Dao;


use App\Common\Model\BaseDao;
use App\Exception\ApiException;
use App\Model\Entity\Books;
use App\Model\Entity\BooksSaleLog;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\Eloquent\Builder;
use Swoft\Db\Eloquent\Model;

/**
 * Class BooksSaleLogDao
 * @Bean()
 */
class BooksSaleLogDao extends BaseDao
{
    /**
     * @param string $no
     * @param int $num
     * @param string $date
     * @return int
     */
    public function create(
        string $no,
        int    $num,
        string $date
    ): int
    {
        $booksSaleLog = BooksSaleLog::new();
        $booksSaleLog->setNo($no);
        $booksSaleLog->setNum($num);
        $booksSaleLog->setDate($date);
        $booksSaleLog->save();
        return $booksSaleLog->getId();
    }
}