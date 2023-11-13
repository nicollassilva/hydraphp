<?php

namespace Emulator\Game\Rooms\Utils\Pathfinder;

use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Data\RoomTile;
use Emulator\Game\Rooms\Types\RoomObject;
use Emulator\Game\Rooms\Types\Entities\RoomEntity;
use Emulator\Game\Rooms\Utils\Pathfinder\PathfinderNode;

class Pathfinder
{
    public static ?Pathfinder $instance = null;
    
    private array $diagonalMovePoints = [];
    public array $movePoints = [];

    public function __construct()
    {
        $this->setDiagonalMovePoints();
        $this->setMovePoints();
    }

    public static function getInstance(): Pathfinder
    {
        if(self::$instance === null) {
            self::$instance = new Pathfinder();
        }

        return self::$instance;
    }

    private function setDiagonalMovePoints(): void
    {
        $this->diagonalMovePoints = [
            new Position(-1, -1),
            new Position(0, -1),
            new Position(1, 1),
            new Position(0, 1),
            new Position(1, -1),
            new Position(1, 0),
            new Position(-1, 1),
            new Position(-1, 0)
        ];
    }

    private function setMovePoints(): void
    {
        $this->movePoints = [
            new Position(0,  -1),
            new Position(1, 0),
            new Position(0, 1),
            new Position(-1, 0),
        ];
    }

    public function makePath(RoomObject $roomObject, RoomTile $end, bool $isRetry = false): array
    {
        return $this->makePathWithMode($roomObject, $end, $isRetry);
    }

    public function makePathWithMode(RoomObject $roomObject, RoomTile $end, bool $isRetry): array
    {
        $tiles = [];
        $nodes = $this->makePathReversed($roomObject, $end, $isRetry);

        if ($nodes !== null) {
            while ($nodes->getNextNode() !== null) {
                $tiles[] = $nodes->getCurrent();
                $nodes = $nodes->getNextNode();
            }
        }

        return array_reverse($tiles);
    }

    private function makePathReversed(RoomObject $roomObject, RoomTile $end, bool $isRetry): ?PathfinderNode
    {
        $openList = new \SplPriorityQueue();
        $map = array_fill(0, $roomObject->getRoom()->getModel()->getMapSizeX(), array_fill(0, $roomObject->getRoom()->getModel()->getMapSizeY(), null));

        $currentNode = new PathfinderNode($roomObject->getCurrentTile(), 0);
        $finishNode = new PathfinderNode($end);

        $map[$currentNode->getPosition()->getX()][$currentNode->getPosition()->getY()] = $currentNode;
        $openList->insert($currentNode, -$currentNode->getCost());

        while (!$openList->isEmpty()) {
            /** @var PathfinderNode */
            $currentNode = $openList->extract();
            $currentNode->setInClosed(true);

            for ($i = 0; $i < count($this->diagonalMovePoints); $i++) {
                $tmpTile = $roomObject->getRoom()->getModel()->getTileForPathfinder($currentNode->getPosition(), $this->diagonalMovePoints[$i]);

                if(empty($tmpTile)) continue;

                $isFinalMove = ($tmpTile->getPosition()->getX() === $end->getPosition()->getX() && $tmpTile->getPosition()->getY() === $end->getPosition()->getY());

                if ($this->isValidStep($roomObject, $currentNode->getPosition(), $tmpTile->getPosition(), $isFinalMove, $isRetry)) {
                    try {
                        if (!isset($map[$tmpTile->getPosition()->getX()][$tmpTile->getPosition()->getY()])) {
                            $node = new PathfinderNode($tmpTile);
                            $map[$tmpTile->getPosition()->getX()][$tmpTile->getPosition()->getY()] = $node;
                        } else {
                            /** @var PathfinderNode */
                            $node = $map[$tmpTile->getPosition()->getX()][$tmpTile->getPosition()->getY()];
                        }
                    } catch (\Exception $ignored) {
                        continue;
                    }

                    if (!$node->isInClosed()) {
                        $diff = 0;
                        $cost = $currentNode->getCost() + $diff + $node->getPosition()->getDistanceTo($end->getPosition());

                        if ($cost < $node->getCost()) {
                            $node->setCost($cost);
                            $node->setNextNode($currentNode);
                        }

                        if (!$node->isInOpen()) {
                            if ($node->getPosition()->getX() === $finishNode->getPosition()->getX() && $node->getPosition()->getY() === $finishNode->getPosition()->getY()) {
                                $node->setNextNode($currentNode);
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

    public function isValidStep(RoomObject $object, Position $from, Position $to, bool $isLastStep, bool $isRetry): bool
    {
        if($object instanceof RoomEntity) {
            return $object->getRoom()->getMappingComponent()->isValidEntityStep($object, $from, $to, $isLastStep, $isRetry);
        }

        return $object->getRoom()->getMappingComponent()->isValidStep($object, $from, $to, $isLastStep, $isRetry);
    }
}
