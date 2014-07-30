<?php

namespace Acme\DemoBundle\Tests;

use Acme\DemoBundle\Model\Order;
use Acme\DemoBundle\Model\Product;

/**
 * @author zuo
 */
class DemoBundleBaseTestCase extends \PHPUnit_Framework_TestCase {
    
    protected function mockOrderWithProducts(array $products)
    {
        $order = \Mockery::mock(Order::class);
        
        $order->products = $products;
        
        return $order;
    }
    
    protected function mockProduct($category, $price)
    {
        $product = \Mockery::mock(Product::class);
        
        $product->category = $category;
        $product->price = $price;
        
        return $product;
    }
}
