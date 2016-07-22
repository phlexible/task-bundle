<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
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
