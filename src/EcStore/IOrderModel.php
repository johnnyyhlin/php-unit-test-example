<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 10/16/2018
 * Time: 9:57 PM
 */
namespace App\EcStore;

use Closure;
interface IOrderModel
{
    public function save(MyOrder $order, Closure $insertCallback, Closure $updateCallback);
    public function delete(Closure $predicate);
}