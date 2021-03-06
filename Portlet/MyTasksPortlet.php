<?php

/*
 * This file is part of the phlexible task package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\TaskBundle\Portlet;

use Phlexible\Bundle\DashboardBundle\Portlet\Portlet;
use Phlexible\Bundle\TaskBundle\Model\TaskManagerInterface;
use Phlexible\Bundle\TaskBundle\Task\Type\TypeCollection;
use Phlexible\Bundle\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * My tasks portlet.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class MyTasksPortlet extends Portlet
{
    /**
     * @var TaskManagerInterface
     */
    private $taskManager;

    /**
     * @var TypeCollection
     */
    private $types;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var int
     */
    private $numItems;

    /**
     * @param TranslatorInterface   $translator
     * @param TaskManagerInterface  $taskManager
     * @param TypeCollection        $types
     * @param TokenStorageInterface $tokenStorage
     * @param UserManagerInterface  $userManager
     * @param int                   $numItems
     */
    public function __construct(
        TranslatorInterface $translator,
        TaskManagerInterface $taskManager,
        TypeCollection $types,
        TokenStorageInterface $tokenStorage,
        UserManagerInterface $userManager,
        $numItems)
    {
        $this
            ->setId('my-tasks-portlet')
            ->setTitle($translator->trans('tasks.my_tasks', [], 'gui'))
            //->setDescription('Displays your active tasks')
            ->setClass('Phlexible.tasks.portlet.MyTasks')
            ->setIconClass('p-task-portlet-icon')
            ->setRole('ROLE_TASKS');

        $this->taskManager = $taskManager;
        $this->types = $types;
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
        $this->numItems = $numItems;
    }

    /**
     * Return Portlet data.
     *
     * @return array
     */
    public function getData()
    {
        $tasksToShow = $this->numItems;

        $tasks = $this->taskManager->findByAssignedToAndStatus(
            $this->tokenStorage->getToken()->getUser()->getId(),
            [],
            [],
            $tasksToShow
        );

        $data = [];

        foreach ($tasks as $task) {
            $createUser = $this->userManager->find($task->getCreateUserId());
            $type = $this->types->get($task->getType());

            $data[] = [
                'id' => $task->getId(),
                'text' => $type->getText($task),
                'type' => $task->getType(),
                'status' => $task->getFiniteState(),
                'comment' => '', //$latestStatus->getComment(), TODO: fix
                'create_user' => $createUser->getDisplayName(),
                'create_uid' => $task->getCreateUserId(),
                'create_date' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $data;
    }
}
