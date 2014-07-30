<?php

namespace Acme\DemoBundle\Tests\Service\Discounts;

use Acme\DemoBundle\Tests\DemoBundleBaseTestCase;
use Acme\DemoBundle\Model\Order;
use Acme\DemoBundle\Service\Discounts\ConditionerFiftyOff;

/**
 * @author zuo
 *
 * @group unit
 */
class ConditionerFiftyOffTest extends DemoBundleBaseTestCase
{
    private $discount;

    public function setUp()
    {
        $this->discount = new ConditionerFiftyOff();
    }

    public function tearDown()
    {
        $this->discount = null;
    }

    /**
     * @dataProvider order_data_provider
     *
     * @param Order   $order
     * @param boolean $expectedResult
     */
    public function test_isSatisfiedBy($order, $expectedResult)
    {
        $this->assertSame(
            $expectedResult,
            $this->discount->isSatisfiedBy($order)
        );
    }

    public function test_apply_should_make_price_of_cheapest_conditioner_to_zero()
    {
        $conditioner = $this->mockProduct(ConditionerFiftyOff::CATEGORY_CONDITIONER, 5.5);
        $shampoo = $this->mockProduct(ConditionerFiftyOff::CATEGORY_SHAMPOO, 12);

        $order = $this->mockOrderWithProducts(array(
            $conditioner,
            $shampoo
        ));

        $order
            ->shouldReceive('findCheapestProductForCategory')
            ->with(ConditionerFiftyOff::CATEGORY_CONDITIONER)
            ->andReturn($conditioner);

        $this->discount->apply($order);

        $this->assertSame(2.75, $conditioner->price);
    }

    public function order_data_provider()
    {
        return array(
            array(
                $this->mockOrderWithProducts(array(
                    $this->mockProduct(ConditionerFiftyOff::CATEGORY_CONDITIONER, 0),
                    $this->mockProduct('test', 0),
                )),
                false
            ),
            array(
                $this->mockOrderWithProducts(array(
                    $this->mockProduct(ConditionerFiftyOff::CATEGORY_SHAMPOO, 3),
                    $this->mockProduct('test', 5),
                )),
                false
            ),
            array(
                $this->mockOrderWithProducts(array(
                    $this->mockProduct(ConditionerFiftyOff::CATEGORY_SHAMPOO, 3),
                    $this->mockProduct(ConditionerFiftyOff::CATEGORY_CONDITIONER, 5),
                )),
                true
            ),
        );
    }
}
