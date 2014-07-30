<?php

namespace Acme\DemoBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * @author zuo
 */
class Product {
    
    /**
     * @JMS\Type("string")
     */
    public $category;
    
    /**
     * @JMS\Type("string")
     */
    public $title;
    
    /**
     * @JMS\Type("double")
     */
    public $price;
}
