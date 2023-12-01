<?php

namespace App\Console\Commands;

use App\Services\AoC\Solutions\Y2022\Day01;
use Illuminate\Console\Command;

class RunDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:solve {year : The year of the puzzle} {day : The day of the puzzle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Solve an AoC Puzzle for a given day.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $year = $this->argument('year');
        $day = $this->argument('day');
        $class = sprintf('App\Services\AoC\Solutions\Y%d\Day%02d',
        $year, $day);
        $day = new $class();
        $this->info('Part 1: ' . $day->part1());
        $this->info('Part 2: ' . $day->part2());

        return Command::SUCCESS;
    }
}
