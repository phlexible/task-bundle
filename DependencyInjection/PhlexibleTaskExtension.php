<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Task extension.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class PhlexibleTaskExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('finite.yml');

        $configuration = $this->getConfiguration($config, $container);
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('phlexible_task.portlet.num_items', $config['portlet']['num_items']);
        $container->setParameter('phlexible_task.mail_on_close', $config['mail_on_close']);
        $container->setParameter('phlexible_task.mailer.from_email', [$config['mailer']['from_email']['address'] => $config['mailer']['from_email']['sender_name']]);
        $container->setParameter('phlexible_task.mailer.new_task.template', $config['mailer']['new_task']['template']);
        $container->setParameter('phlexible_task.mailer.update.template', $config['mailer']['update']['template']);

        $loader->load('doctrine.yml');

        $container->setAlias('phlexible_task.task_manager', 'phlexible_task.doctrine.task_manager');
    }
}
