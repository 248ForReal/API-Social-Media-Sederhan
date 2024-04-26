<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowersSeeder extends Seeder
{
    public function run()
    {

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
