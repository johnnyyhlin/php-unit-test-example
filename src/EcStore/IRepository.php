<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 10/16/2018
 * Time: 10:26 PM
 */

namespace App\EcStore;
interface IRepository
{
    public function isExist(MyOrder $order);
    public function insert(MyOrder $order);
    public function update(MyOrder $order);
}