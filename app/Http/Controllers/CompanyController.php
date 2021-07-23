<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\View\View;


class CompanyController extends Controller
{

    private $reviewShow = 10; # Сколько отзывов отображать на странице

    /**
     * Пранслитератор url
     *
     * @param string $value
     * @return string
     */
    private function translit( $value )
    {
        $converter = array(
            'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
            'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
            'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
            'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
            'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
            'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
            'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
        );

        $value = mb_strtolower($value);
        $value = strtr($value, $converter);
        $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
        $value = mb_ereg_replace('[-]+', '-', $value);
        $value = trim($value, '-');

        return $value;
    }

    /**
     * Загружаем логотип компании
     *
     * @param binary $img
     * @return string
     */
    private function logoSave( $img )
    {
        $puth = $img->store('upload');
        $img->move('upload', $puth);

        return $puth;
    }

    /**
     * Загружаем логотип компании
     *
     * @param binary $img
     * @return string
     */
    private function estimateSave( $estimateSave )
    {
        $puth = $estimateSave->store('upload');
        $estimateSave->move('upload', $puth);

        return $puth;
    }

    /**
     * Получаем список компаний
     */
    public function getCompany()
    {
        $company = DB::table('company')->get();
        return view('admin.company.list', ['companies' => $company]);
    }

