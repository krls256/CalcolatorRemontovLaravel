<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Videos extends Controller
{   
    /**
     * Парсим видео с youtube
     */
    public static function parseYoutube(string $id)
    {
        $pars = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'part'          => 'snippet',
            'channelId'     => $id,
            'order'         => 'date',
            'type'          => 'video',
            'maxResults'    => 50,
            'key'           => 'AIzaSyADVGKc0VXUJIkOeG-9j4YId13ffM_g-uE'
        ]);

        return json_decode( $pars->body(), true );
    }

    /**
     * 
     */
    public function setVideos()
    {
        $comnpany = DB::table('company')
            ->where('youtube', '!=', null)
            ->get();

        foreach ($comnpany as $key => $row) {
            $get = self::parseYoutube($row->youtube);
            $list = [];
          
            foreach ($get['items'] as $val) {
                $count = DB::table('videos')->where('video_id', '=', $val['id']['videoId'])->count();
                if ($count > 0 ) continue;
                 
                array_push($list, [
                    'video_id'      => $val['id']['videoId'],
                    'company_id'    => $row->id,
                    'name'          => $val['snippet']['title'],
                    'desc'          => $val['snippet']['description'],
                    'img'           => $val['snippet']['thumbnails']['medium']['url'],
                    'date'          => date('Y-m-d H:i:s', strtotime($val['snippet']['publishedAt']))
                ]);
            }

            DB::table('videos')->insert($list);
        }
    
    }

    /**
     * 
     */
    public function getPage()
    {   
        $getCompany = DB::table('company')->whereIn('id', function($query) { 
            $query->select('company_id')->from('videos');
        })->get();

        foreach ($getCompany as $val) {
            $video = DB::table('videos')->where('company_id', '=', $val->id)->get();
            $val->video = $video;
        }

        return view('video', ['companies' => $getCompany]);
    }

    /**
     * Отдаем данные о видео
     */
    public function getVideo(Request $req) 
    { 
        $valid = Validator::make($req->all(), [
            'id'    => 'required|numeric'
        ]);

         # Если данные не прошли валидацию
         if ( $valid->fails() ) { 
            return response()->json([
                'status'    => 'error',
                'type'      => 'validation',
                'message'   => $valid->errors()
            ]);
        }

        $get = DB::table('videos')
            ->where('videos.id', $req->id)
            ->join('company', 'company.id', '=', 'videos.company_id')
            ->select('videos.*', 'company.name as c_name', 'company.logo as c_logo', 'company.rating_reviews', 'company.rating_profile', 'company.url')
            ->first();
        $date = strtotime($get->date);

        $month = [
            1 => 'янв.',
            2 => 'фев.',
            3 => 'мар.',
            4 => 'апр.',
            5 => 'мая',
            6 => 'июн.',
            7 => 'июл.',
            8 => 'авг.',
            9 => 'сен.',
            10 => 'окт.',
            11 => 'ноя.',
            12 => 'дек.',
        ];

        return response()->json([
            'id'            => $get->id,
            'name'          => $get->name,
            'video_id'      => $get->video_id,
            'publishedAt'   => date("d", $date) . ' ' . $month[date("n", $date)] . ' ' . date("Y", $date) . ' г.',
            'company'       => [
                'name'          => $get->c_name,
                'logo'          => $get->c_logo,
                'rating'        => ($get->rating_reviews + $get->rating_profile)/2,
                'url'           => $get->url
            ]
        ]);
    }
}
