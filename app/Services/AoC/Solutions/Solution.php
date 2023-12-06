<?php

namespace App\Services\AoC\Solutions;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

abstract class Solution
{
    public Collection $input;

    public function __construct(?Collection $input=null)
    {
        $this->fileContent = Storage::disk('puzzles')
            ->get(sprintf(
                    '/%d/%02d/input.txt',
                    static::year,
                    static::day
                )
            );
        $this->input = $input ?? collect(Arr::fromFile(
            $this->fileContent
        ));
    }
}