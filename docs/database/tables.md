# Таблицы

## company 
Таблица содержит информацию о компаниях.
 * id bigint(20)
 * url varchar(255) - slug страницы с компании
 * name	varchar(255)
 * logo	varchar(255) - путь к логотипу от корня
 * phone bigint(20)
 * address text
 * site	varchar(255) - сайт компании
 * create timestamp
 * discription text - свёрстанное описание
 * youtube varchar(255)
 * yell_id varchar(30)
 * flamp_id	varchar(30)
 * yandex_id varchar(30)
 * rating_reviews decimal(10,1)
 * rating_profile decimal(10,1)
 * email varchar(100)
 * estimate varchar(255) - ссылка на pdf сметы
 * redecorating	bigint(20)
 * overhaul	bigint(20)
 * turnkey_repair bigint(20)

## estimates

Таблица для связи таблиц company и estimatesMeta, на мой взгляд <deksazon8@gmail.com>, таблица является рудиментом
* id bigint(20)	
* name varchar(100)
* company_id int(11)

## estimatesMeta

Данные о сметах компании
* id bigint(20)	
* name varchar(100)
* type varchar(100)
* meta varchar(100)
* estimate_id int(11)
* dimension varchar(20)

## failed_jobs

стандартная таблица laravel, возможно будет использоваться если будет необходимость делегировать логику в jobs-ы и возможность настроить supervisor

## meta_price

Таблица с ценами на услуги компаний

* id bigint(20)
* company_id int(11)
* title	varchar(100)
* price	int(11)
* group	int(11)
* measure int(11)

## migrations

Таблица с метаданными о миграциях (стандартная таблица laravel)

## password_resets

Запросы на восстановления пароля (стандартная таблица пакета laravel/auth)

## reviews
Таблица отзывов, которые парсятся с __Flamp__, __Yell__, __Yandex.Maps__

* id bigint(20)
* company int(11)
* review_id	varchar(50)
* provider varchar(20) - источник отзыва
* rating int(11)
* user varchar(100)
* text text
* date varchar(20)
* img text
* status varchar(15)

## users

Пользователи (стандартная таблица пакета laravel/auth)

* id bigint(20)
* role varchar(255)
* email varchar(255) - в реальности это не почта, а логин
* email_verified_at timestamp
* password varchar(255)
* remember_token varchar(100)
* created_at/updated_at

## videos

Таблица видел с YouTube каналов компаний
* id bigint(20)
* company_id int(11)
* video_id varchar(255)
* name varchar(255)
* desc text
* date timestamp
* img varchar(255)
