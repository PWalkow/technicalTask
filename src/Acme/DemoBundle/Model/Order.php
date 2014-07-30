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
}
