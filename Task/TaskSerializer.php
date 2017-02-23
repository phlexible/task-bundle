<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\Task;

use Phlexible\Bundle\TaskBundle\Entity\Task;
use Phlexible\Bundle\TaskBundle\Model\TaskManagerInterface;
use Phlexible\Bundle\TaskBundle\Task\Type\TypeCollection;
use Phlexible\Bundle\UserBundle\Model\UserManagerInterface;

/**
 * Task serializer.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class TaskSerializer
{
    /**
     * @var TaskManagerInterface
     */
    private $taskManager;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var TypeCollection
     */
    private $types;

    /**
     * TaskSerializer constructor.
     *
     * @param TaskManagerInterface $taskManager
     * @param UserManagerInterface $userManager
     * @param TypeCollection       $types
     */
    public function __construct(
        TaskManagerInterface $taskManager,
        UserManagerInterface $userManager,
        TypeCollection $types
    ) {
        $this->taskManager = $taskManager;
        $this->userManager = $userManager;
        $this->types = $types;
    }

    /**
     * @param Task $task
     *
     * @return array
     */
    public function serialize(Task $task)
    {
        $assignedUser = $this->userManager->find($task->getAssignedUserId());
        $createUser = $this->userManager->find($task->getCreateUserId());

        $type = $this->types->get($task->getType());

        $transitions = [];
        foreach ($task->getTransitions() as $transition) {
            $transitionUser = $this->userManager->find($transition->getCreateUserId());
            $createdAt = $transition->getCreatedAt()->format('Y-m-d H:i:s');
            $transitions[$createdAt.'_'.$transition->getId()] = [
                'id' => $transition->getId(),
                'name' => $transition->getName(),
                'new_state' => $transition->getNewState(),
                'old_state' => $transition->getOldState(),
                'created_at' => $createdAt,
                'create_user' => $transitionUser->getDisplayName(),
            ];
        }
        ksort($transitions);
        $transitions = array_values($transitions);

        $comments = [];
        foreach ($task->getComments() as $comment) {
            $commentUser = $this->userManager->find($comment->getCreateUserId());
            $createdAt = $comment->getCreatedAt()->format('Y-m-d H:i:s');
            $comments[$createdAt.'_'.$comment->getId()] = [
                'id' => $comment->getId(),
                'current_state' => $comment->getCurrentState(),
                'comment' => $comment->getComment(),
                'created_at' => $createdAt,
                'create_user' => $commentUser->getDisplayName(),
            ];
        }
        ksort($comments);
        $comments = array_values($comments);

        $taskData = [
            'id' => $task->getId(),
            'type' => $task->getType(),
            'generic' => $task->getType() === 'generic',
            'name' => $type->getName(),
            'summary' => $task->getSummary(),
            'description' => $task->getDescription(),
            'component' => $type->getComponent(),
            'link' => $type->getLink($task),
            'assigned_user_id' => $task->getAssignedUserId(),
            'assigned_user' => $assignedUser->getDisplayName(),
            'status' => $task->getFiniteState(),
            'create_user' => $createUser->getDisplayName(),
            'create_user_id' => $task->getCreateUserId(),
            'created_at' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            'transitions' => $transitions,
            'comments' => $comments,
            'states' => $this->taskManager->getTransitions($task),
        ];

        return $taskData;
    }
}
