<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day05 extends Solution  implements Day
{
    public const day = 5;
    public const year = 2023;
    public const title = 'Day 5: If You Give A Seed A Fertilizer';

    protected array $seeds = [];
    protected array $ranges = [];

    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
        $this->parse();

    }

    public function part1()
    {
        $r = [];
        foreach ($this->seeds as $seed) {
            foreach ($this->ranges as $type) {
                foreach ($type as [$to, $from, $length]) {
                    if ($from <= $seed && $seed < ($from + $length)) {
                        $seed = $to + $seed - $from;
                        break;
                    }
                }
            }

            $r[] = $seed;
        }

        return min($r);
    }

    public function part2()
    {
        $seeds = array_map(fn ($e) => [(int) $e[0], $e[0] + $e[1] - 1], array_chunk($this->seeds, 2));

        foreach ($this->ranges as $type) {
            $nextSeeds = [];
            foreach ($type as [$to, $typeFrom, $length]) {
                $newSeeds = [];
                $typeEnd = $typeFrom + $length;
                while ($seeds) {
                    [$seedFrom, $seedEnd] = array_pop($seeds);

                    if ($seedFrom < min($seedEnd, $typeFrom)) {
                        $newSeeds[] = [$seedFrom, min($seedEnd, $typeFrom)];
                    }

                    if ($seedEnd > max($typeEnd, $seedFrom)) {
                        $newSeeds[] = [max($typeEnd, $seedFrom), $seedEnd];
                    }

                    if (max($seedFrom, $typeFrom) < min($seedEnd, $typeEnd)) {
                        $nextSeeds[] = [$to + max($seedFrom, $typeFrom) - $typeFrom, $to + min($seedEnd, $typeEnd) - $typeFrom];
                    }
                }
                $seeds = $newSeeds;
            }
            $seeds = $seeds + $nextSeeds;
        }

        return min(array_map(fn ($e) => $e[0], $seeds));
    }

    public function parse(): void
    {
        $parsed = ['seeds' => [], 'ranges' => []];

        foreach (explode("\n\n", $this->fileContent) as $i => $bloc) {
            if (0 === $i) {
                preg_match('/seeds:(?P<seeds>.*)/', $bloc, $matches);
                $parsed['seeds'] = explode(' ', trim($matches['seeds']));
                continue;
            }

            $ranges = [];
            foreach (explode("\n", $bloc) as $j => $map) {
                if (0 === $j) {
                    continue;
                }

                $range = explode(' ', $map);
                $ranges[] = $range;
            }
            $parsed['ranges'][] = $ranges;
        }

        $this->seeds = $parsed['seeds'];
        $this->ranges = $parsed['ranges'];
    }
}