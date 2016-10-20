<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\Finite;

use Finite\StateMachine\StateMachine;
use Phlexible\Bundle\TaskBundle\Finite\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Loads a StateMachine from a yaml file
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class StateMachineFactory
{
    /**
     * @param FileLocatorInterface     $locator
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $yamlFile
     *
     * @return StateMachine
     */
    public static function factory(FileLocatorInterface $locator, EventDispatcherInterface $eventDispatcher, $yamlFile)
    {
        $stateMachine = new StateMachine(null, $eventDispatcher);

        $loader = new YamlFileLoader($locator->locate($yamlFile));
        $loader->load($stateMachine);

        return $stateMachine;
    }
}
