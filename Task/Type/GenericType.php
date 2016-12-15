<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\Task\Type;

use Phlexible\Bundle\TaskBundle\Entity\Task;

/**
 * Generic formatter.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class GenericType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'generic';
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function createPayload($payload)
    {
        return $payload;
    }

    /**
     * {@inheritdoc}
     */
    public function createSummary($summary)
    {
        return $summary;
    }

    /**
     * {@inheritdoc}
     */
    public function createDescription($description)
    {
        return $description;
    }

    /**
     * {@inheritdoc}
     */
    public function createLink(Task $task)
    {
        $mailLink = '?e=tasks&p[id]='.$task->getId();

        return $mailLink;
    }

    /**
     * {@inheritdoc}
     */
    public function createMenuHandle(Task $task)
    {
        $menuHandle = [
            'xtype' => 'tasks',
        ];

        return $menuHandle;
    }
}
