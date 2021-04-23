<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\CompanyRepository\MainUserCompaniesRepository;
use App\Repositories\User\VideosRepository\MainUserVideosRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MainUserController extends Controller
{
    public function amateur()
    {
        return view('calculator.amateur');
    }

    /**
     * Главная страница
     * @param MainUserCompaniesRepository $companiesRepository
     * @return View
     */

    public function home(MainUserCompaniesRepository $companiesRepository)
    {
        $companiesCollection = $companiesRepository->getRatingCompaniesLimit();

        return view('index', [
            'companies' => $companiesCollection
        ]);
    }


    /**
     * Страница отзывов
     * @param MainUserCompaniesRepository $companiesRepository
     * @return View
     */
    public function rating(MainUserCompaniesRepository $companiesRepository)
    {

        $rating = $companiesRepository->getRatingCompaniesTopWithCount();
        $super = $companiesRepository->getSuperCompanyFromTop($rating);

        return view('rating', ['companies' => $rating, 'super' => $super]);
    }

    /**
     * Профессиональный калькулятор
     * @param MainUserCompaniesRepository $companiesRepository
     * @return View
     */

    public function professional(MainUserCompaniesRepository $companiesRepository)
    {
        $super = $companiesRepository->getSuperCompany();

        return view('calculator.professional', ['super' => $super]);
    }

    /**
     * Выводим компании с прайсами
     *
     * @param MainUserCompaniesRepository $companiesRepository
     * @return View
     */
    public function price(MainUserCompaniesRepository $companiesRepository)
    {
        $companies = $companiesRepository->getCompaniesWithPrices();
        $super = $companiesRepository->getSuperCompanyFromTop($companies);

        return view('price', [
            'companies' => $companies,
            'super' => $super
        ]);
    }

    /**
     *
     */
    public function video(MainUserVideosRepository $videosRepository)
    {
        $companies = $videosRepository->getCompaniesVideos();

        return view('video', ['companies' => $companies]);
    }
}
