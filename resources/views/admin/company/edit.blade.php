@extends('admin.layouts.main')

@section('title', "Редактировать компанию ".$name)

@section('content')
    <div class="title-block">
        <h1 class="title">Редактирование {{ $name }}</h1>
    </div>
    <form action="" class="form" id="edit-company-form">
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id" value="{{ $id }}">
        <div class="box">
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Названия компании</div>
                    <label for="name" class="input">
                        <input type="text" id="name" name="name" placeholder="Ремонт" value="{{ $name ?? '' }}" />
                    </label>
                </div>
                <div class="col-6">
                    <div class="file__title">Логотип компании</div>
                    <label for="logo" class="file">
                        <input type="file" name="logo" id="logo" />
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Web сайт</div>
                    <label for="site" class="input">
                        <input type="text" id="site" name="site" placeholder="" value="{{ $site ?? '' }}">
                    </label>
                </div>
                <div class="col-6">
                    <div class="input__title">Номер телефона</div>
                    <label for="phone" class="input">
                        <input type="text" id="phone" name="phone" placeholder="+7 (___) ___-__-__"
                               value="{{ $phone ?? '' }}">
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Дата создания</div>
                    <label for="data" class="input">
                        <input type="text" id="data" name="data" placeholder="01.01.1970" class="create_company"
                               autocomplete="off" data-date="{{ $date ?? '' }}" value="{{ $date ?? '' }}" />
                    </label>
                </div>
                <div class="col-6">
                    <div class="input__title">Адрес компании</div>
                    <label for="address" class="input">
                        <input type="text" id="address" name="address" placeholder="ул. Ленина, д. 1"
                               value="{{ $address ?? '' }}" />
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-6">
                    <div class="file__title">Смета компании</div>
                    <label for="estimate" class="file">
                        <input type="file" name="estimate" id="estimate" />
                    </label>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box__title">Цены на ремонт</div>
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Косметический ремонт</div>
                    <label for="redecorating" class="input">
                        <input type="text" id="redecorating" name="redecorating" placeholder="Цена за 1 м²"
                               autocomplete="off" value="{{ $redecorating }}" />
                        <span>руб.</span>
                    </label>
                </div>
                <div class="col-6">
                    <div class="input__title">Капитальный ремонт</div>
                    <label for="overhaul" class="input">
                        <input type="text" id="overhaul" name="overhaul" placeholder="Цена за 1 м²" autocomplete="off"
                               value="{{ $overhaul }}" />
                        <span>руб.</span>
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Ремонт под ключ</div>
                    <label for="turnkey_repair" class="input">
                        <input type="text" id="turnkey_repair" name="turnkey_repair" placeholder="Цена за 1 м²"
                               autocomplete="off" value="{{ $turnkey_repair }}" />
                        <span>руб.</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Youtube</div>
                    <label for="youtube" class="input">
                        <input type="text" id="youtube" name="youtube" placeholder="https://"
                               value="{{ $youtube ?? '' }}" />
                    </label>
                </div>
                <div class="col-6">
                    <div class="input__title">YELL ID</div>
                    <label for="yell" class="input">
                        <input type="text" id="yell" name="yell" placeholder="ID на площадке YELL"
                               value="{{ $yell_id ?? '' }}" />
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">FLAMP ID</div>
                    <label for="flamp" class="input">
                        <input type="text" id="flamp" name="flamp" placeholder="ID на площадке FLAMP"
                               value="{{ $flamp_id ?? '' }}" />
                    </label>
                </div>
                <div class="col-6">
                    <div class="input__title">Yandex ShopID</div>
                    <label for="yandex" class="input">
                        <input type="text" id="yandex" name="yandex" placeholder="ID компании в yandex картах"
                               value="{{ $yandex_id ?? '' }}" />
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-6">
                    <div class="select__title">Рейтинг по RusProFile</div>
                    <label for="profile" class="select">
                        <select name="profile" id="profile" data-placeholder="Сколько звезд?">
                            <option></option>
                            <option value="1" {{ $profile == "1.0"?'selected':''}}>1</option>
                            <option value="2" {{ $profile == "2.0"?'selected':''}}>2</option>
                            <option value="3" {{ $profile == "3.0"?'selected':''}}>3</option>
                            <option value="4" {{ $profile == "4.0"?'selected':''}}>4</option>
                            <option value="5" {{ $profile == "5.0"?'selected':''}}>5</option>
                        </select>
                    </label>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="row padding">
                <div class="col-12">
                    <div class="input__title">Уровень небезопасности компании (чем больше, тем опаснее)</div>
                    <label for="danger_level" class="input">
                        <input type="text" id="danger_level" name="danger_level" placeholder="Целое число"
                               value="{{ old('danger_level', $danger_level ?? '') }}" />
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-12">
                    <label class="input__title" for="danger_reason">Причина небезопасности</label>
                        <textarea id="danger_reason" name="danger_reason" placeholder="Поле будет показываться пользователю" cols="30" rows="10"
                        >{{ old('danger_reason', $danger_reason ?? '') }}</textarea>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="col-12">
                <textarea name="discription" id="discription" cols="30" rows="10">{{ $description ?? '' }}</textarea>
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn center opacity">Сохранить</button>
        </div>
    </form>
@endsection
