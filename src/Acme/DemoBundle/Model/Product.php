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
     * @JMS\XmlAttribute
     */
    public $title;
    
    /** 
     * @JMS\Type("double")
     * @JMS\XmlAttribute
     */
    public $price;
}
