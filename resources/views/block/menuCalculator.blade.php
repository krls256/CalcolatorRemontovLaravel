@if ( !isset($menu) )
    <div class="boxes">
        <ul class="left-menu">
            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Простой</a></li>
            <?php /*<li class="{{ Request::is('amateur') ? 'active' : '' }}"><a href="/amateur">Любительский</a></li> */ ?>
            <li class="{{ Request::is('professional') ? 'active' : '' }}"><a href="/professional">Профессиональный</a></li>
        </ul>
    </div>
@endif 

@if ( !isset($info) )
    <div class="boxes">
        <div class="boxes__header">
            <i class="boxes__img-blue icon-question"></i>
            {{ $title }}
        </div>
        <div class="boxes__content">
            <div class="p">
                {{ $slot }}
            </div>
        </div>
    </div>
@endif 