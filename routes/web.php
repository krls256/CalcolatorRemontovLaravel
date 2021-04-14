<?php

use App\Http\Controllers\User\MainUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EstimatesController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\globalController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\Videos;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [globalController::class, 'index']);
Route::get('rating', [globalController::class, 'rating']);
Route::get('amateur', [MainUserController::class, 'amateur']);
Route::get('professional', [globalController::class, 'professional']);

Route::get('video', [Videos::class, 'getPage']);
Route::get('price', [PriceListController::class, 'get']);

Route::get('download', function(Request $req) {
    $file_path = storage_path() . '/app/';

    return response()->download($file_path . $req->url);
});

# Информация о компании
Route::group(['prefix' => 'rating'], function( $route ) {
    $get = new CompanyController();

    $route->get('/{name}', function( $name ) use ( $get ) {
        return view('company', $get->getCompanyInfo($name) );
    });

    $route->get('/{name}/{page}', function( $name, $page ) use ( $get ) {
        return view('company', $get->getCompanyInfo($name, $page) );
    });
});



# Подключаем административную панель
Route::group(['prefix' => 'admin'], function() {

    Route::group(['middleware' => ['auth', 'web']], function( $route ) {
        $route->view('/', 'admin.home');         # Главная
        $route->view('home', 'admin.home');      # Главная
        $route->get('logout', [AuthController::class, 'logout']);
    });

    # Компании
    Route::group(['prefix' => 'companies', 'middleware' => ['auth', 'web']], function( $route ) {
        $route->get('/', [CompanyController::class, 'getCompany']); # Список компаний
        $route->get('del/{id}', [CompanyController::class, 'del']); # Удаление компании

        $route->view('add', 'admin.company.add');                   # Создание компании

        # Редактирование компании
        $route->get('{name}', function( $name ) {
            $get = new CompanyController();
            return view('admin.company.edit', $get->getCompanyInfo($name));
        });
    });

    # Сметы
    Route::group(['prefix' => 'estimates', 'middleware' => ['auth', 'web']], function( $route ) {
        $route->get('/', [EstimatesController::class, 'getEstimates']);             # Список компаний
        $route->get('edit/{id}', [EstimatesController::class, 'editEstimates']);    # Редактирование сметы
        $route->get('add', function(){
            $get = DB::table('company')
                ->select("company.*")
                ->leftJoin('estimates', 'estimates.company_id', '=', 'company.id')
                ->whereNull('estimates.company_id')
                ->get();


            return view('admin.estimates.add', ['companies' => $get]);
        });
        $route->get('del/{id}', [EstimatesController::class, 'delete']);

    });

    Route::group(['prefix' => 'users', 'middleware' => ['auth', 'web']], function( $route ) {
        $route->get('/', [UsersController::class, 'getUsers']);
        $route->view('add', 'admin.users.add');
        $route->get('{id}', function( $id ) {
            $get = DB::table('users')->where('id', $id)->first();
            return view('admin.users.edit', ['user' => $get]);
        });

        $route->get('del/{id}', function( $id ) {
            $get = DB::table('users')->where('id', $id)->delete();
            return redirect('/admin/users');
        });

    });

    /**
     * Обработчик раздела цен(Админ панель)
     */
    Route::group(['prefix' => 'price', 'middleware' => ['auth', 'web']], function( $route ) {
        $route->view('/', 'admin.price.list', ['companies' => DB::table('company')->get()]);

        $route->match(['post', 'get'], '/del/{id}', function(Request $req, $id) {
            $sql = DB::table('meta_price')->where('id', $id);
            $companyId = $sql->first();
            $sql->delete();

            if ($req->isMethod('get'))
                return redirect('admin/price/edit/' . $companyId->company_id);
            else
                return response()->json([
                    'code'      => 'ok',
                    'message'   => ''
                ]);
        });

        $route->get('edit/{id}', function(int $id) {
            $get = DB::table('company')
                ->where('id', $id)
                ->first();

            $data = DB::table('meta_price')
                ->where('company_id', $get->id)
                ->get();

            return view('admin.price.edit', [
                'id'   => $get->id,
                'name' => $get->name,
                'data' => $data
            ]);
        });
    });

    # Авторизация
    Route::name('login')->get('login', function(){
        return !Auth::check() ? view('admin.login') : redirect('/admin');
    });
});

# Обработка API запросов
Route::prefix('ajax')->group(function( $route ) {

    $route->post('sign_in', [AuthController::class, 'auth']);   # Авторизация
    $route->post('score', [CalculatorController::class, 'score']);
    $route->post('lite', [CalculatorController::class, 'lite']);
    $route->post('sendApplication', [globalController::class, 'application']);
    $route->post('getVideo', [Videos::class, 'getVideo']);

    # Если авторизован
    Route::middleware(['auth', 'web'])->group(function( $route ) {
        $route->post('company/edit', [CompanyController::class, 'editCompany']);    # Редактируем компанию
        $route->post('company/add', [CompanyController::class, 'addCompany']);      # Создаем компанию

        $route->post('users/add', [UsersController::class, 'addUser']);    # Редактируем компанию
        $route->post('estimates/add', [EstimatesController::class, 'addEstimates']);
        $route->post('estimates/edit', [EstimatesController::class, 'edit']);

        $route->post('reviews/delete', [globalController::class, 'reviewDelete']);

        $route->post('price/add', [PriceListController::class, 'add']);
    });
});
