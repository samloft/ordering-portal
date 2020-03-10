<?php

namespace App\Console\Commands;

use Laravel\Tinker\Console\TinkerCommand as BaseCommand;
use App\Traits\MutatesTinkerCommand;

class TinkerCommand extends BaseCommand
{
    use MutatesTinkerCommand;
}
