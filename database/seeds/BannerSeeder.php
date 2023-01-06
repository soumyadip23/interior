<?php

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::insert([
            ["title"=>"This is Banner 1","image" => 'b1.jpg',"description"=>"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.","redirect_link"=>"https://phoneflix.in/","status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["title"=>"This is Banner 2","image" => 'b2.jpg',"description"=>"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.","redirect_link"=>"https://phoneflix.in/","status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
            ["title"=>"This is Banner 3","image" => 'b3.jpg',"description"=>"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.","redirect_link"=>"https://phoneflix.in/","status" => 1, "created_at" => '2020-07-25 21:30:58', "updated_at" => '2020-07-25 21:30:58'],
        ]);
    }
}
