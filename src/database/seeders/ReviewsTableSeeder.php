<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
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
            'evaluation' => 5,
            'comment' => '毎日店主自ら市場等に出向き、厳選した魚介類が、お鮨をはじめとした繊細な料理に仕立てられます。また、選りすぐりの種類豊富なドリンクもご用意しております。',
        ];
        DB::table('reviews')->insert($param);
        $param = [
            'user_id' => '3',
            'shop_id' => '1',
            'evaluation' => 4,
            'comment' => '毎日店主自ら市場等に出向き、厳選した魚介類が、お鮨をはじめとした繊細な料理に仕立てられます。また、選りすぐりの種類豊富なドリンクもご用意しております。',
        ];
        DB::table('reviews')->insert($param);
        $param = [
            'user_id' => '3',
            'shop_id' => '2',
            'evaluation' => 3,
            'comment' => '毎日店主自ら市場等に出向き、厳選した魚介類が、お鮨をはじめとした繊細な料理に仕立てられます。また、選りすぐりの種類豊富なドリンクもご用意しております。',
        ];
        DB::table('reviews')->insert($param);
    }
}
