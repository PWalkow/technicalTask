<?php

namespace Acme\DemoBundle\Tests\Service\Discounts;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Acme\DemoBundle\Service\Discounts\ThreeForTwo;

/**
 * @author zuo
 * 
 * @group integration
 */
class ThreeForTwoIntegrationTest extends WebTestCase {
    
    private $client;
    
    public function setUp()
    {
        $this->client = $this->createClient();
    }
    
    public function test_service_existence()
    {
        $this->assertInstanceOf(
            'Acme\DemoBundle\Service\DiscountSpecificationIterface',
            $this->getService()
        );
    }
    
    /**
     * @return ThreeForTwo
     */
    private function getService()
    {
        return $this->client->getContainer()->get('acme.discount.three_for_two');
    }
}
