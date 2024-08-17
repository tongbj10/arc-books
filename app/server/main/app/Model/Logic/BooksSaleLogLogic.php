<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Common\Model\BaseLogic;
use App\Exception\ApiException;
use App\Model\Dao\BooksSaleLogDao;
use App\Validator\BooksSaleLogDataValidator;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Db\DB;
use Swoft\Redis\Redis;
use Swoole\Exception;

/**
 * Class BooksSaleLogLogic
 * @Bean()
 */
class BooksSaleLogLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var BooksSaleLogDao
     */
    protected $booksSaleLogDao;

    /**
     * @param string $no
     * @param int $num
     * @param string $date
     * @return int
     * @throws ApiException
     */
    public function addBooksSaleLog(
        string $no,
        int    $num,
        string $date
    ): int
    {
        $validateData = [
            'no' => $no,
            'num' => $num,
            'date' => $date,
        ];
        validates($validateData, BooksSaleLogDataValidator::class);
        try {
            $booksSaleLogId = $this->booksSaleLogDao->create($no, $num, $date);
            if ($booksSaleLogId) {
                // 存储redis 后续销量统计
                $this->setBooksSaleLogCache(date('Y-m', time()), $no, $num);
            }
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
        return $booksSaleLogId;
    }

    /**
     * 获取前十名畅销书籍
     * @return array
     */
    public function getTopTenBooks(): array
    {
        $month = date('Y-m', time());
        $cacheKey = $this->getBooksSaleLogCacheKey($month);
        return Redis::zRevRange($cacheKey,0,9);
    }

    /**
     * 获取缓存key
     * @param string $bookNo
     * @return string
     */
    public function getBooksSaleLogCacheKey(string $bookNo): string
    {
        return 'books_sale_log:' . $bookNo;
    }

    /**
     * 设置缓存
     * @param string $month
     * @param string $no
     * @param int $num
     * @return true
     */
    public function setBooksSaleLogCache(string $month, string $no, int $num): bool
    {
        $cacheKey = $this->getBooksSaleLogCacheKey($month);
        Redis::zIncrBy($cacheKey, $num, $no);
        return true;
    }
}