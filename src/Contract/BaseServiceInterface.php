<?php
declare(strict_types=1);

namespace HarakiriPattern\Contract;

use Illuminate\Database\ConnectionResolverInterface;

interface BaseServiceInterface
{
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
