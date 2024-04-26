<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    public function run()
    {
        // Dummy comment for post 1 by user Jane Doe
        DB::table('comments')->insert([
            'user_id' => 2,
            'post_id' => 1,
            'content' => 'Nice post, John!',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dummy comment for post 2 by user John Doe
        DB::table('comments')->insert([
            'user_id' => 1,
            'post_id' => 2,
            'content' => 'Thanks, Jane!',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
