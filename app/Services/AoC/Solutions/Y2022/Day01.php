<?php

namespace App\Services\AoC\Solutions\Y2022;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Day01 extends Solution implements Day
{
    public const day = 1;
    public const year = 2022;

    public function part1()
    {
        $totalCaloriesCarried = $this->getTotalCaloriesCarried();
        return max($totalCaloriesCarried);
    }

    public function part2()
    {
        $totalCaloriesCarried = $this->getTotalCaloriesCarried();
        rsort($totalCaloriesCarried);
        return ($totalCaloriesCarried[0] ?? 0) + ($totalCaloriesCarried[1] ?? 0) + ($totalCaloriesCarried[2] ?? 0);
    }

    /**
     * @return array
     */
    public function getTotalCaloriesCarried(): array
    {
        $carried = [[]];
        $elfId = 0;
        foreach ($this->input as $calories) {
            if ($calories == '') {
                ++$elfId;
                continue;
            }
            $carried[$elfId][] = intval($calories);
        }

        $totalCaloriesCarried = array_map(array_sum(...), $carried);
        return $totalCaloriesCarried;
    }
}