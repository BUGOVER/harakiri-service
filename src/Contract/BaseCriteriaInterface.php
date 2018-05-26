<?php
declare(strict_types=1);

namespace HarakiriPattern\Contract;

/**
 * Interface BaseCriteriaInterface
 * @package App\BaseServiceEloquent\Contract
 */
/**
 * Interface BaseCriteriaInterface
 * @package App\BaseServiceEloquent\Contract
 */
interface BaseCriteriaInterface
{
    /**
     * @param $model
     * @param BaseServiceInterface $repository
     * @return mixed
     */
    public function apply($model, BaseServiceInterface $repository);
}
