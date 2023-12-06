<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day03 extends Solution  implements Day
{
    public const day = 3;
    public const year = 2023;
    public const title = 'Day 3: Gear Ratios';

    public const DIRECTIONS = [
        [-1, -1], [-1, 0], [-1, 1],
        [0, -1],             [0, 1],
        [1, -1], [1, 0], [1, 1],
    ];

    private array $validNumbers = [];
    private array $gears = [];
    private array $grid = [];

    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
        $this->grid = $this->parse($this->input->toArray());
        $this->init();
    }


    protected function init(): void
    {
        $number = '';
        $symbolCoordinates = [];

        foreach ($this->grid as $x => $row) {
            foreach ($row as $y => $cell) {
                if (is_numeric($cell)) {
                    $number .= $cell;
                    $symbolCoordinates = $this->getSymbol($x, $y) ?: $symbolCoordinates;

                    if ($y < count($row) - 1) {
                        continue;
                    }
                }

                if (!empty($number) && $symbolCoordinates) {
                    $this->validNumbers[] = (int) $number;

                    if ($this->isGear($symbolCoordinates)) {
                        $gearIndex = implode('|', $symbolCoordinates);
                        $this->gears[$gearIndex][] = (int) $number;
                    }
                }

                $symbolCoordinates = [];
                $number = '';
            }
        }
    }

    public function part1(): int
    {
        return array_sum($this->validNumbers);
    }

    public function part2(): int
    {
        return array_reduce(
            array_filter(
                $this->gears,
                fn ($numbers) => count($numbers) > 1
            ),
            fn ($carry, $numbers) => $carry + array_product($numbers));
    }

    private function parse(array $data): array
    {
        return array_map(fn ($line) => str_split($line), $data);
    }

    private function getSymbol(int $x, int $y): array
    {
        foreach (self::DIRECTIONS as [$dx, $dy]) {
            if (!isset($this->grid[$x + $dx][$y + $dy])) {
                continue;
            }

            if ('.' === $this->grid[$x + $dx][$y + $dy]) {
                continue;
            }

            if (is_numeric($this->grid[$x + $dx][$y + $dy])) {
                continue;
            }

            return [$x + $dx, $y + $dy];
        }

        return [];
    }

    private function isGear(array $coordinates): bool
    {
        [$x, $y] = $coordinates;

        return '*' === $this->grid[$x][$y];
    }
}