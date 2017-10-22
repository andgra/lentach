<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \YandexMoney\API;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = \App\News::orderBy('created_at')->get();
        $news = $this->paginate($news, 3);
        return view('admin.news_list', compact('news'));
    }

    public function payment()
    {
        //$news_id=request()->get('news_id');
        $news_id=4;
        $news=\App\News::find($news_id);
        $to=$news->user->bill;
        $code=request()->get('code');
        $client_id = 'CE12743552CF3516FB69666CCE9D9FEF73A346077B4FDF74CF02D72F68FAF5B6';
        $redirect_uri = route('payment.redirect');
        $from = \App\Settings::first()->editor_bill;
        $amount_due =request()->get('amount_due');
        $amount_due=10;
        $comment = "за новость с заголовком ".$news->title;
        echo "<pre>";

        $access_token_response = API::getAccessToken($client_id, $code, $redirect_uri, $client_secret=NULL);
        if(property_exists($access_token_response, "error")) {
            $scope = ['account-info operation-history payment.to-account("'.$to.'")'];
            $auth_url = API::buildObtainTokenUrl($client_id, $redirect_uri, $scope);
            header('Location: '.$auth_url);
            exit;
        }
        $access_token = $access_token_response->access_token;

        $api = new API($access_token);

        // get account info
        $account_info = $api->accountInfo();
        print_r($account_info);

        $request_payment = $api->requestPayment(array(
            "pattern_id" => "p2p",
            "to" => $to,
            "amount_due" => $amount_due,
            "comment" => $comment,
            "message" => "",
            "test_payment" => true
        ));
        print_r($request_payment);
        return view('layouts.base');
    }

    public function redirect() {
        $code=request()->get('code');
        return redirect()->route('payment')->with(compact('code'));
    }

    public function ajax()
    {
        $answer = [];
        $answer['code'] = 0;
        $answer['text'] = 'Неизвестный тип запроса';
        $type = request()->get('type');
        switch ($type) {
            case 'accept':
                $news_id = \request()->get('news_id');
                if (!$news_id) {
                    $answer['text'] = 'Не все поля переданы';
                } else {
                    $news = \App\News::find($news_id);
                    $news->status=1;
                    $news->save();

                    $answer['code'] = 1;
                    $answer['text'] = $news;
                }
                break;
            case 'decline':
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
