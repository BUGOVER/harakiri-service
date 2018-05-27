<?php
declare(strict_types=1);

namespace HarakiriPattern\Contract;

/**
 * Interface BaseServiceCriteriaInterface
 * @package App\BaseServiceEloquent\Contract
 */
interface BaseServiceCriteriaInterface
{
    /**
     * @param $criteria
     * @return mixed
     */
    public function pushCriteria($criteria);

    /**
     * @return mixed
     */
    public function resetCriteria();

    /**
     * @return mixed
     */
    public function applyCriteria();
}
