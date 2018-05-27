<?php
declare(strict_types=1);

namespace HarakiriPattern\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait BaseTrait
{
    /**
     * @var Collection
     */
    private $criteria;


    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseTrait constructor.
     */
    public function __construct()
    {
        $this->app = new Container();
        $this->criteria = new Collection();
        $this->makeModel();
    }

}
