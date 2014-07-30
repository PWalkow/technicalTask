<?php

namespace Acme\DemoBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation as JMS;

/**
 * @author zuo
 */
class Order
{
    /**
     * @JMS\Type("ArrayCollection<Acme\DemoBundle\Model\Product>")
     * @JMS\XmlList(entry="product")
     *
     * @var Product[]
     */
    public $products;

    /**
     * @JMS\Type("double")
     */
    public $total;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @param  string       $category
     * @return Product|null
     */
    public function findCheapestProductForCategory($category)
    {
        $productsByCategory = $this->findProductsByCategory($category);

        if (count($productsByCategory) > 0) {
            $cheapest = $productsByCategory[0];

            foreach ($productsByCategory as $product) {
                if ($cheapest->price > $product->price) {
                    $cheapest = $product;
                }
            }

            return $cheapest;
        }

        return null;
    }

    private function findProductsByCategory($category)
    {
        $products = array();

        foreach ($this->products as $product) {
            if ($product->category === $category) {
                $products[] = $product;
            }
        }

        return $products;
    }
}
