<?php

namespace CometProject\Server\Game\Rooms\Objects\Entities\Pathfinding;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Types\RoomObject;
use CometProject\Server\Game\Rooms\Objects\Entities\Pathfinding\PathfinderNode;

class Pathfinder
{
    public static Pathfinder $instance;
    
    private $diagonalMovePoints = [
        ['x' => -1, 'y' => -1],
        ['x' => 0, 'y' => -1],
        ['x' => 1, 'y' => 1],
        ['x' => 0, 'y' => 1],
        ['x' => 1, 'y' => -1],
        ['x' => 1, 'y' => 0],
        ['x' => -1, 'y' => 1],
        ['x' => -1, 'y' => 0],
    ];
    
    public const movePoints = [
        ['x' => 0, 'y' => -1],
        ['x' => 1, 'y' => 0],
        ['x' => 0, 'y' => 1],
        ['x' => -1, 'y' => 0],
    ];

    public static function getInstance(): Pathfinder
    {
        if(self::$instance === null) {
            self::$instance = new Pathfinder();
        }

        return self::$instance;
    }

    public function makePath(RoomObject $roomObject, Position $end): array
    {
        return $this->makePathWithMode($roomObject, $end, false);
    }

    public function makePathWithMode(RoomObject $roomObject, Position $end, bool $isRetry): array
    {
        $positions = [];
        $nodes = $this->makePathReversed($roomObject, $end, $isRetry);

        if ($nodes !== null) {
            while ($nodes->getNextNode() !== null) {
                $positions[] = new Position($nodes->getPosition()->getX(), $nodes->getPosition()->getY(), 0);
                $nodes = $nodes->getNextNode();
            }
        }

        return array_reverse($positions);
    }

    private function makePathReversed(RoomObject $roomObject, Position $end, bool $isRetry): ?PathfinderNode
    {
        $openList = new \SplPriorityQueue();
        $map = array_fill(0, $roomObject->getRoom()->getModel()->getMapSizeX(), array_fill(0, $roomObject->getRoom()->getModel()->getMapSizeY(), null));

        $node = null;
        $tmp = [];

        $cost = 0;
        $diff = 0;

        $current = new PathfinderNode($roomObject->getPosition());
        $current->setCost(0);

        $finish = new PathfinderNode($end);

        $map[$current->getPosition()->getX()][$current->getPosition()->getY()] = $current;
        $openList->insert($current, -$current->getCost());

        while (!$openList->isEmpty()) {
            $current = $openList->extract();
            $current->setInClosed(true);

            for ($i = 0; $i < count(self::movePoints); $i++) {
                $tmp = $current->getPosition()->add(self::movePoints)[$i];
                $isFinalMove = ($tmp['x'] === $end->getX() && $tmp['y'] === $end->getY());

                if ($this->isValidStep($roomObject, new Position($current->getPosition()->getX(), $current->getPosition()->getY(), $current->getPosition()->getZ()), $tmp, $isFinalMove, $isRetry)) {
                    try {
                        if ($map[$tmp['x']][$tmp['y']] === null) {
                            $node = new PathfinderNode(new Position($tmp['x'], $tmp['y'], $tmp['z']));
                            $map[$tmp['x']][$tmp['y']] = $node;
                        } else {
                            $node = $map[$tmp['x']][$tmp['y']];
                        }
                    } catch (\Exception $e) {
                        continue;
                    }

                    if (!$node->isInClosed()) {
                        $diff = 0;

                        $cost = $current->getCost() + $diff + $node->getPosition()->getDistanceSquared($end);

                        if ($cost < $node->getCost()) {
                            $node->setCost($cost);
                            $node->setNextNode($current);
                        }

                        if (!$node->isInOpen()) {
                            if ($node->getPosition()->getX() === $finish->getPosition()->getX() && $node->getPosition()->getY() === $finish->getPosition()->getY()) {
                                $node->setNextNode($current);
                                return $node;
                            }

                            $node->setInOpen(true);
                            $openList->insert($node, -$node->getCost());
                        }
                    }
                }
            }
        }

        return null;
    }

    public function isValidStep(RoomObject $object, Position $from, Position $to, bool $lastStep, bool $isRetry): bool
    {
        return true;
    }
}
