<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Http\Controllers\YandexController;

set_time_limit(0);

class ParserController extends Controller
{
    /**
     * Переводим время
     * 
     * @param string $data
     * 
     * @return int 
     */
    function strtotime(string $data) : int
    {
        $rus = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
        $eng = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $replace = str_replace($rus, $eng, $data);
        
        return strtotime($replace);
    }

    /**
     * Получаем список отзывов Yell
     * 
     * @param int $company
     * @param int $offset
     * 
     * @return void
     */
    public function getYell(int $company, int $offset = 1) 
    {
        $response = Http::withHeaders([
                'x-requested-with'  => 'XMLHttpRequest',
                'User-Agent'        => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Mobile Safari/537.36',
                'Accept'            => 'application/json'
            ])
            ->get('https://www.yell.ru/company/reviews/', [
                'id'    => $company,
                'page'  => $offset,
                'sort'  => 'recent',
                'limit' => 100
            ]);

        $ret = json_decode($response->body(), true);

        if ($ret['success'])
            return $ret['result'];

        return false;
    }

    /**
     * Обрабатываем полученые данные
     * 
     * @param integer $id - ID площадки Yell
     * 
     * @return array
     */
    public function parsCompanyYell(int $id) : array
    {
        $offset = 1;
        $more   = true;
        $ret    = [];

        while( $more ) {
            $getReviews = $this->getYell($id, $offset);
            $more       = (bool) $getReviews['has_more'];

            foreach ($getReviews['reviews'] as $value) {
                $count = DB::table('reviews')
                    ->where([
                        'review_id' => $value['id'],
                        'provider'  => 'yell'
                     ])
                    ->count();
            
                if ($count > 0) continue;
                
                array_push($ret, $value);
            }

            $offset++;
            sleep(1);
        }

        return $ret;
    }

    /**
     * Записываем полученые отзывы с Yell
     * 
     * @return object - $this
     */
    public function insertYell() : object
    {
        $getCompany = DB::table("company")
                        ->where('yell_id', '!=', null)
                        ->get();

        foreach($getCompany as $row) {
            $pars           = $this->parsCompanyYell($row->yell_id);
            $insertArray    = [];

            foreach ($pars as $val)
                array_push($insertArray, [
                    'company'   => $row->id,
                    'review_id' => $val['id'],
                    'provider'  => 'yell',
                    'rating'    => $val['score'],
                    'user'      => $val['author']['name'],
                    'text'      => $val['text'],
                    'date'      => $this->strtotime($val['date'])
                ]);

            DB::table('reviews')->insert($insertArray);
        }

        return $this;
    }

    /**
     * Получаем список отзывов Flamp
     * 
     * @param string $url
     * 
     * @return mixed
     */
    public function getFlamp($url)
    {
        $accept = json_encode([
            'user'  => [
                "fields"            => "id,name,url,image,reviews_count,sex",
                "official_answer"   => (object) [],
                "photos"            => (object) []
            ]
        ]);

        $response = Http::withToken('2b93f266f6a4df2bb7a196bb76dca60181ea3b37')
            ->withHeaders([
                'User-Agent'        => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Mobile Safari/537.36',
                'Accept'            => "scopes=$accept;application/json"
            ])
            ->get($url);

        $ret = json_decode($response->body(), true);
    
        if ($ret['status'] === "success")
            return [
                'next'      => isset($ret['next_link']) ? $ret['next_link'] : false,
                'reviews'   => $ret['reviews']
            ];

        return false;
    }

    /**
     * Обрабатываем полученые данные Flamp
     * 
     * @param integer $id - ID компании на площадке Flamp
     * 
     * @return array
     */
    public function parsCompanyFlamp(int $id) : array
    {
        $url = "https://flamp.reviews/api/2.0/filials/$id/reviews?limit=5";
        $ret = [];

        while ( $url ) {
            $getReviews = $this->getFlamp($url);
            $url        = $getReviews['next'];

            foreach ($getReviews['reviews'] as $val) {
                $count = DB::table('reviews')
                    ->where([
                        'review_id' => $val['id'],
                        'provider'  => 'flamp'
                     ])
                    ->count();

                if ($count > 0) continue;

                array_push($ret, $val);
            }

            sleep(1);
        }

        return $ret;
    }

