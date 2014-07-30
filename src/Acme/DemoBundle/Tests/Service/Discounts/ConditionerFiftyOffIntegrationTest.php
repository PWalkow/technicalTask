<?php

namespace Acme\DemoBundle\Tests\Service\Discounts;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Acme\DemoBundle\Service\Discounts\ConditionerFiftyOff;

/**
 * @author zuo
 * 
 * @group integration
 */
class ConditionerFiftyOffIntegrationTest extends WebTestCase {
    
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
     * @return ConditionerFiftyOff
     */
    private function getService()
    {
        return $this->client->getContainer()->get('acme.discount.conditioner_fifty_off');
    }
}
