<?php

use App\Http\Controllers\Admin\AdminPricesController;
use App\Http\Controllers\Admin\MainAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Download\MainDownloadController;
use App\Http\Controllers\EstimatesController;
use App\Http\Controllers\globalController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\User\MainUserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Videos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainUserController::class, 'home']);
Route::get('rating', [MainUserController::class, 'rating']);
Route::get('amateur', [MainUserController::class, 'amateur']);
Route::get('professional', [MainUserController::class, 'professional']);
Route::get('price', [MainUserController::class, 'price']);
Route::get('video', [MainUserController::class, 'video']);


Route::get('download', [MainDownloadController::class, 'index']);

# Информация о компании
Route::group(['prefix' => 'rating'], function ()
{
    Route::get('{name}/{page?}', [CompanyController::class, 'show']);
});


# Подключаем административную панель
Route::group(['prefix' => 'admin'], function ()
{

    Route::group(['middleware' => ['auth', 'web']], function ($route)
    {
        $route->get('/', [MainAdminController::class, 'home']);         # Главная
        $route->get('home', [MainAdminController::class, 'home']);      # Главная
        $route->get('logout', [AuthController::class, 'logout']);
    });

    # Компании
    Route::group(['prefix' => 'companies', 'middleware' => ['auth', 'web']], function ($route)
    {
        $route->get('/', [CompanyController::class, 'getCompany']); # Список компаний
        $route->get('del/{id}', [CompanyController::class, 'del']); # Удаление компании

        $route->get('add', [CompanyController::class, 'add']); # Создание компании

        # Редактирование компании
        $route->get('{name}', [CompanyController::class, 'edit']);
    });

    # Сметы
    Route::group(['prefix' => 'estimates', 'middleware' => ['auth', 'web']], function ($route)
    {
        $route->get('/', [EstimatesController::class, 'getEstimates']);             # Список компаний
        $route->get('edit/{id}', [EstimatesController::class, 'editEstimates']);    # Редактирование сметы
        $route->get('add', [EstimatesController::class, 'add']);
        $route->get('del/{id}', [EstimatesController::class, 'delete']);

    });

    Route::group(['prefix' => 'users', 'middleware' => ['auth', 'web']], function ($route)
    {
        $route->get('/', [UsersController::class, 'getUsers']);
        $route->view('add', 'admin.users.add');
        $route->get('{id}', [UsersController::class, 'show']);
        $route->get('del/{id}', [UsersController::class, 'del']);

    });

    /**
     * Обработчик раздела цен(Админ панель)
     */
    Route::group(['prefix' => 'price', 'middleware' => ['auth', 'web']], function ($route)
    {
        $route->get('/', [AdminPricesController::class, 'index']);
        $route->match(['post', 'get'], '/del/{id}', [AdminPricesController::class, 'del']);
        $route->get('edit/{id}', [AdminPricesController::class, 'edit']);
    });

    # Авторизация
    Route::name('login')
        ->get('login', function ()
        {
            return !Auth::check() ? view('admin.login') : redirect('/admin');
        });
});

# Обработка API запросов
Route::prefix('ajax')
    ->group(function ($route)
    {

        $route->post('sign_in', [AuthController::class, 'auth']);   # Авторизация
        $route->post('score', [CalculatorController::class, 'professional']); // Professional calc
        $route->post('lite', [CalculatorController::class, 'calculate']);
        $route->get('lite', [CalculatorController::class, 'calculate']);
        $route->post('sendApplication', [globalController::class, 'application']);
        $route->post('getVideo', [Videos::class, 'getVideo']);

        # Если авторизован
        Route::middleware(['auth', 'web'])->group(function ($route)
            {
                $route->post('company/edit', [CompanyController::class, 'editCompany']);    # Редактируем компанию
                $route->post('company/add', [CompanyController::class, 'addCompany']);      # Создаем компанию

                $route->post('users/add', [UsersController::class, 'addUser']);    # Редактируем компанию
                $route->post('estimates/add', [EstimatesController::class, 'addEstimates']);
                $route->post('estimates/edit', [EstimatesController::class, 'edit']);

                $route->post('reviews/delete', [globalController::class, 'reviewDelete']);

                $route->post('price/add', [PriceListController::class, 'add']);
            });
    });

    Route::get('test', function() {
        dd(env("RECAPTCHA_V3_PUBLIC"));
    });
