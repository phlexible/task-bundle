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
 * Type interface.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
interface TypeInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getComponent();

    /**
     * @return string
     */
    public function getRole();

    /**
     * @param Task $task
     *
     * @return string
     */
    public function getTitle(Task $task);

    /**
     * @param Task $task
     *
     * @return string
     */
    public function getText(Task $task);

    /**
     * @param Task $task
     *
     * @return string
     */
    public function getLink(Task $task);

    /**
     * @param Task $task
     *
     * @return array
     */
    public function getMenuHandle(Task $task);
}
