<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day08 extends Solution  implements Day
{
    public const day = 8;
    public const year = 2023;
    public const title = 'Day 8: Haunted Wasteland';

    private Collection $directions;
    private Collection $nodes;

    private string $currentNode = 'AAA';
    private string $destinationNode = 'ZZZ';

    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
        $this->directions = collect();
        $this->nodes = collect();
        $this->init();
    }

    public function part1()
    {
        $steps = 0;
        $directionIndex = 0;
        while ($this->currentNode !== $this->destinationNode){

            // if we reach the end, loop back around.
            if ($directionIndex === $this->directions->count()){
                $directionIndex = 0;
            }

            $direction = $this->directions->get($directionIndex);
            $this->currentNode = $this->nodes->get($this->currentNode)[$direction];
            $directionIndex++;
            $steps++;
        }
        return $steps;
    }

    public function part2()
    {

        $startingPoints = $this->nodes->filter(function ($neighbors, $node){
            return $node[-1] === 'A';
        });

        $occurrences = [];

        foreach ($startingPoints as $startingPoint => $neighbors) {

            $currentNode = $startingPoint;
            $steps = 0;
            $directionIndex = 0;

                while ($currentNode[-1] !== 'Z') {
                    if ($directionIndex === $this->directions->count()) {
                        $directionIndex = 0;
                    }

                    $direction = $this->directions->get($directionIndex);
                    $currentNode = $neighbors[$direction];

                    $directionIndex++;
                    $steps++;
                }

                $occurrences[] = $steps;
            }

            $temp = 1;

            foreach ($occurrences as $occurrence) {
                $temp = gmp_lcm($temp, $occurrence);
            }

            return $temp;
    }

    private function init(): void
    {
        $this->directions = collect(str_split($this->input->shift(2)->shift()));
        $this->input->each(function ($line){
            [$node, $neighbors] = explode('=', $line);
            $node = trim($node);
            $neighbors = explode( ', ', trim($neighbors, ' \n\r\t\v\x00)('));
            $this->nodes->put($node, [
                'L' => $neighbors[0],
                'R' => $neighbors[1]
            ]);
        });
    }
}