    /**
     * Записываем отзывы c Flampa
     * 
     * @return object - $this
     */
    public function insertFlamp() : object
    {
        $insertArray = [];
        $getCompany = DB::table("company")
                        ->where('flamp_id', '!=', null)
                        ->get();

        foreach($getCompany as $row) {
            $getReviews = $this->parsCompanyFlamp($row->flamp_id);

            foreach ($getReviews as $key => $val) {
                array_push($insertArray, [
                    'company'   => $row->id,
                    'review_id' => $val['id'],
                    'provider'  => 'flamp',
                    'rating'    => $val['rating'],
                    'user'      => $val['user']['name'],
                    'text'      => $val['text'],
                    'date'      => strtotime($val['date_created'])
                ]);
            }
        }

        DB::table('reviews')->insert($insertArray);

        return $this;
    }

    /**
     * Получаем данные с яндекса
     * 
     * @param integer $id - ID компании на площадке yandex maps
     * 
     * @return array
     */
    public function parseCompanyYandex(int $id) : array
    { 
        $yandex     = new YandexController();
        $ret        = $yandex->getAllReviews($id);
        $array      = [];

        foreach ($ret as $value) {
            $count = DB::table('reviews')
                    ->where([
                        'review_id' => $value['reviewId'],
                        'provider'  => 'yandex'
                     ])
                    ->count();

            if ( $count > 0 ) continue;
            
            array_push($array, $value);
        }

        return $array;
    }

    /**
     * Записываем отзывы с яндекса
     * 
     * @return object - $this
     */
    public function insertYandex() : object
    {
        $insertArray    = [];
        $getCompany     = DB::table("company")
            ->where('yandex_id', '!=', null)
            ->get();

        foreach($getCompany as $row) {
            $getReviews = $this->parseCompanyYandex($row->yandex_id);

            foreach($getReviews as $val) { 
                array_push($insertArray, [
                    'company'   => $row->id,
                    'review_id' => $val['reviewId'],
                    'provider'  => 'yandex',
                    'rating'    => $val['rating'],
                    'user'      => isset($val['author']) ? $val['author']['name'] : 'Аноним',
                    'text'      => $val['text'],
                    'date'      => strtotime($val['updatedTime'])
                ]);
            }
        } 

        DB::table('reviews')->insert($insertArray);

        return $this;
    }

    /**
     * Обновление рейтинка компаний
     * 
     * @return object $this
     */
    public function update()
    {
        $getCompany = DB::table("company")->get();

        foreach ($getCompany as $val) {
            $get = DB::table('reviews')
                ->select(
                    DB::raw('( SUM(rating) / COUNT(*) ) as rating'),
                )
                ->where(['company' => $val->id, 'status' => 'active'])
                ->first();
            
            $rating = $get->rating !== null ? (round($get->rating * 10) / 10) : 0;
            DB::table('company')
                ->where('id', $val->id)
                ->update(['rating_reviews' => $rating]);
        }

        return $this;
    }
    
    /**
     * Парсим отзывы yell
     * 
     * @return void
     */
    public function parserYell()
    {
        $this->insertYell()->update();
        return response('OK', 200);
    }

    /**
     * Парсим отзывы yell
     * 
     * @return void
     */
    public function parserFlamp() 
    { 
        $this->insertFlamp()->update();
        return response('OK', 200);
    }

    /**
     * Парсим отзывы Yandex
     * 
     * @return void
     */
    public function parserYandex()
    {
        $this->insertYandex()->update();
        return response('OK', 200);
    }
}
