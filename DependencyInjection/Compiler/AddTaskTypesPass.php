<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Add task types pass
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class AddTaskTypesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $types = [];
        foreach ($container->findTaggedServiceIds('phlexible_task.type') as $id => $definition) {
            $types[] = new Reference($id);
        }

        $container->findDefinition('phlexible_task.types')->replaceArgument(0, $types);
    }
}
