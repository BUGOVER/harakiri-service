<?php
declare(strict_types=1);

namespace HarakiriPattern\Criteria\Where;

use HarakiriPattern\Contract\BaseServiceInterface;
use HarakiriPattern\Criteria\BaseCriteria;

/**
 * Class WhereCriteria
 * @package App\BaseServiceEloquent\Criteria\WhereCriteria
 */
class WhereCriteria extends BaseCriteria
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $comparison;

    /**
     * WhereCriteria constructor.
     */
    public function __construct($attribute, $value, $cmp = '=')
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->comparison = $cmp;
    }

    /**
     * @param $model
     * @param BaseServiceInterface $baseService
     * @return mixed
     */
    public function apply($model, BaseServiceInterface $baseService)
    {
        return $model->where($baseService->fixColumns($this->attribute), $this->comparison, $this->value);
    }
}
