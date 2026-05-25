<ul class="points">
  <li id="architecture">
    <div class="_pic">
      <img src="{{ Vite::asset('resources/blocks/points/assets/ta.jpg') }}" alt="">
    </div>
    <div class="_text">
      <div class="caption">{{ $strings['architecture']['caption'] }}</div>
      <div class="_cut -open -disabled">
        <p>{{ $strings['architecture']['cut'] }}</p>
      </div>
    </div>
  </li>
  <li id="safety">
    <div class="_pic">
      <img src="{{ Vite::asset('resources/blocks/points/assets/2.jpg') }}" alt="">
    </div>
    <div class="_text">
      <p>{!! nl2br(e($strings['safety']['text'])) !!}</p>
    </div>
  </li>
  <li id="calm">
    <div class="_point">{{ $strings['safety']['01'] }}</div>
    <div class="_point">{{ $strings['safety']['02'] }}</div>
    <div class="_point">{{ $strings['safety']['03'] }}</div>
    <h2>{{ $strings['safety']['parking'] }}</h2>
    <div class="_point">{{ $strings['safety']['04'] }}</div>
    <div class="_point">{{ $strings['safety']['05'] }}</div>
    <h2>{{ $strings['safety']['lifts'] }}</h2>
    <div class="_point">{{ $strings['safety']['07'] }}</div>
  </li>
  <li id="lobby">
    <div class="caption">{{ $strings['lobby']['caption'] }}</div>
    <strong class="text-right">{{ $strings['lobby']['h1'] }}
      <sub>{{ $strings['lobby']['h2'] }}</sub>
    </strong>
    <div class="_pic">
      <img
        src="{{ Vite::asset('resources/blocks/points/assets/lobby/2.jpg') }}"
        alt="">
    </div>
    <div class="_text">
      <strong class="text-right">{{ $strings['lobby']['h1'] }}
        <sub>{{ $strings['lobby']['h2'] }}</sub>
      </strong>
      <div class="caption">{{ $strings['lobby']['caption'] }}</div>
      <div class="_cut -open -disabled">
        <p>{{ $strings['lobby']['cut'] }}</p>
      </div>
      <ul>
        <li>{{ $strings['lobby']['list.1'] }}</li>
        <li>{{ $strings['lobby']['list.2'] }}</li>
        <li>{{ $strings['lobby']['list.3'] }}</li>
        <li>{{ $strings['lobby']['list.4'] }}</li>
      </ul>
    </div>
  </li>
  <li id="tech">
    <strong class="text-right -bottom -pcleft">{{ $strings['tech']['h1'] }}
      <sub>{{ $strings['tech']['h2'] }}</sub>
    </strong>
    <ol>
      <li>{{ $strings['tech']['list.1'] }}</li>
      <li>{{ $strings['tech']['list.2'] }}</li>
      <li>{{ $strings['tech']['list.3'] }}</li>
      <li>{{ $strings['tech']['list.4'] }}</li>
    </ol>
  </li>
  <li id="courtyard">
    <div class="_pic">
      <div class="_yard">
        <div>
          <img src="{{ Vite::asset('resources/blocks/points/assets/yard/1.jpg') }}" alt="">
        </div>
        <div>
          <img src="{{ Vite::asset('resources/blocks/points/assets/yard/2.jpg') }}" alt="">
        </div>
        <div>
          <img src="{{ Vite::asset('resources/blocks/points/assets/yard/3.jpg') }}" alt="">
        </div>
      </div>
    </div>
    <div class="_text">
      <div class="caption">{{ $strings['courtyard']['caption'] }}</div>
      <div class="_cut -open -disabled">
        <p>{{ $strings['courtyard']['cut'] }}</p>
      </div>
    </div>
  </li>
  <li id="boulevard">
    <div class="_pic">
      <img src="{{ Vite::asset('resources/blocks/points/assets/5.jpg') }}" alt="">
    </div>
    <div class="_text">
      <p>{!! nl2br(e($strings['boulevard']['text'])) !!}</p>
      <div class="caption">{{ $strings['boulevard']['caption'] }}</div>
    </div>
  </li>
  <li id="avenue">
    <div class="caption">{{ $strings['avenue']['caption'] }}</div>
    <div class="_pic">
      <img src="{{ Vite::asset('resources/blocks/points/assets/6.jpg') }}" alt="">
    </div>
    <p>{!! nl2br(e($strings['avenue']['text'])) !!}</p>
  </li>
  <li id="fc">
    <div class="caption">{{ $strings['family_club']['caption'] }}</div>
    <div class="_text">
      <h1>{{ $strings['family_club']['h1'] }}</h1>
      <p>{{ $strings['family_club']['text'] }}</p>
      @php($fc=\App\Models\FamilyClub::listing())
      <div class="_captions">
        @foreach($fc as $item)
          <p>{!! nl2br(e($item->text)) !!}</p>
        @endforeach
      </div>
    </div>
    <div class="_fc-images">
      @foreach($fc as $item)
        <img src="/storage/{{ $item->image }}" alt="">
      @endforeach
    </div>
  </li>
  <li id="residences">
    <div class="caption">{{ $strings['residences']['caption'] }}</div>
    <div class="_pic">
      <strong>{{ $strings['residences']['h1'] }}</strong>
      <img src="{{ Vite::asset('resources/blocks/points/assets/sc.jpg') }}" alt="">
    </div>
    <div class="text">
      <h1>{{ $strings['residences']['h1'] }}</h1>
      <div class="_cut">
        <button title="раскрыть"></button>
        <p>
          {{ $strings['residences']['cut'] }}
        </p>
        <div class="_hidden">
          <p>{!! nl2br(e($strings['residences']['cut.hidden'])) !!}</p>
        </div>
      </div>
      @include('points.res-list')
    </div>
    @include('points.res-list')
  </li>
</ul>
