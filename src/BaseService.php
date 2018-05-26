<?php
declare(strict_types=1);

namespace HarakiriService;

use Exception;
use HarakiriService\Contract\BaseCriteriaInterface;
use HarakiriService\Contract\BaseServiceCriteriaInterface;
use HarakiriService\Contract\BaseServiceInterface;
use HarakiriService\Criteria\BaseCriteria;
use HarakiriService\Traits\BaseServiceTrait;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
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
    protected $model;

    /**
     * @var
     */
    private $modelQuery;

    /**
     * @var Collection
     */
    private $criteria;

    /**
     * @var
     */
    private $skipCriteria;

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
        $model = App::make($this->model());

        if (!$model instanceof Model) {
            throw new RuntimeException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->modelQuery = $model->newQuery();

        return $this->model = $model;
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
                $this->modelQuery = $criteria->apply($this->modelQuery, $this);
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
        return $this->model->getTable();
    }

    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function lists($column, $key = null)
    {
        $this->applyCriteria();

        return $this->model->lists($column, $key);
    }

    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function pluck($column, $key = null)
    {
        $this->applyCriteria();

        return $this->model->pluck($column, $key);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function all()
    {
        return $this->model::all();
    }

    /**
     * @param $relations
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public function with($relations)
    {
        return $this->model::with($relations);
    }

    /**
     * @param null $connection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function on($connection = null)
    {
        return $this->model->on($connection = null);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function onWriteConnection()
    {
        return $this->model->onWriteConnection();
    }

    /**
     * @param $ids
     * @return int
     */
    public function destroy($ids)
    {
        return $this->model::destroy($ids);
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * @param null $connection
     * @return mixed
     */
    public function resolveConnection($connection = null)
    {
        return $this->model->resolveRouteBinding($connection = null);
    }

    /**
     * @return mixed
     */
    public function getConnectionResolver()
    {
        return $this->model->getConnectionResolver();
    }

    /**
     * @param ConnectionResolverInterface $resolver
     * @return mixed
     */
    public function setConnectionResolver(ConnectionResolverInterface $resolver)
    {
        return $this->model->setConnectionResolver($resolver);
    }

    /**
     * @param ConnectionResolverInterface $resolver
     * @return mixed
     */
    public function unsetConnectionResolver(ConnectionResolverInterface $resolver)
    {
        return $this->model->unsetConnectionResolver($resolver);
    }

}
