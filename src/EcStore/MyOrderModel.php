<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 10/16/2018
 * Time: 9:56 PM
 */

namespace App\EcStore;

use Closure;
use phpDocumentor\Reflection\Types\Callable_;

class MyOrderModel implements IOrderModel
{
    /**
     * @var IRepository
     */
    private $repository;
    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }
    public function save(MyOrder $order, callable $insertCallback, callable $updateCallback)
    {
        if (!$this->repository->isExist($order)) {
            $this->repository->insert($order);
            $insertCallback($order);
        }
        else {
            $this->repository->update($order);
            $updateCallback($order);
        }
    }
    public function delete(Closure $predicate)
    {
        throw new Exception('Not implemented');
    }
}