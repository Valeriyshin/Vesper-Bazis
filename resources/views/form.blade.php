<form action="{{ route('flat') }}" {{ ($id ?? false) ? 'id='.$id:'' }} class="simple-form">
  @csrf
  <div class="_text">
    <h1>{{ $strings['form']['h1'] }}</h1>
    <h2>{{ $strings['form']['h2'] }}</h2>
    <p class="-dt">
      {{ $strings['form']['agreement.a'] }}
      <a href="https://sales.bazis.kz/privacy-policy" target="_blank">{{ $strings['form']['agreement.link'] }}</a>
      {{ $strings['form']['agreement.b'] }}
    </p>
  </div>
  <div class="_fields">
    <div class="_inputs">
      <input type="text" name="name" autocomplete="name" placeholder="{{ $strings['form']['name'] }}" required>
      <input type="text"
             name="phone" autocomplete="phone"
             placeholder="+7(" pattern="\+7 \(7\d{2}\) \d{3}-\d{2}-\d{2}" required>
    </div>
    <button>{{ $strings['form']['button'] }}</button>
  </div>
  <p class="-mob">
    {{ $strings['form']['agreement.a'] }}
    <a href="https://sales.bazis.kz/privacy-policy" target="_blank">{{ $strings['form']['agreement.link'] }}</a>
    {{ $strings['form']['agreement.b'] }}
  </p>
</form>
