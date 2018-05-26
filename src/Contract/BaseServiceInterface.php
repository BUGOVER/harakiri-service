<?php
declare(strict_types=1);

namespace HarakiriService\Contract;

interface BaseServiceInterface
{
    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function lists($column, $key = null);

    /**
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function pluck($column, $key = null);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * @param null $connection
     * @return mixed
     */
    public function on($connection = null);

    /**
     * @return mixed
     */
    public function onWriteConnection();

    /**
     * @param $ids
     * @return mixed
     */
    public function destroy($ids);

    /**
     * @return mixed
     */
    public function query();

    /**
     * @param null $connection
     * @return mixed
     */
    public function resolveConnection($connection = null);

    /**
     * @return mixed
     */
    public function getConnectionResolver();

    /**
     * @param ConnectionResolverInterface $resolver
     * @return mixed
     */
    public function setConnectionResolver(ConnectionResolverInterface $resolver);

    /**
     * @param ConnectionResolverInterface $resolver
     * @return mixed
     */
    public function unsetConnectionResolver(ConnectionResolverInterface $resolver);
}
