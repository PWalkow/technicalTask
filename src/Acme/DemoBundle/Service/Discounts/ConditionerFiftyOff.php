<?php

namespace Acme\DemoBundle\Service\Discounts;

use Acme\DemoBundle\Service\DiscountSpecificationIterface;
use Acme\DemoBundle\Model\Order;

/**
 * @author zuo
 * 
 * @todo move categories const to model
 */
class ConditionerFiftyOff implements DiscountSpecificationIterface {
    
    const CATEGORY_SHAMPOO = 'Shampoo';
    const CATEGORY_CONDITIONER = 'Conditioner';
    
    public function apply(Order $order) {
        $cheapestConditioner = $order->findCheapestProductForCategory(
            self::CATEGORY_CONDITIONER
        );
        
        $cheapestConditioner->price = $cheapestConditioner->price / 2;
    }

    public function isSatisfiedBy(Order $order) {
        $categories = $this->getCategories($order);
        
        if (
            array_key_exists(
                self::CATEGORY_SHAMPOO,
                $categories
            ) &&
            array_key_exists(
                self::CATEGORY_CONDITIONER, 
                $categories
            ) 
        ) {
            return true;
        }
        
        return false;
    }
    
    protected function getCategories(Order $order)
    {
        $categories = array();
        
        foreach ($order->products as $product)
        {   
            if (!isset($categories[$product->category])) {
                $categories[$product->category] = true;
            }
        }
        
        return $categories;
    }
}