    /**
     * Добавление компании
     */
    public function addCompany(Request $req)
    {
        $valid = Validator::make($req->all(), [
            'name'          => 'required|min:2',
            'site'          => 'required',
            'phone'         => 'required',
            'date'          => 'required',
            'address'       => 'required',
            'discription'   => '',
            'logo'          => 'image|required',
            'youtube'       => '',
            'flamp'         => 'numeric',
            'yell'          => 'numeric',
            'yandex'        => 'numeric',
            'profile'       => 'required|numeric'
        ]);

        # Проверяем данные
        if ( $valid->fails() ) {
            response()->json([
                'status'    => 'error',
                'type'      => 'validation',
                'message'   => $valid->errors()
            ]);
        }

        DB::table('company')->insert([
            'name'          => $req->name,
            'url'           => $this->translit($req->name),
            'site'          => $req->site,
            'phone'         => preg_replace('~\D+~','', $req->phone),
            'create'        => Carbon::parse($req->data)->toDateTimeString(),
            'address'       => $req->address,
            'discription'   => $req->discription,
            'youtube'       => $req->youtube,
            'logo'          => $this->logoSave($req->logo),
            'flamp_id'      => $req->flamp,
            'yell_id'       => $req->yell,
            'yandex_id'     => $req->yandex,
            'rating_profile'=> $req->profile
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Редактирование компании
     *
     * @return json
     */
    public function editCompany(Request $req)
    {
        Validator::make($req->all(), [
            'name'          => 'required|min:2',
            'site'          => 'required',
            'phone'         => 'required',
            'date'          => 'required',
            'address'       => 'required',
            'youtube'       => '',
            'discription'   => '',
            'logo'          => 'image',
            'flamp'         => 'numeric',
            'yell'          => 'numeric',
            'yandex'        => 'numeric',
            'profile'       => 'numeric',
            'estimate'      => 'mimes:pdf',
            'redecorating'  => 'required',
            'overhaul'      => 'required',
            'turnkey_repair'=> 'required',
            'danger_level' => 'required|integer',
            'danger_reason' => 'nullable|string',
        ]);

        $save = array(
            'name'          => $req->name,
            'url'           => $this->translit($req->name),
            'site'          => $req->site,
            'phone'         => preg_replace('~\D+~','', $req->phone),
            'create'        => Carbon::parse($req->data)->toDateTimeString(),
            'address'       => $req->address,
            'discription'   => $req->discription,
            'youtube'       => $req->youtube,
            'flamp_id'      => $req->flamp,
            'yell_id'       => $req->yell,
            'yandex_id'     => $req->yandex,
            'rating_profile'=> $req->profile,
            'redecorating'  => $req->redecorating,
            'overhaul'      => $req->overhaul,
            'turnkey_repair'=> $req->turnkey_repair,
            'danger_level' => $req->danger_level,
            'danger_reason' => $req->danger_reason ? $req->danger_reason : null
        );

        if ( $req->logo != '') {
            $save['logo'] = $this->logoSave($req->logo);
        }

        if ( $req->estimate != '') {
            $save['estimate'] = $this->estimateSave($req->estimate);
        }

        DB::table('company')->where('id', $req->id)->update($save);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * Приобразуем телефон в читабельный
     *
     * @return string
     */
    function phone_format( $phone, $format, $mask = '_' )
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (is_array($format)) {
            if (array_key_exists(strlen($phone), $format)) {
                $format = $format[strlen($phone)];
            } else {
                return false;
            }
        }

        $pattern = '/' . str_repeat('([0-9])?', substr_count($format, $mask)) . '(.*)/';

        $format = preg_replace_callback(
            str_replace('#', $mask, '/([#])/'),
            function () use (&$counter) {
                return '${' . (++$counter) . '}';
            },
            $format
        );

        return ($phone) ? trim(preg_replace($pattern, $format, $phone, 1)) : false;
    }

    /**
     * Вытаскиваем отзывы из базы
     */
    public function getReview($companyId, $page)
    {
        $list   = --$page * $this->reviewShow;

        $reviews    = DB::table('reviews')
            ->where(['company' => $companyId, 'status' => 'active'])
            ->orderBy('date', 'DESC')
            ->limit($this->reviewShow)
            ->offset($list)
            ->get();

        foreach($reviews as $val) {
            if(strip_tags(mb_strlen($val->text)) >= 400) {
                $val->more = true;
                $val->originalText = $val->text;
                $val->text = mb_strimwidth($val->text, 0, 400, '...');
            } else {
                $val->more = false;
                $val->originalText = $val->text;
            }
        }

        return $reviews;
    }

    /**
     * Информация о компании
     *
     * @param string $name
     * @param int $page
     * @return array
     */
    public function getCompanyInfo( $name, $page = 1 )
    {
        $row    = DB::table('company')
            ->where('url', $name)
            ->first();

        $total  = DB::table('reviews')
            ->where('company', $row->id)
            ->count();


        return [
            'id'            => $row->id,
            'url'           => $row->url,
            'name'          => $row->name,
            'logo'          => $row->logo,
            'description'   => $row->discription,
            'address'       => $row->address,
            'youtube'       => $row->youtube,
            'yell_id'       => $row->yell_id,
            'flamp_id'      => $row->flamp_id,
            'yandex_id'     => $row->yandex_id,
            'profile'       => $row->rating_profile,
            'rating_reviews'=> $row->rating_reviews,
            'estimate'      => $row->estimate,
            'redecorating'  => $row->redecorating,
            'overhaul'      => $row->overhaul,
            'turnkey_repair'=> $row->turnkey_repair,
            'phone'         => $this->phone_format($row->phone, [
                '11' => '_ (___) ___-__-__'
            ]),
            'site'          => $row->site,
            'date'          => date('d.m.Y', strtotime($row->create)),
            'reviews'       => $this->getReview($row->id, $page),
            'reviewsNav'    => [
                'total'     => $total,
                'show'      => $this->reviewShow,
                'сurrent'   => $page,
                'start'     => $page-3,
                'end'       => $page+3,
                'pages'     =>$total/$this->reviewShow
            ],
            'danger_level' => $row->danger_level,
            'danger_reason' => $row->danger_reason,
        ];
    }

    /**
     * Удаление компаний
     */
    public function del($id)
    {
        try {
            DB::table('company')->where('id', $id)->delete();
            $estimates = DB::table('estimates')->where('company_id', $id);

            if ( $meta = $estimates->first()  ) {
                $estimates->delete();
                DB::table('estimatesMeta')->where('estimate_id', $meta->id)->delete();
            }

            return redirect('/admin/companies?status=ok');
        } catch (QueryException $e) {
            return redirect('/admin/companies?status=error');
        }
    }

    /**
     * страница компаний
     * @param $name
     * @param int $page
     * @return View
     */

    public function show($name, $page = 1) {
        return view('company', $this->getCompanyInfo($name, $page));
    }

    /**
     * @return View
     */
    public function add() {
        return view('admin.company.add');
    }

    /**
     * @param $name
     * @return View
     */

    public function edit($name) {
        return view('admin.company.edit', $this->getCompanyInfo($name));
    }
}
