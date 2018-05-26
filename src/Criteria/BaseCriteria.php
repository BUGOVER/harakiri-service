<?php
declare(strict_types=1);

namespace HarakiriService\Criteria;

use HarakiriService\Contract\BaseCriteriaInterface;
use HarakiriService\Traits\BaseCriteriaTrait;

abstract class BaseCriteria implements BaseCriteriaInterface
{
    use BaseCriteriaTrait;
}
