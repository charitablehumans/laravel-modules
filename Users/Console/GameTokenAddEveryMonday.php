<?php

namespace Modules\Users\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Modules\Options\Models\Options;
use Modules\Users\Models\Users;

class GameTokenAddEveryMonday extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'users:game-token-add-every-monday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add game token in users every monday.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $option = Options::firstByName('Modules/Users/Console/GameTokenAddEveryMonday');

        if ($option && $option->value > 0) {
            if ($users = Users::all()) {
                foreach ($users as $user) {
                    $user->game_token += $option->value;
                    $user->userGameTokenHistoryCreate(['type' => 'Modules/Users/Console/GameTokenAddEveryMonday']);
                    $this->info('Add game_token: '.$option->value.', from game_token: '.$user->getOriginal('game_token').', to game_token: '.$user->game_token.', on user_id: '.$user->id);
                    $user->save();
                }
            }
        }
    }
}
