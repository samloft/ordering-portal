<?php

namespace App\Console\Commands;

use App\Traits\MutatesTinkerCommand;
use Laravel\Tinker\Console\TinkerCommand as BaseCommand;

class TinkerCommand extends BaseCommand
{
    use MutatesTinkerCommand;
}
