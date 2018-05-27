<?php
declare(strict_types=1);

namespace HarakiriPattern\Criteria;

use HarakiriPattern\Contract\BaseCriteriaInterface;
use HarakiriPattern\Traits\BaseCriteriaTrait;

abstract class BaseCriteria implements BaseCriteriaInterface
{
    use BaseCriteriaTrait;
}
