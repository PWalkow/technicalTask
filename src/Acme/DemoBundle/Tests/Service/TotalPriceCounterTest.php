<?php

namespace Acme\DemoBundle\Tests\Service;

use Acme\DemoBundle\Tests\DemoBundleBaseTestCase;
use Acme\DemoBundle\Service\TotalPriceCounter;
use Acme\DemoBundle\Model\Order;
use Acme\DemoBundle\Model\Product;
use Acme\DemoBundle\Service\DiscountSpecificationIterface;

/**
 * @author zuo
 * 
 * @group unit
 */
class TotalPriceCounterTest extends DemoBundleBaseTestCase {
    
    private $totalPriceCounter;
    
    public function setUp()
    {
        $this->totalPriceCounter = new TotalPriceCounter();
    }
    
    public function tearDown() {
        $this->totalPriceCounter = null;
    }
    
    /**
     * @dataProvider order_data_provider
     * 
     * @param Order  $order
     * @param double $expectedTotalPrice
     */
    public function test_count_should_return_total_price($order, $expectedTotalPrice)
    {
        $result = $this->totalPriceCounter->count($order);
        
        $this->assertSame($expectedTotalPrice, $result);
    }
    
    /**
     * @dataProvider order_data_provider
     */
    public function test_count_should_apply_discounts($order)
    {
        $discount = $this->mockDiscount();
        
        $discount
            ->shouldReceive('isSatisfiedBy')
            ->once()
            ->with($order)
            ->andReturn(true);
        
        $discount
            ->shouldReceive('apply')
            ->with($order)
            ->once();
        
        $this->totalPriceCounter->addDiscountSpecification($discount);
        
        $this->totalPriceCounter->count($order);
    }
    
    public function order_data_provider()
    {
        return array(
            array(
                $this->mockOrderWithProducts(array(
                    $this->mockProduct('test', 3),
                    $this->mockProduct('test',5),
                    $this->mockProduct('test',7),
                )),
                15
            ),
        );
    }
    
    private function mockDiscount()
    {
        return \Mockery::mock(DiscountSpecificationIterface::class);
    }
}
