<?php

namespace Acme\DemoBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

use JMS\Serializer\Annotation as JMS;

/**
 * @author zuo
 */
class Order {
    
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
     * @param string $category
     * @return Product
     */
    public function findCheapestProductForCategory($category)
    {
        return min($this->findProductsByCategory($category));
    }
    
    private function findProductsByCategory($category)
    {
        $products = array();
        
        foreach ($this->products as $product)
        {
            if ($product->category === $category)
            {
                $products[] = $product;
            }
        }
        
        return $products;
    }
}
