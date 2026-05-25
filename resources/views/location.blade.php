<section id="location">
  <div class="_text">
    <h2>{{ $strings['location']['h2'] }}</h2>
    <div class="_cut -open -disabled">
      <p>{{ $strings['location']['cut'] }}</p>
    </div>
  </div>
  <div class="ul">
    <div>
      <div class="-at">{{ $strings['location']['map-at'] }}</div>
      <div class="-mu">{{ $strings['location']['map-mu'] }}</div>
      <div class="-gc">{!! $strings['location']['map-gc'] !!}</div>
    </div>
    <div>
      <div class="-fc">{{ $strings['location']['map-fc'] }}</div>
      <div class="-em">{{ $strings['location']['map-em'] }}</div>
    </div>
  </div>
  <div class="_map">
    <div class="_pin -at"></div>
    <div class="_pin -mu"></div>
    <div class="_pin -gc"></div>
    <div class="_pin -fc"></div>
    <div class="_pin -em"></div>
    <img src="{{ Vite::asset('resources/blocks/location/assets/map-l.svg') }}" alt="">
  </div>
  <div class="_texture"></div>
</section>
