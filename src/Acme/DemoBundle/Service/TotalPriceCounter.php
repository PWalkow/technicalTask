<?php

namespace Acme\DemoBundle\Service;

use Acme\DemoBundle\Model\Order;

/**
 * @author zuo
 */
class TotalPriceCounter
{
    /**
     * @var DiscountSpecificationInterface[]
     */
    private $discounts;

    public function __construct()
    {
        $this->discounts = array();
    }

    public function addDiscountSpecification(DiscountSpecificationIterface $discount)
    {
        $this->discounts[] = $discount;
    }

    /**
     * Count total price of order
     *
     * @param  Order  $order
     * @return double
     */
    public function count(Order $order)
    {
        foreach ($this->discounts as $discount) {
            if ($discount->isSatisfiedBy($order)) {
                $discount->apply($order);
            }
        }

        $this->countTotalPrice($order);

        return $order->total;
    }

    private function countTotalPrice(Order $order)
    {
        $totalPrice = 0;

        foreach ($order->products as $product) {
            $totalPrice += $product->price;
        }

        $order->total = $totalPrice;
    }
}
