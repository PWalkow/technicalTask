<?php

namespace Acme\DemoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author zuo
 */
class DiscountCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('acme.total_price_counter')) {
            return;
        }

        $definition = $container->getDefinition(
            'acme.total_price_counter'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'acme.discount'
        );
        
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addDiscountSpecification',
                array(new Reference($id))
            );
        }
    }
}