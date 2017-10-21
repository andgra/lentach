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
        $category = new \App\Category();
        $category->id = 1;
        $category->title = "Происшествия";
        $category->save();

        $category = new \App\Category();
        $category->id = 2;
        $category->title = "Экономика";
        $category->save();

        $category = new \App\Category();
        $category->id = 3;
        $category->title = "Политика";
        $category->save();

        $category = new \App\Category();
        $category->id = 4;
        $category->title = "Технологии";
        $category->save();

        $category = new \App\Category();
        $category->id = 5;
        $category->title = "Прочее";
        $category->save();
    }
}
