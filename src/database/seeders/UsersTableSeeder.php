<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'authority' => '管理者',
            'name' => '長谷川',
            'email' => 'hasegawa@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
        DB::table('users')->insert($param);
        $param = [
            'authority' => '代表者',
            'name' => '山本',
            'email' => 'yamamoto@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('yamamoto'),
            'remember_token' => Str::random(10),
        ];
        DB::table('users')->insert($param);
        $param = [
            'authority' => '利用者',
            'name' => '中川',
            'email' => 'nakagawa@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('nakagawa'),
            'remember_token' => Str::random(10),
        ];
        DB::table('users')->insert($param);
    }
}
