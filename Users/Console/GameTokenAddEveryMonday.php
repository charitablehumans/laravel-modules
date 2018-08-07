<?php

namespace Modules\Users\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Options\Models\Options;
use Modules\Users\Models\Users;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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
        $dateNow = Carbon::now();
        $option = Options::firstByName('Modules/Users/Console/GameTokenAddEveryMonday');

        if ($option && $option->value > 0) {
            if ($dateNow->isMonday()) {
                $createdAt = $dateNow->toDateString();
            } else {
                $createdAt = $dateNow->previous(Carbon::MONDAY)->toDateString();
            }

            if ($users = Users::whereDate('created_at', '<', $createdAt)) {
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
