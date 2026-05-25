<section id="plans">
  <div class="caption">the residences at vesper</div>
  <h1>Планировочные решения</h1>
  <div class="_filters">
    <div class="_rooms">
      <p>КОЛИЧЕСТВО КОМНАТ</p>
      <div class="_list">
        @for($i=1;$i<=4;$i++)
          <label>
            <input type="checkbox" name="rooms" value="{{$i}}" {{$i<3?'checked':''}}><span>{{$i}}</span>
          </label>
        @endfor
      </div>
    </div>
    <div class="_more">Ещё настройки</div>
  </div>
  <ul class="_results">
    @for($i=0;$i<7;$i++)
      <li>
        <div class="_plan">
          <img src="/storage/sample/sample.svg" alt="">
        </div>
        <div class="_info">
          <strong>4-комнатная, 172м²</strong>
          <table>
            <tr>
              <th>Площадь</th>
              <td>172 м²</td>
            </tr>
            <tr>
              <th>Цена м²</th>
              <td>от 1.005.000 тг</td>
            </tr>
            <tr>
              <th>Этаж</th>
              <td>2</td>
            </tr>
            <tr>
              <th>Кв. №</th>
              <td>1</td>
            </tr>
            <tr>
              <th>Пятно</th>
              <td>5</td>
            </tr>
          </table>
          <button>ЗАБРОНИРОВАТЬ</button>
        </div>
      </li>
    @endfor
  </ul>
</section>
