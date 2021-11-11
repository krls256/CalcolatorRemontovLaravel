<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Application\CompanyApplicationRepository;
use App\Http\Controllers\ParserController;
use App\Mail\Application;
use ReCaptcha\ReCaptcha;

class globalController extends Controller
{
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
    public function application(Request $req, CompanyApplicationRepository $applicationRepository)
    {
        $data       = $req->all();
        $ip         = $req->ip();
        $recaptcha  = new ReCaptcha(env("RECAPTCHA_V3_PRIVATE"));

        $capthcaToken = Validator::make($data, ['g-recaptcha-response' => 'required']);

        if ( $capthcaToken->fails() ) {
            return response()->json([
                "status"    => "error",
                "message"   => "Поле капча обязательно для заполнения."
            ]);
        }

        $resp = $recaptcha->verify($data['g-recaptcha-response'], $ip);

        if ( !$resp->isSuccess() || $resp->getScore() < env("RECAPTCHA_V3_ACCEPT_GATE")) {
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

        $email = $applicationRepository->getCompanyEmail($data['id']);
        if($email) {
            Mail::to($email)
            ->send(new Application($data));

        }

        return  response()->json([
            "status"    => "ok",
            "message"   => ""
        ]);
    }
}
