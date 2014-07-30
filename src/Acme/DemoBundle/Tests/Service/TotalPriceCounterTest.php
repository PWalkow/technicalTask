<?php

namespace Acme\DemoBundle\Tests\Service;

use Acme\DemoBundle\Service\TotalPriceCounter;
use Acme\DemoBundle\Model\Order;
use Acme\DemoBundle\Model\Product;
use Acme\DemoBundle\Service\DiscountSpecificationIterface;

/**
 * @author zuo
 * 
 * @group unit
 */
class TotalPriceCounterTest extends \PHPUnit_Framework_TestCase {
    
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
                    $this->mockProductWithValue(3),
                    $this->mockProductWithValue(5),
                    $this->mockProductWithValue(7),
                )),
                15
            ),
        );
    }
    
    private function mockDiscount()
    {
        return \Mockery::mock(DiscountSpecificationIterface::class);
    }
    
    private function mockOrderWithProducts(array $products)
    {
        $order = \Mockery::mock(Order::class);
        
        $order->products = $products;
        
        return $order;
    }
    
    private function mockProductWithValue($value)
    {
        $product = \Mockery::mock(Product::class);
        
        $product->price = $value;
        
        return $product;
    }
}
