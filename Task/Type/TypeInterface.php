<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\TaskBundle\Task\Type;

use Phlexible\Bundle\TaskBundle\Entity\Task;

/**
 * Type interface
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
    public function getRole();

    /**
     * @param string $summary
     *
     * @return string
     */
    public function createSummary($summary);

    /**
     * @param string $description
     *
     * @return string
     */
    public function createDescription($description);

    /**
     * @param Task $task
     *
     * @return string
     */
    public function createLink(Task $task);

    /**
     * @param Task $task
     *
     * @return array
     */
    public function createMenuHandle(Task $task);
}
