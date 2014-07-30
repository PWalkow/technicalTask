<?php

namespace Acme\DemoBundle\Tests\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Acme\DemoBundle\Command\DiscountCommand;


/**
 * @group functional
 *
 * @author zuo
 */
class DiscountCommandTest extends WebTestCase {
    
    /**
     * @var DiscountCommand 
     */
    private $command;
    
    /**
     * @var CommandTester
     */
    private $commandTester;
    
    public function setUp()
    {
        $kernel = self::createKernel();
        $kernel->boot();
        
        $application = new Application($kernel);
        $application->add(new DiscountCommand());
        
        $this->command = $application->find(DiscountCommand::NAME);
        $this->commandTester = new CommandTester($this->command);
    }
    
    public function test_command_existence()
    { 
        $this->assertInstanceOf('Acme\DemoBundle\Command\DiscountCommand', $this->command);
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not enough arguments
     */
    public function test_it_throws_runtime_exception_without_filename()
    {
        $this->commandTester->execute(array(
            'command' => DiscountCommand::NAME,
        ));
    }
    
    /**
     * @dataProvider order_filename_provider
     * 
     * @param type $orderFilename
     * @param type $expectedTotalPrice
     */
    public function test_it_counts_total_price_on_order($orderFilename, $expectedTotalPrice)
    {
        $this->commandTester->execute(array(
            'command' => DiscountCommand::NAME,
            DiscountCommand::ARGUMENT_FILENAME => __DIR__ . '/Fixtures/' . $orderFilename
        ));
        
        $this->assertContains($expectedTotalPrice, $this->commandTester->getDisplay());
    }
    
    public function order_filename_provider()
    {
        return array(
            array('test_1.xml', '9.98'),
            array('test_2.xml', '24.43'),
            array('test_3.xml', '7.73'),
        );
    }
}
