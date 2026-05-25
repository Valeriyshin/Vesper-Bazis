@php
  $total = 503.9115+756.8672;
  $fill = $total * $progress / 100;
  $space = $total - $fill;
@endphp
<svg width="411" height="411" viewBox="0 0 411 411" xmlns="http://www.w3.org/2000/svg">
  <circle
    cx="205.5" cy="205.5" r="193"
    fill="none"
    stroke="#99C0E5"
    stroke-width="25"
    stroke-dasharray="{{ printf('%.4f %.4f', $fill, $space) }}"
    transform="rotate(-90 205.5 205.5)"
  />
</svg>

