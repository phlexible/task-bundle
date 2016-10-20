<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle;

use Phlexible\Bundle\TaskBundle\DependencyInjection\Compiler\AddTaskTypesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Task bundle
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class PhlexibleTaskBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddTaskTypesPass());
    }
}
