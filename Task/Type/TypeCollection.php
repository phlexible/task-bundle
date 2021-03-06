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

use Phlexible\Bundle\TaskBundle\Exception\InvalidArgumentException;

/**
 * Type collection.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class TypeCollection
{
    /**
     * @var TypeInterface[]
     */
    private $types;

    /**
     * @param TypeInterface[] $types
     */
    public function __construct(array $types)
    {
        $this->setTypes($types);
    }

    /**
     * @param TypeInterface[] $types
     *
     * @return $this
     */
    public function setTypes(array $types)
    {
        foreach ($types as $type) {
            $this->add($type);
        }

        return $this;
    }

    /**
     * @return TypeInterface[]
     */
    public function all()
    {
        return $this->types;
    }

    /**
     * @param TypeInterface $type
     *
     * @return $this
     */
    public function add(TypeInterface $type)
    {
        $this->types[$type->getName()] = $type;

        return $this;
    }

    /**
     * @param string $typeId
     *
     * @throws InvalidArgumentException
     *
     * @return TypeInterface|null
     */
    public function get($typeId)
    {
        if (!isset($this->types[$typeId])) {
            throw new InvalidArgumentException("Type $typeId not found.");
        }

        return $this->types[$typeId];
    }
}
