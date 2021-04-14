@extends('layouts.main')

@section('title', 'Калькулятор ремонта')

@section('content')
    <div class="content">
        <h1>Любительский калькулятор ромонта</h1>
        <div class="wrap">
            <div class="wd-3 mwd-12">
                @component('block.menuCalculator', ['title' => 'Любительский калькулятор'])
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Простой калькулятор ремонта создан для людей которые не хотят углублятся в тему ремонта, а просто хотят найти компанию по приемлимой цене.</p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Калькулятор ремонта в 4 простых шага подберет вам компанию по оптимальному соотношения цена-качество.</p>
                @endcomponent
            </div>
            <div class="wd-9 mwd-12">
                <div class="calc">
                    <form method="POST" action="" class="calc__content" id="calc-amateur">
                        <div class="calc__box">
                            <div class="calc__box-title">Оснавная информация</div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Тип помещения</div>
                                    <div class="calc-trigger">
                                        <input type="hidden" name="calc-type">
                                        <span data-val="0">Новостройка</span>
                                        <span data-val="1">Вторичка</span>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Количество комнат</div>
                                    <div class="calc-rooms">
                                        <input type="hidden" name="calc-rooms">
                                        <span data-val="0">Студия</span>
                                        <span data-val="1">1</span>
                                        <span data-val="2">2</span>
                                        <span data-val="3">3</span>
                                        <span data-val="4">4</span>
                                        <span data-val="5">5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Тип ремонта</div>
                                    <div class="calc-rem">
                                        <select name="typeRem" id="typeRem" data-placeholder="Тип ремонта">
                                            <option></option>
                                            <option value="0">Косметический</option>
                                            <option value="1">Капитальный</option>
                                            <option value="2">Черновой (White box)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Укажите площадь</div>
                                    <label for="aere" class="input">
                                        <input type="text" name="aere" placeholder="Введите значение" autocomplete="off">
                                        <span>м<sup>2</sup></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="calc__box">
                            <div class="calc__box-title">Отделка</div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Отделка потолка</div>
                                    <div class="calc-сeiling">
                                        <select name="сeiling" id="сeiling" data-placeholder="Потолок">
                                            <option></option>
                                            <option value="0">Натяжной</option>
                                            <option value="1">Покраска</option>
                                            <option value="2">Многоуровневый</option>
                                            <option value="3">Оклейка обоями</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Отделка стен(в квартире)</div>
                                    <div class="calc-walls">
                                        <select name="walls" id="walls"  data-placeholder="Стены">
                                            <option></option>
                                            <option value="0">Обои</option>
                                            <option value="1">Покраска</option>
                                            <option value="2">Плитка</option>
                                            <option value="3">Декоративная штукатурка</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Напольное покрытие</div>
                                    <div class="calc-floor">
                                        <select name="floor" id="floor" data-placeholder="Пол">
                                            <option></option>
                                            <option value="0">Ламинат</option>
                                            <option value="1">Паркетная доска</option>
                                            <option value="2">Плитка</option>
                                            <option value="3">Массив</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Отделка стен(в ванной)</div>
                                    <div class="calc-wall-bath">
                                        <select name="walls" id="calc-wall-bath" data-placeholder="Стены в ванной">
                                            <option></option>
                                            <option value="0">Плитка</option>
                                            <option value="1">Мазайка</option>
                                            <option value="2">Панели ПВХ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="calc__box">
                            <div class="calc__box-title">Электрика</div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Кондиционер</div>
                                    <label for="conditioner" class="input">
                                        <input type="text" name="conditioner" placeholder="Введите значение" autocomplete="off">
                                        <span>шт</span>
                                    </label>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Розетки и выключатели</div>
                                    <label for="sockets" class="input">
                                        <input type="text" name="sockets" placeholder = "Введите значение" autocomplete="off">
                                        <span>шт</span>
                                    </label>
                                </div>
                            </div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Теплый пол</div>
                                    <label for="warm-floor" class="input">
                                        <input type="text" name="warm-floor" placeholder="Введите значение" autocomplete="off">
                                        <span>м<sup>2</sup></span>
                                    </label>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Количество светильников</div>
                                    <label for="chandelier" class="input">
                                        <input type="text" name="chandelier" placeholder="Введите значение" autocomplete="off">
                                        <span>шт</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="calc__box">
                            <div class="calc__box-title">Двери</div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Замена входной двери</div>
                                    <div class="calc-trigger">
                                        <input type="hidden" name="calc-door">
                                        <span data-val="0">Да</span>
                                        <span data-val="1">Нет</span>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Кол-во межкомнатных дверей</div>
                                    <label for="quantity-door" class="input">
                                        <input type="text" name="quantity-door" placeholder="Введите значение" autocomplete="off">
                                        <span>шт</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="calc__box">
                            <div class="calc__box-title">Сантехника</div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Ванна/Душевая</div>
                                    <label for="inp" class="input">
                                        <input type="text" name="bath" id="inp" placeholder="Введите значение" autocomplete="off">
                                        <span>шт</span>
                                    </label>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Унитаз</div>
                                    <label for="inp" class="input">
                                        <input type="text" name="toilet-bowl" id="inp" placeholder="Введите значение" autocomplete="off">
                                        <span>шт</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="calc__box">
                            <div class="calc__box-title">Финальные работы</div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <label class="checkbox">
                                        <input type="checkbox" name="garbage-removal" class="checkbox__input">
                                        <div class="checkbox__block">
                                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                <polyline points="4 11 8 15 16 6"></polyline>
                                            </svg>
                                        </div>
                                        <span>Вывоз мусора</span>
                                    </label>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <label class="checkbox">
                                        <input type="checkbox" name="cleaning" class="checkbox__input">
                                        <div class="checkbox__block">
                                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                <polyline points="4 11 8 15 16 6"></polyline>
                                            </svg>
                                        </div>
                                        <span>Уборка</span>
                                    </label>
                                </div>
                            </div>
                            <div class="calc__footer ">
                                <button type="submit" class="button__green">Рассчитать</button>
                                <div class="filed">Не все поля заполнены!</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection