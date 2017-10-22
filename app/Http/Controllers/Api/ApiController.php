<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OpenGraphParser\OpenGraphParser;

class ApiController extends Controller
{
    public function og()
    {
        $answer = [];
        $answer['code'] = 0;
        $url = \request()->post('url');
        if (!empty($url)) {
            $subject = OpenGraphParser::Http();
            try {
                $card = $subject->parse($url)->getOpenGraphFields();
            } catch(Exception $ex) {
                $answer['code'] = 2;
                $answer['text'] = 'Нельзя распарсить страницу';
                return response()->json($answer);
            }
            if(!empty($card)) {
                $schema = parse_url($url, PHP_URL_SCHEME);
                $host = parse_url($url, PHP_URL_HOST);
                $card['short_url'] = $schema . '://' . $host . '/';
                $answer['text'] = view('common.og_card', compact('card'))->render();
                $answer['code'] = 1;
            } else {
                $answer['code'] = 2;
                $answer['text'] = 'На странице нет информации об open graph';
            }
        } else {
            $answer['text'] = 'Не передан url';
        }
        return response()->json($answer);
    }


    public function pay()
    {
        $answer = [];
        $answer['code'] = 0;

        // проверка входных данных request()

        $settings = \App\Settings::first();
        // $settings->editor_bill - лицевой счет редактора

        // подключение к ЯД

        // перевод на другой счет

        // ответ - результат передачи


        return response()->json($answer);
    }
}
