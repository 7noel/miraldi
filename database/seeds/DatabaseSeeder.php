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
        $this->call(UbigeoTableSeeder::class);
		$this->call(SunatTableSeeder::class);
        $this->call(AdminTableSeeder::class);
    }
}
