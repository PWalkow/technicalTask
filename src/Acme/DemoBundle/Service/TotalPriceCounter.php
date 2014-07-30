<?php

namespace Acme\DemoBundle\Service;

use Acme\DemoBundle\Model\Order;

/**
 * @author zuo
 */
class TotalPriceCounter {

    /**
     * Count total price of order
     * 
     * @param Order $order
     * @return double
     */
    public function count(Order $order) {
        
        $this->countTotalPrice($order);
        
        return $order->total;
    }
    
    private function countTotalPrice(Order $order)
    {
        $totalPrice = 0;
        
        foreach ($order->products as $product)
        {
            $totalPrice += $product->price;
        }
        
        $order->total = $totalPrice;
    }

}
