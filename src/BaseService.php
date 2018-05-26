<?php
declare(strict_types=1);

namespace HarakiriService;

use HarakiriPattern\Contract\BaseCriteriaInterface;
use HarakiriPattern\Contract\BaseServiceCriteriaInterface;
use HarakiriPattern\Contract\BaseServiceInterface;
use HarakiriPattern\Criteria\BaseCriteria;
use HarakiriPattern\Traits\BaseServiceTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use RuntimeException;
use Illuminate\Support\Facades\App;

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
    abstract protected function model();

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

}
