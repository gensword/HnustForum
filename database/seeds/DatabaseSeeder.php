<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(Artickle_statusTableSeeder::class);
        $this->call(Article_categoryTableSeeder::class);
        $this->call(ArticleTableSeeder::class);
        $this->call(User_statusTableSeeder::class);
    }
}
