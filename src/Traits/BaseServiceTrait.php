<?php
declare(strict_types=1);

namespace HarakiriPattern\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

trait BaseServiceTrait
{
    /**
     * BaseServiceTrait constructor.
     */
    public function __construct()
    {
        $this->app = new Container();
        $this->criteria = new Collection();
        $this->makeModel();
    }

}
