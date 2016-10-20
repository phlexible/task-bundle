<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Phlexible\Bundle\TaskBundle\Entity\Comment;
use Phlexible\Bundle\TaskBundle\Entity\Task;
use Phlexible\Bundle\TaskBundle\Entity\Transition;
use Phlexible\Bundle\UserBundle\Event\ApplySuccessorEvent;

/**
 * Apply successor listener.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class ApplySuccessorListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ApplySuccessorEvent $event
     */
    public function onApplySuccessor(ApplySuccessorEvent $event)
    {
        $fromUser = $event->getFromUser();
        $toUser = $event->getToUser();

        $fromUserId = $fromUser->getId();
        $toUserId = $toUser->getId();

        $taskRepository = $this->entityManager->getRepository(Task::class);
        $taskCommentRepository = $this->entityManager->getRepository(Comment::class);
        $taskTransitionRepository = $this->entityManager->getRepository(Transition::class);

        foreach ($taskRepository->findByCreateUserId($fromUserId) as $task) {
            $task->setCreateUserId($toUserId);
        }

        foreach ($taskCommentRepository->findByCreateUserId($fromUserId) as $comment) {
            $comment->setCreateUserId($toUserId);
        }

        foreach ($taskTransitionRepository->findByCreateUserId($fromUserId) as $transition) {
            $transition->setCreateUserId($toUserId);
        }

        foreach ($taskRepository->findByAssignedUserId($fromUserId) as $task) {
            $task->setAssignedUserId($toUserId);
        }

        $this->entityManager->flush();
    }
}
