<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day06 extends Solution  implements Day
{
    public const day = 6;
    public const year = 2023;
    public const title = 'Day 6: Wait For It';

    protected array $data = [];

    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
        $this->input->each(function ($line){
            [$type, $list] = explode(':', $line);
            $this->data[$type] = preg_split('/\s+/', trim($list));
        });
    }

    public function part1()
    {
        return $this->getWays($this->data['Time'], $this->data['Distance']);
    }

    public function part2()
    {
        return $this->getWays([join($this->data['Time'])], [join($this->data['Distance'])]);
    }

    public function getWays($times, $distances): int
    {
        $ways = 1;

        for ($i = 0; $i < count($times); ++$i) {
            $record = $distances[$i];
            $durationsToBeat = 0;

            for ($j = 1; $j <= $times[$i]; ++$j) {
                $distance = $j + (($times[$i] - $j) * ($j - 1));

                if ($distance >= $record) {
                    ++$durationsToBeat;
                }
            }

            $ways *= $durationsToBeat;
        }

        return $ways;
    }
}