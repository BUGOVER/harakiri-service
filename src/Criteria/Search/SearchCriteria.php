<?php
declare(strict_types=1);

namespace HarakiriService\Criteria\Search;

use HarakiriPattern\Contract\BaseServiceInterface;
use HarakiriPattern\Criteria\BaseCriteria;

/**
 * Class SearchCriteria
 * @package App\BaseServiceEloquent\Criteria\Search
 */
class SearchCriteria extends BaseCriteria
{

    /**
     * @var null
     */
    private $table;
    /**
     * @var
     */
    private $columns;

    /**
     * @var
     */
    private $value;

    /**
     * SearchCriteria constructor.
     */
    public function __construct($value, $columns = null, $table = null)
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->value = $value;
    }

    /**
     * @param $model
     * @param BaseServiceInterface $baseService
     * @return mixed
     */
    public function apply($model, BaseServiceInterface $baseService)
    {
        if (empty($this->table)) {
            $this->table = $baseService->getTable();
        }

        if (empty($this->columns)) {
            $this->columns = $baseService->getSearchableColumns();
        } elseif (!\is_array($this->columns)) {
            $this->columns = [$this->columns];
        }

        $this->columns = $baseService->fixColumns($this->columns);

        $model->where(function ($query) {
            foreach ($this->columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $this->value . '%');
            }
        });

        return $model;
    }
}
