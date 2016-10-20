<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\Tests;

use Phlexible\Bundle\TaskBundle\DependencyInjection\Compiler\AddTaskTypesPass;
use Phlexible\Bundle\TaskBundle\PhlexibleTaskBundle;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Task bundle test
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class PhlexibleTaskBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBundleAddsCompilerPass()
    {
        $container = $this->prophesize(ContainerBuilder::class);

        $container->addCompilerPass(Argument::type(AddTaskTypesPass::class))->shouldBeCalled();

        $bundle = new PhlexibleTaskBundle();
        $bundle->build($container->reveal());

    }
}
