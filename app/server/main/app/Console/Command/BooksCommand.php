<?php declare(strict_types=1);


namespace App\Console\Command;


use App\Model\Entity\Books;
use App\Model\Logic\BooksLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandArgument;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use Swoft\Console\Input\Input;
use Swoft\Console\Output\Output;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Collection;

/**
 * Class BooksCommand
 * @Command()
 */
class BooksCommand
{
    /**
     * @Inject()
     * @var BooksLogic
     */
    protected $booksLogic;

    /**
     * @CommandMapping()
     * @param Input $input
     * @param Output $output
     * @CommandArgument("key",type="string",desc="cache key",mode=Command::ARG_OPTIONAL)
     */
    public function clearAllBooksCache(Input $input, Output $output)
    {
//        $key = $input->getArg('key');
        $queryBuilder = DB::table(Books::tableName());
        $queryBuilder->orderBy('id')->chunk(100, function (Collection $apps) use ($output, $key) {
            foreach ($apps as $app) {
                $this->booksLogic->removeBookCache($app['id']);
                $output->info("clear {$app['id']} finish!");
            }
        });
        $output->success('all clear finish!');
    }
}