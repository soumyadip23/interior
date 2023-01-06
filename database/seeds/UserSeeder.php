<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ["name"=>"Test User","mobile" => '1234567890',"email"=>"test@testmail.com","otp"=>"1234","password"=>"","country"=>"","city"=>"","address"=>"","gender"=>"Male","date_of_birth"=>"1990-01-01","is_verified"=>"1","status"=>"1","is_deleted"=>"0","otp"=>"1234","remember_token" => '12334566677', "created_at" => '2021-07-25 21:30:58', "updated_at" => '2021-07-25 21:30:58']

        ]);
    }
}
