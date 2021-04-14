<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ParserController;
use App\Mail\Application;
use ReCaptcha\ReCaptcha;

class globalController extends Controller
{
    /**
     * Главная страница
     */
    public function index()
    {
        $homeRating = DB::table('company')
            ->select('*' ,DB::raw('(`rating_profile` + `rating_reviews`)/2 as `ratingSort`'))
            ->orderBy('ratingSort', "DESC");

        $rating = $homeRating->limit(6)->get();

        return view('index', [
            'companies' => $rating
        ]);
    }

    /**
     * Удаление отзывов
     */
    public function reviewDelete(Request $req)
    {
        $valid = Validator::make($req->all(), [
            'id'    => 'required|numeric'
        ]);

        if( $valid->fails() ) {
            response()->json([
                'status'    => 'error',
                'type'      => 'validation',
                'message'   => $valid->errors()
            ]);
        }

        $delete =DB::table('reviews')
            ->where('id', $req->id)
            ->delete();

        if ($delete) {
            $update = new ParserController();
            $update->update();

            return response()->json([
                'status'    => 'ok'
            ]);
        } else {
            return response()->json([
                'status'    => 'error',
                'type'      => 'delete',
                'message'   => 'Не удалось удалить отзыв!'
            ]);
        }
    }

    /**
     * Отправка заявки
     */
    public function application(Request $req)
    {
        $data       = $req->all();
        $ip         = $req->ip();
        $recaptcha  = new ReCaptcha("6LeuMrsZAAAAAJbesO0raKc84v681yGb4Foh8w8i");

        $capthcaToken = Validator::make($data, ['g-recaptcha-response' => 'required']);

        if ( $capthcaToken->fails() ) {
            return response()->json([
                "status"    => "error",
                "message"   => "Поле капча обязательно для заполнения."
            ]);
        }

        $resp = $recaptcha->verify($data['g-recaptcha-response'], $ip);

        if ( !$resp->isSuccess() ) {
            return response()->json([
                "status"    => "error",
                "message"   => "Капча введена неверно."
            ]);
        }

        $valid = Validator::make($data, [
            'id'    => 'required|numeric',
            'phone' => 'required',
            'name'  => 'required|min:2'
        ]);

        if ( $valid->fails() ) {
            return response()->json([
                'status'    => "error",
                'message'   => "Одно из полей заполнено не коректно."
            ]);
        }

        $email = DB::table('company')->where('id', $data['id'])->first();
        Mail::to($email->email)
            ->send(new Application($data));

        return  response()->json([
            "status"    => "ok",
            "message"   => ""
        ]);
    }

    /**
     * Страница отзывов
     */
    public function rating()
    {
        $sql = DB::table('company')
            ->select('*' ,DB::raw('(`rating_profile` + `rating_reviews`)/2 as `ratingSort`'))
            ->orderBy('ratingSort', "DESC");

        $rating = $sql->get();
        $super  = $sql->where('id', 8)->first();

        foreach ($rating as $row) {
            $count = DB::table('reviews')->where(['company' => $row->id, 'status' => 'active']);
            $row->count = $count->count();
         }

        return view('rating', ['companies' => $rating, 'super' => $super]);
    }

    /**
     *
     */
    public function professional() {
        $super = DB::table('company')
            ->where('id', 8)
            ->first();

        return view('calculator.professional', ['super' => $super]);
    }
}
