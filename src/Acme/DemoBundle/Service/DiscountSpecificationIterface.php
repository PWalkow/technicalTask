<?php

namespace Acme\DemoBundle\Service;

use Acme\DemoBundle\Model\Order;

/**
 * @author zuo
 */
interface DiscountSpecificationIterface {
    
    public function isSatisfiedBy(Order $order);
    
    public function apply(Order $order);
}
