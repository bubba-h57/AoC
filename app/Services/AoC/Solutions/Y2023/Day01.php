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
        $coordinates = $this->input->map(function (string $line){
            $numbers = str_split(string: preg_replace(
                pattern: '/[a-zA-Z]/',
                replacement: '',
                subject: $line));
            return $numbers[0] . end(array: $numbers);
        });
        return $coordinates->sum();
    }

    public function part2()
    {
        $coordinates = $this->input->map(function (string $line){
            $characters = collect(str_split(string: $line));
            $this->interpreted = '';

            $characters->each(function (string $character){
                $this->interpreted .= $character;
                $this->words->each(function (string $word, int $index) use ($character){

                    $this->interpreted = Str::replace(
                        search: $word,
                        replace: ++$index . $character,
                        subject: $this->interpreted
                    );
                });
            });

            $numbers = str_split(string: preg_replace(
                pattern: '/[a-zA-Z]/',
                replacement: '',
                subject: $this->interpreted
            ));
            return $numbers[0] . end(array: $numbers);

        });

        return $coordinates->sum();
    }
}