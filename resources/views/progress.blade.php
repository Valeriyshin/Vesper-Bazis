<section id="progress" data-max="10">
  <div class="_split">
    <div class="_left">
      <h1>{{ $strings['progress']['h1'] }}</h1>
      <div class="circle-container" style="background-image: url({{ route('progress') }})">
        <div class="circle">
          <div class="progress-content">
            <div class="label">{{ $strings['progress']['areas'] }} <br> {{ $strings['progress']['areas.nums'] }}</div>
            <div class="status">{{ $strings['progress']['readiness'] }}</div>
            <div class="percent">{{ $strings['progress']['percentage'] }}%</div>
          </div>
        </div>
      </div>
      <a href="#" data-modal="#progress-modal">{{ $strings['progress']['more'] }}</a>
    </div>
    <div class="_right">
      <h1>{{ $strings['contacts']['h1'] }}</h1>
      <div class="_logos">
        <img src="{{ Vite::asset('resources/blocks/top/assets/vesper.svg') }}" alt="Vesper" class="_vesper -dark">
        <img src="{{ Vite::asset('resources/blocks/progress/assets/bazis.svg') }}" alt="Bazis-A" class="_bazis -dark">
      </div>
      <ul>
        <li class="-point">
          <div>
            <p>{{ $strings['contacts']['h2'] }}</p>
            <p>{{ $strings['contacts']['address'] }}</p>
            <p>{{ $strings['contacts']['tel.caption'] }} <a href="tel:{{ $strings['contacts']['tel.raw'] }}">{{ $strings['contacts']['tel'] }}</a></p>
          </div>
        </li>
      </ul>
      @include('copyright')
    </div>
  </div>
</section>
<div class="modal" id="progress-modal" data-modal-close>
  <div class="_body">
    <button class="_close close-modal" data-modal-close></button>
    <div id="pgm"
         data-lang='@json($strings['progress_modal'])'
         data-milestones='@json(\App\Models\ProgressStage::listing())'
    ></div>
  </div>
</div>
