<?php

namespace Acme\DemoBundle\Tests\Service;

use Acme\DemoBundle\Service\TotalPriceCounter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author zuo
 *
 * @group integration
 */
class TotalPriceCounterIntegrationTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    public function test_service_existence()
    {
        $this->assertInstanceOf(
            'Acme\DemoBundle\Service\TotalPriceCounter',
            $this->getService()
        );
    }

    /**
     * @return TotalPriceCounter
     */
    private function getService()
    {
        return $this->client->getContainer()->get('acme.total_price_counter');
    }
}
