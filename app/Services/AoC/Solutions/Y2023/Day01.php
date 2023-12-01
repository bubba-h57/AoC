<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day01 extends Solution  implements Day
{
    public const day = 1;
    public const year = 2023;
    public const title = 'Day 1: Trebuchet?!';
    private Collection $words;
    private string $interpreted;

    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);
        $this->words = collect([
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine'
        ]);
    }

    public function part1()
    {
        $coordinates = $this->input->map(function ($line){
            $numbers = str_split(preg_replace('/[a-zA-Z]/', '', $line));
            return $numbers[0] . end($numbers);
        });
        return $coordinates->sum();
    }

    public function part2()
    {
        $coordinates = $this->input->map(function ($line){
            $characters = collect(str_split($line));
            $this->interpreted = '';

            $characters->each(function ($character){
                $this->interpreted .= $character;
                $this->words->each(function ($word, $index) use ($character){
                    $this->interpreted = Str::replace(
                        search: $word,
                        replace: $index + 1 . $character,
                        subject: $this->interpreted
                    );
                });
            });

            $numbers = str_split(preg_replace('/[a-zA-Z]/', '', $this->interpreted));
            return $numbers[0] . end($numbers);

        });

        return $coordinates->sum();
    }
}