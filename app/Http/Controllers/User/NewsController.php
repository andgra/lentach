<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = config('api')['viewer_id']??1;
        $news = \App\News::where('user_id', $user_id)->orderBy('created_at')->get();
        $news = $this->paginate($news, 10);
        return view('user.news_list', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $news = new \App\News(old());
        return view('user.news_create', ['news' => $news]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->all();
        if ($fields['is_link'] === "1") {
            if (!empty($fields['content_banner'])) {
                $fields['content'] = $fields['content_banner'];
            } else {
                $fields['content'] = '<a href="' . $fields['content_link'] . '" target="_blank">' . $fields['content_link'] . '</a>';
            }
        } else {
            $fields['content'] = $fields['content_full'];
        }

        $passed = true;
        $passed_hosts = true;
        $passed_words = true;
        $black_lists = \App\BlackList::all();
        foreach ($black_lists as $black_list) {
            if ($black_list->list_is_host == 1) {
                if ($fields['is_link'] === "1") {
                    $host = $black_list->host;
                    if (parse_url(mb_strtolower($fields['content_link']), PHP_URL_HOST) === mb_strtolower($host->host)) {
                        $passed_hosts = false;
                        $passed = false;
                        break;
                    }
                }
            } else {

                $words = $black_list->words;
                $passed_words = false;
                if(!$words->count())
                    continue;
                foreach ($words as $word) {
                    if (mb_strpos(mb_strtolower($fields['content']), mb_strtolower($word->word)) === FALSE) {
                        $passed_words = true;
                    }
                }
                if(!$passed_words) {
                    $passed=false;
                    break;
                }
            }
//

        }
        if ($fields['is_link'] === "0" || empty($fields['content_banner'])) {
            unset($fields['content_link']);
        }
        unset($fields['content_banner']);
        unset($fields['content_full']);

        if (!empty($fields['bill'])) {
            $bill = $fields['bill'];
        }
        unset($fields['bill']);

        $validator = Validator::make($fields, [
            'title' => 'required',
            'content' => 'required',
        ]);
        if(!$passed || $validator->fails()) {
            if(!$passed_hosts) {
                $validator->getMessageBag()->add('content', 'Указанные вами веб-ресурсы внесены в черный список приложения');
            }
            if(!$passed_words) {
                $validator->getMessageBag()->add('content', 'Указанный вами контент содержит группы слов, входящих в черный список приложения');
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $api = config('api');
        $user_id = $api['viewer_id']??1;
        if (!empty($bill)) {
            $user = \App\User::updateOrCreate(
                ['id' => $user_id],
                ['bill' => $bill]
            );
        }
        $fields['user_id'] = $user_id;
        unset($fields['_token']);
        $news = \App\News::create($fields);
        return redirect()->route('user.news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\News $news)
    {
        //dd($news);
        //$id=$id->first();
        //$id->fill(old());
        return view('user.news_edit', ['news' => $news]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
