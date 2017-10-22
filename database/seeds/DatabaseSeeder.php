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
        DB::table('news')->delete();

        $news = new \App\News();
        $news->id = 1;
        $news->title = "news 1";
        $news->user_id = 1534534;
        $news->content = '<p>content 1</p>';
        $news->is_link = 0;
        $news->status = 0;
        $news->save();

        $news = new \App\News();
        $news->id = 2;
        $news->title = "some title";
        $news->user_id = 23423;
        $news->content = '<p>some content</p>';
        $news->is_link = 0;
        $news->status = 2;
        $news->save();

        $news = new \App\News();
        $news->id = 3;
        $news->title = "this is link";
        $news->user_id = 26456457;
        $news->content = 'http://yandex.ru/';
        $news->is_link = 1;
        $news->status = 0;
        $news->save();

        $news = new \App\News();
        $news->id = 4;
        $news->title = "this is";
        $news->user_id = 2975510;
        $news->content = '<p>awesome!</p>';
        $news->is_link = 0;
        $news->status = 1;
        $news->save();

        DB::table('settings')->delete();
        $settings = new \App\Settings();
        $settings->id = 1;
        $settings->editor_bill = "41001412662082";
        $settings->save();

        DB::table('black_lists')->delete();
        DB::table('hosts')->delete();
        $list = new \App\BlackList();
        $list->id = 1;
        $list->settings_id = 1;
        $list->list_is_host = 1;
        $list->expired_at = \Carbon\Carbon::now()->addMonth()->toDateTimeString();
        $list->save();

        $host = new \App\Host();
        $host->id = 1;
        $host->host = "rbk.ru";
        $host->black_list_id = 1;
        $host->save();
        
         $host = new \App\Host();
        $host->id = 2;
        $host->host = "sportbox.ru";
        $host->black_list_id = 3;
        $host->save();

        DB::table('words')->delete();
        $list = new \App\BlackList();
        $list->id = 2;
        $list->settings_id = 1;
        $list->list_is_host = 0;
        $list->expired_at = \Carbon\Carbon::now()->addWeek()->toDateTimeString();
        $list->save();

        $word = new \App\Word();
        $word->id = 1;
        $word->word = "Ксения";
        $word->black_list_id = 2;
        $word->save();

        $word = new \App\Word();
        $word->id = 2;
        $word->word = "Собчак";
        $word->black_list_id = 2;
        $word->save();

        $word = new \App\Word();
        $word->id = 3;
        $word->word = "Выступила";
        $word->black_list_id = 2;
        $word->save();

        DB::table('users')->delete();
        $user = new \App\User();
        $user->id = 2975510;
        $user->bill = "410013173537020";
        $user->save();
    }
}
