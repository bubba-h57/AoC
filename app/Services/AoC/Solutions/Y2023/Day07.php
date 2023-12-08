<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day07 extends Solution  implements Day
{
    public const day = 7;
    public const year = 2023;
    public const title = 'Day 7: Camel Cards';
    public const STRENGTH = [
        'A' => 14,
        'K' => 13,
        'Q' => 12,
        'J' => 11,
        'T' => 10,
        '9' => 9,
        '8' => 8,
        '7' => 7,
        '6' => 6,
        '5' => 5,
        '4' => 4,
        '3' => 3,
        '2' => 2,
        '1' => 1,
    ];

    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
    }

    public function part1()
    {
        $ans = 0;

        $data = array_map(fn ($e) => explode(' ', $e), $this->input->toArray());

        uasort($data, function ($a, $b) {
            $evalA = $this->evaluate($a[0]);
            $evalB = $this->evaluate($b[0]);

            if ($evalB === $evalA) {
                return $this->strongest($a[0], $b[0]);
            }

            return $evalA <=> $evalB;
        });

        $rank = 1;

        foreach ($data as $d) {
            $ans += $rank * $d[1];
            ++$rank;
        }

        return $ans;
    }

    public function part2()
    {
        $ans = 0;

        $data = array_map(fn ($e) => explode(' ', $e), $this->input->toArray());

        uasort($data, function ($a, $b) {
            $evalA = $this->evaluate($a[0], true);
            $evalB = $this->evaluate($b[0], true);

            if ($evalB === $evalA) {
                return $this->strongest($a[0], $b[0], true);
            }

            return $evalA <=> $evalB;
        });

        $rank = 1;

        foreach ($data as $d) {
            $ans += $rank * $d[1];
            ++$rank;
        }

        return $ans;
    }

    private function evaluate(string $cards, $part2 = false): int
    {
        $count = count_chars($cards, 1);
        $n = 0;

        if ($part2 && isset($count['74'])) {
            $n = $count['74'];
            unset($count['74']);
        }

        rsort($count);

        if ($part2 && $n > 0) {
            if (!isset($count[0])) {
                $count = [0];
            }

            $count[0] += $n;
        }

        if (1 === count($count)) {
            return 6;
        }

        if (2 === count($count)) {
            if (4 === $count[0]) {
                return 5;
            }
            if (3 === $count[0]) {
                return 4;
            }
        }

        if (3 === count($count)) {
            if (3 === $count[0]) {
                return 3;
            }

            if (2 === $count[0]) {
                return 2;
            }
        }

        if (4 === count($count)) {
            return 1;
        }

        return 0;
    }

    private function strongest($cardsA, $cardsB, $part2 = false): int
    {
        if ($part2) {
            $cardsA = str_replace('J', '1', $cardsA);
            $cardsB = str_replace('J', '1', $cardsB);
        }

        for ($i = 0; $i < strlen($cardsA); ++$i) {
            if (self::STRENGTH[$cardsA[$i]] > self::STRENGTH[$cardsB[$i]]) {
                return 1;
            }

            if (self::STRENGTH[$cardsA[$i]] < self::STRENGTH[$cardsB[$i]]) {
                return -1;
            }
        }

        return 0;
    }
}