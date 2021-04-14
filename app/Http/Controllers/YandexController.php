<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class YandexController extends Controller
{
    protected $client;
    protected $csrf;

    function __construct() 
    { 
        $this->config();
        $this->getCsrt();
    }

    /**
     * Создаем объект подключения к яндекс
     * 
     * @return object 
     */
    private function config() : object
    { 
        $this->client = new Client([
            'base_url'          => 'https://yandex.ru',
            'cookies'           => true,
            'decode_content'    => true,
            'allow_redirects'   => true,
            'headers'           => [
                'host'          => 'yandex.ru',
                'User-Agent'    => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Mobile Safari/537.36'
            ]
        ]);

        return $this;
    }

    /**
     * Устанавливаем cookis и токен
     * 
     * @return void
     */
    private function getCsrt() : void
    {
        $request    = $this->client->get('https://yandex.ru/maps/api/business/fetchReviews');
        $getContent = $request->getBody()->getContents();
        $respons    = json_decode($getContent);

        $this->csrf = $respons->csrfToken;
    }

    /**
     * Получаем данные об отзывах
     * 
     * @param int $shopID   - ID Магазина
     * @param int $page     - Страница
     * @param int $offset   - Количество отзывов за раз
     * 
     * @return array
     */
    private function getData ( int $shopID, int $page = 1, int $offset = 50 ) 
    {   
        $get = $this->client->post("https://yandex.ru/maps/api/business/fetchReviews", [
            'query' => [
                'businessId'    => $shopID,
                'csrfToken'     => $this->csrf,
                'page'          => $page,
                'pageSize'      => $offset,
                'ajax'          => 1
            ]
        ]);
    
        $response = $get->getBody()->getContents();
        return json_decode($response, true)['data'];
    }

    /**
     * Получаем все 
     * 
     * @param int $shopID   - ID Магазина
     * @param int $page     - Страница
     * @param int $offset   - Количество отзывов за раз
     * 
     */
    public function getReviews( int $shopID, int $page, int $offset = 50) : array
    { 
        $get = $this->getData($shopID, $page, $offset);

        return $get['reviews'];
    }

    /**
     * Получаем отзывы
     * 
     * @param int $shopID - ID Магазина
     * 
     * @return array
     */
    public function getAllReviews( int $shopID ) : array
    {  
        $reviews = [];
        $current = $this->getData($shopID);
    
        while ( $current['params']['page'] <= $current['params']['totalPages']) 
        {
            $reviews = array_merge($reviews, (array) $current['reviews']);
            $current = $this->getData($shopID, $current['params']['page']+1);

            sleep(2);
        }

        return $reviews;
    }
    
}
