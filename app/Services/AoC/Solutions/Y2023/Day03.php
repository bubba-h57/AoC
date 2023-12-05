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


    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
    }

    public function part1()
    {
        $total = 0;

        $whereNumbers = [];

        foreach ($this->input as $index => $line) {
            preg_match_all('/\d+/', $line, $matches);
            $matches = $matches[0];

            $parsedLine = $line;

            foreach ($matches as $match) {

                $replaceString = str_repeat('?', strlen($match));
                $position = strpos($parsedLine, $match);

                $parsedLine = substr_replace($parsedLine, $replaceString, $position, strlen($match));
                $whereNumbers[] = [$index, $position, $match];
            }
        }

        foreach ($whereNumbers as $whereNumber) {
            $line = $whereNumber[0];
            $pos = $whereNumber[1];
            $number = $whereNumber[2];
            $length = strlen($number);

            for ($i = -1; $i <= $length; $i++) {

                $characters = [];

                if ($line - 1 >= 0 && $pos + $i >= 0 && $pos + $i < strlen($this->input[0])) {
                    $characters[] = $this->input[$line - 1][$pos + $i];
                }

                if ($pos + $i >= 0 && $pos + $i < strlen($this->input[0])) {
                    $characters[] = $this->input[$line][$pos + $i];
                }

                if ($line + 1 < count($this->input) && $pos + $i >= 0 && $pos + $i < strlen($this->input[0])) {
                    $characters[] = $this->input[$line + 1][$pos + $i];
                }

                $arrayContainsSymbol = array_filter($characters, function ($character) {
                    return !is_numeric($character) && $character !== '.';
                });

                if (!empty($arrayContainsSymbol)) {
                    $total += $number;
                    break;
                }
            }
        }

        return $total;
    }

    public function part2()
    {

    }
}