<?php

namespace App\Services\AoC\Solutions\Y2023;

use App\Services\AoC\Interfaces\Day;
use App\Services\AoC\Solutions\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Day02 extends Solution  implements Day
{
    public const day = 2;
    public const year = 2023;
    public const title = 'Day 2: Cube Conundrum';

    private int $total = 0;
    private int $maxRed = 12;
    private int $maxGreen = 13;
    private int $maxBlue = 14;
    public function __construct(?Collection $input = null)
    {
        parent::__construct($input);

    }

    public function part1()
    {
        $this->getGames()->each(function($game, int $gameId){
            $possible = true;
            $game->each(function ($sample) use (&$possible) {
                $red = 0;
                $green = 0;
                $blue = 0;
                $colors = explode(separator: ', ', string: $sample);
                foreach ($colors as $color){
                    if (strpos($color, 'red') !== false) {
                        $red = (int) (str_replace('red', '', $color));
                        continue;
                    }

                    if (strpos($color, 'green') !== false) {
                        $green = (int) (str_replace('green', '', $color));
                        continue;
                    }

                    if (strpos($color, 'blue') !== false) {
                        $blue = (int) (str_replace('blue', '', $color));
                    }
                }
                if ($red > $this->maxRed || $green > $this->maxGreen || $blue > $this->maxBlue) {
                    $possible = false;
                }
            });
            if ($possible) {
                $this->total += $gameId;
            }
        });
        return $this->total;
    }

    public function part2()
    {
        $total = 0;
        foreach ($this->input as $line) {
            $totalRed = 0;
            $totalGreen = 0;
            $totalBlue = 0;

            $parsing = explode(':', $line);
            $games = explode(';', $parsing[1]);

            foreach ($games as $game) {

                foreach (explode(',', $game) as $color) {
                    if (strpos($color, 'red') !== false) {
                        $red = (int) (str_replace('red', '', $color));

                        if ($red > $totalRed) {
                            $totalRed = $red;
                        }
                    }

                    if (strpos($color, 'green') !== false) {
                        $green = (int) (str_replace('green', '', $color));

                        if ($green > $totalGreen) {
                            $totalGreen = $green;
                        }
                    }

                    if (strpos($color, 'blue') !== false) {
                        $blue = (int) (str_replace('blue', '', $color));

                        if ($blue > $totalBlue) {
                            $totalBlue = $blue;
                        }
                    }
                }
            }

            $total += $totalRed * $totalGreen * $totalBlue;
        }

        return $total;
    }

    private function getGames(): Collection
    {
        $games = collect();
        $this->input->each(function(string $line) use ($games){
            list($game, $samples) = explode(separator: ': ', string: $line);
            $gameId = (int) Str::replace(search:'Game ', replace: '', subject: $game);
            $samples = collect(explode(separator: '; ',string: $samples));
           $games->put($gameId, $samples);
        });
       return $games;

    }
}