<?php

namespace Emulator\Game\Rooms\Utils\Pathfinder;

use Emulator\Game\Rooms\Types\Entities\RoomEntity;
use Emulator\Game\Utilities\Position;
use Emulator\Game\Rooms\Types\RoomObject;
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

    public function makePath(RoomObject $roomObject, Position $end, bool $isRetry = false): array
    {
        return $this->makePathWithMode($roomObject, $end, $isRetry);
    }

    public function makePathWithMode(RoomObject $roomObject, Position $end, bool $isRetry): array
    {
        $positions = [];
        $nodes = $this->makePathReversed($roomObject, $end, $isRetry);

        if ($nodes !== null) {
            while ($nodes->getNextNode() !== null) {
                $positions[] = new Position($nodes->getPosition()->getX(), $nodes->getPosition()->getY(), $nodes->getPosition()->getZ());
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
        $tmpPosition = [];

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

            for ($i = 0; $i < count($this->diagonalMovePoints); $i++) {
                $tmpPosition = $current->getPosition()->add($this->diagonalMovePoints[$i]);
                $isFinalMove = ($tmpPosition->getX() === $end->getX() && $tmpPosition->getY() === $end->getY());

                if ($this->isValidStep($roomObject, $current->getPosition(), $tmpPosition, $isFinalMove, $isRetry)) {
                    try {
                        if (!isset($map[$tmpPosition->getX()][$tmpPosition->getY()])) {
                            $node = new PathfinderNode($tmpPosition);
                            $map[$tmpPosition->getX()][$tmpPosition->getY()] = $node;
                        } else {
                            $node = $map[$tmpPosition->getX()][$tmpPosition->getY()];
                        }
                    } catch (\Exception $ignored) {
                        continue;
                    }

                    if (!$node->isInClosed()) {
                        $diff = 0;
                        $cost = $current->getCost() + $diff + $node->getPosition()->getDistanceTo($end);

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

    public function isValidStep(RoomObject $object, Position $from, Position $to, bool $isLastStep, bool $isRetry): bool
    {
        if($object instanceof RoomEntity) {
            return $object->getRoom()->getMappingComponent()->isValidEntityStep($object, $from, $to, $isLastStep, $isRetry);
        }

        return $object->getRoom()->getMappingComponent()->isValidStep($object, $from, $to, $isLastStep, $isRetry);
    }
}
