<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '3',
            'shop_id' => '1',
            'date' => '2025-03-30',
            'time' => '11:00',
            'number' => 2,
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'shop_id' => '1',
            'date' => '2025-03-30',
            'time' => '11:00',
            'number' => 2,
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'shop_id' => '1',
            'date' => '2025-03-30',
            'time' => '11:00',
            'number' => 2,
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'shop_id' => '1',
            'date' => '2025-03-30',
            'time' => '11:00',
            'number' => 2,
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'shop_id' => '2',
            'date' => '2025-03-30',
            'time' => '11:00',
            'number' => 2,
        ];
        DB::table('reservations')->insert($param);
    }
}
