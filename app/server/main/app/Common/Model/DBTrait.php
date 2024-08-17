<?php declare(strict_types=1);


namespace App\Common\Model;


trait DBTrait
{
    public static function useWritePdo(bool $enable = true)
    {
        context()->set('useWritePdo',$enable);
    }

    public static function isUseWritePdo()
    {
        return context()->get('useWritePdo',false);
    }
}