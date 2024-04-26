<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'content' => 'This is a dummy post for John Doe.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->insert([
            'user_id' => 2,
            'content' => 'This is a dummy post for Jane Doe.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
