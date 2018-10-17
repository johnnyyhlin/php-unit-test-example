<?php
/**
 * Created by PhpStorm.
 * User: Miko
 * Date: 10/16/2018
 * Time: 10:03 PM
 */

namespace Tests\EcStore;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use App\EcStore\MyOrderModel;
use App\EcStore\IRepository;
use App\EcStore\MyOrder;

class MyOrderModelTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    /** @test */
    public function insert_order()
    {
        $repository = m::mock(IRepository::class);
        $myOrderModel = new MyOrderModel($repository);

        $repository->shouldReceive('isExist')->andReturn(false);
        $repository->shouldReceive('insert')->once();

        $insertFlag = false;
        $insertFunc = function ($order) use (&$insertFlag) {
            $insertFlag = true;
        };
        $updateFlag = false;
        $updateFunc = function ($order) use (&$updateFlag) {
            $updateFlag = true;
        };

        $myOrderModel->save(new MyOrder(), $insertFunc, $updateFunc);

        $this->assertTrue($insertFlag);
        $this->assertFalse($updateFlag);
    }
    /** @test */
    public function update_order()
    {
        // TODO
    }
}