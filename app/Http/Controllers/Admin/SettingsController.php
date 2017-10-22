<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Settings;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        $settings=$settings->first();
        $settings->fill(old());

        $s1 = clone $settings;
        $host_lists = $s1
            ->lists()
            ->where('list_is_host',1)
            ->get();
        $s1 = clone $settings;
        $word_lists = $s1->lists()->where('list_is_host',0)->get();

        return view('admin.settings_edit', compact('settings','host_lists','word_lists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {

        $settings->editor_bill=request()->get('editor_bill');
        $settings->save();

        return redirect()->back()->with('done', 'Настройки успешно изменены!');
    }

    public function ajax() {

        $answer = [];
        $answer['code'] = 0;
        $answer['text'] = 'Неизвестный тип запроса';
        $type = request()->get('type');
        switch ($type) {
            case 'save':
                $list_id = \request()->get('list_id');
                $type_list = \request()->get('type_list');
                $title = \request()->get('title');
                $expired_at = \request()->get('expired_at');
                if (!$type_list || !$title) {
                    $answer['text'] = 'Не все поля переданы';
                } else {
                    if($list_id) {
                        $black_list=\App\BlackList::find($list_id);
                    } else {
                        $black_list=new \App\BlackList();
                    }
                    $black_list->expired_at=(new \Carbon\Carbon($expired_at))->toDateString();
                    if($type_list==='host') {
                        $black_list->list_is_host=1;
                        $black_list->save();
                        if($list_id) {
                            $host=\App\Host::find($black_list->host->id);
                        } else {
                            $host=new \App\Host();
                        }
                        $host->host=$title;
                        $host->black_list_id=$black_list->id;
                        $host->save();
                    } else {
                        $black_list->list_is_host=0;
                        $black_list->save();
                        \App\Word::where('black_list_id', $black_list->id)->delete();
                        foreach(explode(';',$title) as $word_title) {
                            $word=new \App\Word();
                            $word->word=$word_title;
                            $word->black_list_id=$black_list->id;
                            $word->save();
                        }
                    }

                    $answer['code'] = 1;
                }
                break;
            case 'delete':
                $news_id = \request()->get('news_id');
                if (!$news_id) {
                    $answer['text'] = 'Не все поля переданы';
                } else {
                    $news = \App\News::find($news_id);
                    $news->status=2;
                    $news->save();

                    $answer['code'] = 1;
                    $answer['text'] = $news;
                }
                break;
        }

        return response()->json($answer);
    }
}
