<nav id="menu" class="top-scroll">
  <div class="container">
    <div class="_langs">
      @if (app()->getLocale() == 'ru')
      <a href="?lang=kk">{{ $strings['menu']['lang.kz'] }}</a>
      <a>{{ $strings['menu']['lang.ru'] }}</a>
      @else
        <a>{{ $strings['menu']['lang.kz'] }}</a>
        <a href="?lang=ru">{{ $strings['menu']['lang.ru'] }}</a>
        @endif
    </div>
    <button class="_switch">
      <span class="_light"></span>
      <span class="_dark"></span>
    </button>
    <hr>
    <a href="#about">{{ $strings['menu']['about'] }}</a>
    <a href="#location">{{ $strings['menu']['location'] }}</a>
    <a href="#architecture">{{ $strings['menu']['architecture'] }}</a>
    <a href="#safety">{{ $strings['menu']['safety'] }}</a>
    <a href="#lobby">{{ $strings['menu']['lobby'] }}</a>
    <a href="#tech">{{ $strings['menu']['tech'] }}</a>
    <a href="#courtyard">{{ $strings['menu']['courtyard'] }}</a>
    <a href="#fc">{{ $strings['menu']['fc'] }}</a>
    <a href="#boulevard">{{ $strings['menu']['boulevard'] }}</a>
    <a href="#avenue">{{ $strings['menu']['avenue'] }}</a>
    <a href="#residences">{{ $strings['menu']['residences'] }}</a>
    <a href="#plans">{{ $strings['menu']['plans'] }}</a>
    <a href="#progress">{{ $strings['menu']['progress'] }}</a>
    <a href="#progress">{{ $strings['menu']['contacts'] }}</a>
    <a href="#" data-modal="#arc-modal">{{ $strings['menu']['vision'] }}</a>
  </div>
</nav>
<div id="menu-overflow"></div>
<div id="top" class="top">
  <div class="container">
    <img src="{{ Vite::asset('resources/blocks/top/assets/bazis-i.svg') }}" alt="Bazis-A" class="_bazis -dark">
    <a href="tel:+7 (727) 2 777 777">+7 (727) 2 777 777</a>
    <img src="{{ Vite::asset('resources/blocks/top/assets/vesper.svg') }}" alt="Vesper" class="_vesper -dark">
    <button class="_yt" data-modal="#request-modal">{{ $strings['about']['vision'] }}</button>
    <button class="menu-trigger">
      <span></span><span></span><span></span>
    </button>
  </div>
</div>
