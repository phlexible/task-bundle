<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
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
