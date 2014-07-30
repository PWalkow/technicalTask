<?php

namespace Acme\DemoBundle\Tests;


use Acme\DemoBundle\Tests\DemoBundleBaseTestCase;
use Acme\DemoBundle\Model\Order;

/**
 * @author zuo
 * 
 * @group unit
 */
class OrderTest extends DemoBundleBaseTestCase {
    
    public function test_findCheapestProductByCategory()
    {   
        $order = new Order();
        $chepestProductCat1 = $this->mockProduct('test', 1);
        $chepestProductCat2 = $this->mockProduct('other', 1);
        
        $order->products = array(
            $this->mockProduct('test', 2),
            $this->mockProduct('test', 3),
            $chepestProductCat1,
            $chepestProductCat2,
            $this->mockProduct('other', 1),
        );
        
        $this->assertEquals(
            $chepestProductCat1,
            $order->findCheapestProductForCategory('test')
        );
        
        $this->assertEquals(
            $chepestProductCat2,
            $order->findCheapestProductForCategory('other')
        );
    }
}
