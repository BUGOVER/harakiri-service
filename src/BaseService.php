<?php
declare(strict_types=1);

namespace HarakiriPattern;

use Exception;
use HarakiriPattern\Contract\BaseCriteriaInterface;
use HarakiriPattern\Contract\BaseServiceCriteriaInterface;
use HarakiriPattern\Contract\BaseServiceInterface;
use HarakiriPattern\Criteria\BaseCriteria;
use HarakiriPattern\Traits\BaseTrait;
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
    use BaseTrait;

    /**
     * @var
     */
    private $modelQuery;

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
    protected function makeModel()
    {
        $model = App::make($this->entity());

        if (!$model instanceof Model) {
            throw new RuntimeException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        $this->modelQuery = $model->newQuery();

        return $this->model = $model;
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
        return $this->model->destroy($ids);
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
