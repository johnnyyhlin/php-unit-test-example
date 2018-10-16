<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 10/16/2018
 * Time: 9:59 PM
 */

namespace App\EcStore;


class MyOrder
{
    public $id;
    public $amount;
    public function __construct($id = null, $amount = null)
    {
        $this->id = $id;
        $this->amount = $amount;
    }
}