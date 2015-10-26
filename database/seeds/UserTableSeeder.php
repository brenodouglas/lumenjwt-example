<?php

use Illuminate\Database\Seeder;

use App\Domain\User\Model as User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'breninho94@gmail.com',
            'password' => bcrypt('159951'),
            'admin' => true
        ]);

        User::create([
            'name' => 'douglas',
            'email' => 'bdouglasans@gmail.com',
            'password' => bcrypt('159951')
        ]);

    }
}
