<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day04 extends Solution  implements Day
{
    public const day = 4;
    public const year = 2023;
    public const title = 'Day 4: Scratchcards';


    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
    }

    public function part1()
    {
        $total = 0;

        foreach ($this->input as $line) {

            $parsing = explode(':', $line);

            $series = explode('|', $parsing[1]);
            $winning = explode(' ', $series[0]);
            $actual = explode(' ', $series[1]);

            $winning = array_filter($winning, function ($value) {
                return is_numeric($value);
            });

            $actual = array_filter($actual, function ($value) {
                return is_numeric($value);
            });

            $cardValue = 0;

            foreach ($actual as $number) {
                if (in_array($number, $winning)) {

                    if ($cardValue === 0) {
                        $cardValue = 1;
                    } else {
                        $cardValue *= 2;
                    }
                }
            }

            $total += $cardValue;
        }

        return $total;
    }

    public function part2()
    {
        $counter = 1;

        $scratchCards = [];

        foreach ($this->input as $line) {

            if (!isset($scratchCards[$counter])) {
                $scratchCards[$counter] = 0;
            }

            $scratchCards[$counter] += 1;

            $parsing = explode(':', $line);
            $series = explode('|', $parsing[1]);
            $winning = explode(' ', $series[0]);
            $actual = explode(' ', $series[1]);

            $winning = array_filter($winning, function ($value) {
                return is_numeric($value);
            });

            $actual = array_filter($actual, function ($value) {
                return is_numeric($value);
            });

            $cardWon = 0;

            foreach ($actual as $number) {
                if (in_array($number, $winning)) {
                    $cardWon += 1;
                }
            }

            $cardValue = 1;

            if (isset($scratchCards[$counter])) {
                $cardValue = $scratchCards[$counter];
            }

            for ($i = 1; $i <= $cardWon; $i++) {

                if (!isset($scratchCards[$i + $counter])) {
                    $scratchCards[$i + $counter] = 0;
                }

                $scratchCards[$i + $counter] += $cardValue;
            }

            $counter++;
        }

        return array_sum($scratchCards);
    }
}