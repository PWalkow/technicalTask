<?php

namespace Acme\DemoBundle\Tests\Service\Discounts;

use Acme\DemoBundle\Tests\DemoBundleBaseTestCase;
use Acme\DemoBundle\Model\Order;
use Acme\DemoBundle\Model\Product;
use Acme\DemoBundle\Service\DiscountSpecificationIterface;
use Acme\DemoBundle\Service\Discounts\ThreeForTwo;

/**
 * @author zuo
 * 
 * @group unit
 */
class ThreeForTwoTest extends DemoBundleBaseTestCase {
    
    private $discount;
    
    public function setUp()
    {
        $this->discount = new ThreeForTwo();
    }
    
    public function tearDown() {
        $this->discount = null;
    }
    
    /**
     * @dataProvider order_data_provider
     * 
     * @param Order   $order
     * @param boolean $expectedResult
     */
    public function test_isSatisfiedBy($order, $expectedResult)
    {   
        $this->assertSame(
            $expectedResult, 
            $this->discount->isSatisfiedBy($order)
        );
    }
    
    public function test_apply_should_make_price_of_cheapest_of_category_to_zero()
    {
        $cheapest = $this->mockProduct('test', 5);
        
        $order = $this->mockOrderWithProducts(array(
            $this->mockProduct('test', 10),
            $this->mockProduct('test', 12),
            $cheapest,
        ));
        
        $order
            ->shouldReceive('findCheapestProductForCategory')
            ->with('test')
            ->andReturn($cheapest);
        
        $this->discount->apply($order);
        
        $this->assertSame(0, $cheapest->price);
    }
    
    public function order_data_provider()
    {
        return array(
            array(
                $this->mockOrderWithProducts(array(
                    $this->mockProduct('test', 0),
                    $this->mockProduct('test', 0),
                    $this->mockProduct('other', 0),
                )),
                false
            ),
            array(
                $this->mockOrderWithProducts(array(
                    $this->mockProduct('test', 3),
                    $this->mockProduct('test', 5),
                    $this->mockProduct('test', 7),
                )),
                true
            ),
        );
    }
}
