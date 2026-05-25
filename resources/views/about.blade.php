<section id="about">
  <div class="_split">
    <div class="_texture"></div>
    <div class="_image">
      <img src="{{ Vite::asset('resources/blocks/about/assets/img.jpg') }}" alt="">
    </div>
    <div class="_text">
      <main>
        <div class="_inner">
          <h2>{{ $strings['about']['h2'] }}</h2>
          <div class="_cut -open -disabled">
            <p>{{ $strings['about']['cut'] }}</p>
          </div>
        </div>
      </main>
      <div class="_buttons">
        <button class="_yt" data-modal="#request-modal">{{ $strings['about']['vision'] }}</button>
        <a href="/vesper_book_26.pdf" target="_blank">{{ $strings['about']['presentation'] }}</a>
      </div>
      <ol class="_features">
        <li>{{ $strings['residences']['list.1'] }}</li>
        <li>{{ $strings['residences']['list.2'] }}</li>
        <li>{{ $strings['residences']['list.3'] }}</li>
        <li>{{ $strings['residences']['list.4'] }}</li>
      </ol>
    </div>
  </div>
</section>
<div class="modal" id="arc-modal" data-modal-close>
  <div class="_body">
    <button class="_close close-modal" data-modal-close></button>
    <video id="visVid" src="/vision.mp4" controls>
    </video>
 </div>
</div>
