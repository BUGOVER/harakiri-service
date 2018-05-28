<?php
declare(strict_types=1);

namespace HarakiriService;

use HarakiriService\Contract\BaseCriteriaInterface;
use HarakiriService\Contract\BaseServiceCriteriaInterface;
use HarakiriService\Contract\BaseServiceInterface;
use HarakiriService\Criteria\BaseCriteria;
use HarakiriService\Traits\BaseServiceTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\MessageBag;
use RuntimeException;

/**
 * Class BaseService
 * @package App\AddService
 */
abstract class BaseService implements BaseServiceInterface, BaseServiceCriteriaInterface
{
    use BaseServiceTrait;

    /**
     * @var Model
     */
    protected $service;

    /**
     * @var Collection
     */
    private $criteria;

    /**
     * @var
     */
    private $skipCriteria;

    /**
     * @var array
     */
    protected $orderBy = [];

    /**
     * @var bool
     */
    protected $skipOrderingOnce = false;

    /**
     * @var
     */
    protected $query;

    /**
     * @var array
     */
    protected $scopeQuery = [];

    /**
     * @return mixed
     */
    abstract protected function entity();

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @return Model|mixed
     * @throws Exception
     */
    private function makeModel()
    {
        $model = App::make($this->entity());

        if (!$model instanceof Model) {
            throw new RuntimeException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->query = $model->newQuery();

        return $this->service = $model;
    }

    /**
     * @param $criteria
     * @return $this
     */
    public function pushCriteria($criteria)
    {
        if (\is_string($criteria)) {
            $criteria = new $criteria;
        }
        if (!$criteria instanceof BaseCriteriaInterface) {
            throw new RuntimeException('Class ' . \get_class($criteria) . " must be an instance of BugOver\\Repository\\Contracts\\CriteriaInterface");
        }
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof BaseCriteria) {
                $this->query = $criteria->apply($this->query, $this);
            }
        }

        return $this;
    }

    /**
     * @return $this|mixed
     */
    public function resetCriteria()
    {
        $this->criteria = new Collection();

        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->service->getTable();
    }


    /*=============================== Custom METHODS ELOQUENT ==========================*/

    /**
     * Apply scope in current Query
     *
     * @return $this
     */
    protected function applyScope()
    {
        foreach ($this->scopeQuery as $callback) {
            if (\is_callable($callback)) {
                $this->query = $callback($this->query);
            }
        }

        // Clear scopes
        $this->scopeQuery = [];

        return $this;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function getNew(array $attributes = [])
    {
        $this->errors = new MessageBag();

        return $this->service->newInstance($attributes);
    }

    /**
     * Reset internal Query
     *
     * @return $this
     */
    protected function scopeReset()
    {
        $this->scopeQuery = [];

        $this->query = $this->newQuery();

        return $this;
    }

    /**
     * @param bool $skipOrdering
     * @return $this
     */
    public function newQuery($skipOrdering = false)
    {
        $this->query = $this->getNew()->newQuery();
        // Apply order by
        if ($skipOrdering === false && $this->skipOrderingOnce === false) {
            foreach ($this->orderBy as $column => $dir) {
                $this->query->orderBy($column, $dir);
            }
        }
        // Reset the one time skip
        $this->skipOrderingOnce = false;
        $this->applyScope();
        return $this;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->newQuery();
        return $this->query->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        $this->newQuery();

        if ($result = $this->query->find($id, $columns)) {
            return $result;
        }

        throw (new ModelNotFoundException)->setModel($this->service);
    }

}
