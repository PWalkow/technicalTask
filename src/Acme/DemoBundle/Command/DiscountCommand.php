<?php

namespace Acme\DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of DiscountCommand
 *
 * @author zuo
 */
class DiscountCommand extends ContainerAwareCommand {
    
    const NAME = 'acme:discount';
    const ARGUMENT_FILENAME = 'filename';
    
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
        $output->write('nothing here yet');
    }
}
