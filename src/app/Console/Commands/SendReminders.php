<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use Carbon\Carbon;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails';

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
     * @return int
     */
    public function handle()
    {
        $reservations = Reservation::All();

        $today = Carbon::today()->format('Y-m-d');

        foreach($reservations as $reservation)
        {
            if($today == $reservation->date)
            {
                $user = User::Find($reservation->user_id);
                $shop = Shop::Find($reservation->shop_id);

                $details = [
                    'name' => $user->name,
                    'shop' => $shop->name,
                    'date' => Carbon::parse($reservation->date.$reservation->time)->format('Y年m月d日 H:i'),
                    'number' => $reservation->number,
                ];

                Mail::to($user->email)->send(new ReminderMail($details));
            }
        }

        $this->info('リマインドメールを送信しました。');
    }
}
