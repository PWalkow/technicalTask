<?php

namespace Acme\DemoBundle\Service\Discounts;

use Acme\DemoBundle\Service\DiscountSpecificationIterface;
use Acme\DemoBundle\Model\Order;

/**
 * @author zuo
 */
class ThreeForTwoDiscount implements DiscountSpecificationIterface {
    
    public function apply(Order $order) {
        $categorySizes = $this->countItemsByCategories($order);
        
        foreach ($categorySizes as $category => $size)
        {
            if ($size < 3) {
                continue;
            }
            
            $cheapest = $order->findCheapestProductForCategory($category);
            
            $cheapest->price = 0;
        }
    }

    public function isSatisfiedBy(Order $order) {
        $categorySizes = $this->countItemsByCategories($order);
        
        if (max($categorySizes) < 3) {
            return false;
        }
        
        return true;
    }
    
    protected function countItemsByCategories(Order $order)
    {
        $categories = array();
        
        foreach ($order->products as $product)
        {
            if (!isset($categories[$product->category])) {
                $categories[$product->category] = 0;
            }
            
            $categories[$product->category] += 1;
        }
        
        return $categories;
    }
}
