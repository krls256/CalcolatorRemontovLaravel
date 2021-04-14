@extends('layouts.main')

@section('title', "Видео о ремонте квартир")
@section('description', "Чем живет, и чем занимается компания расскажет вам раздел видео о ремонте квартир.")

@section('content')
    <div class="load">
        <div class="loading-spinner">
            <div class="loading-spinner__container">
                <div></div>
                <div></div>
                <div>
                    <div></div>
                </div>
                <div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="content">
            <h1>Видио о ремонте квартир</h1>
            <div class="wrap">
                <div class="wd-12 boxes">
                    <div class="boxes__header"><i class="boxes__img-orang icon-info"></i>Видео о ремонте</div>
                    <div class="boxes__content">Чем живет, и чем занимается компания расскажет вам раздел видео. Также раздел видео поможет увидеть качество исполнения ремонта своими глазами, и выбрать компанию которая делает ремонт подходящий под ваш вкус.</div>
                </div>
            </div>
            <div style="margin: 0px 15px">
                @foreach($companies as $row)
                    <div class="video">
                        <div class="video__header">
                            <img src="/static/images/image.svg" data-src="{{ $row->logo }}" alt="{{ $row->name }}" class="lazy">
                            <noscript><img src="{{ $row->logo }}" alt="{{ $row->name }}"></noscript>
                            <div>
                                <a href="/rating/{{ $row->url }}/">{{ $row->name }}</a>
                                <div>
                                    <span>Оценка: </span>
                                    @component('block.rating', ['rating' => ( $row->rating_profile + $row->rating_reviews)/2 ])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="video__container">
                            @foreach($row->video as $video)
                                <div class="video__col" href="#videoModal" data-id="{{ $video->id }}">
                                    <div class="boxes">
                                        <img src="/static/images/image320x180.svg" data-lazy="{{ $video->img }}" alt="{{ $video->name }}">
                                        <noscript><img src="{{ $video->img }}" alt="{{ $video->name }}"></noscript>
                                        <span>{!! $video->name !!}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <div id="videoModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close-videoModal">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 340.8 340.8"><path d="M170.4,0C76.4,0,0,76.4,0,170.4s76.4,170.4,170.4,170.4s170.4-76.4,170.4-170.4S264.4,0,170.4,0z M170.4,323.6 c-84.4,0-153.2-68.8-153.2-153.2S86,17.2,170.4,17.2S323.6,86,323.6,170.4S254.8,323.6,170.4,323.6z"/><path d="M182.4,169.6l50-50c3.2-3.2,3.2-8.8,0-12c-3.2-3.2-8.8-3.2-12,0l-50,50l-50-50c-3.2-3.2-8.8-3.2-12,0 c-3.2,3.2-3.2,8.8,0,12l50,50l-50,49.6c-3.2,3.2-3.2,8.8,0,12c1.6,1.6,4,2.4,6,2.4s4.4-0.8,6-2.4l50-50l50,50c1.6,1.6,4,2.4,6,2.4 s4.4-0.8,6-2.4c3.2-3.2,3.2-8.8,0-12L182.4,169.6z"/></svg>
                </div>
            </div>
            <div class="modal-layout">
                <div class="loading-spinner">
                    <div class="loading-spinner__container">
                        <div></div>
                        <div></div>
                        <div>
                            <div></div>
                        </div>
                        <div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="video-content"></div>
            </div>
        </div>
    </div>
@endsection