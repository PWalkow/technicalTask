<?php

namespace Acme\DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use JMS\Serializer\Serializer;

/**
 * Description of DiscountCommand
 *
 * @author zuo
 */
class DiscountCommand extends ContainerAwareCommand {
    
    const NAME = 'acme:discount';
    const ARGUMENT_FILENAME = 'filename';
    
    /**
     * @var Serializer
     */
    private $serializer;
    
    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->serializer = $this->getContainer()->get('jms_serializer');
        
        parent::initialize($input, $output);
    }
 
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Technical test command for discount an order')
            ->addArgument(self::ARGUMENT_FILENAME, InputArgument::REQUIRED, 'File with an xml order.');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) {
        $filename = $input->getArgument(self::ARGUMENT_FILENAME);
        
        $order = $this->serializer->deserialize(
            file_get_contents($filename),
            'Acme\DemoBundle\Model\Order',
            'xml'
        );
        
        $output->write($order->total);
    }
}
