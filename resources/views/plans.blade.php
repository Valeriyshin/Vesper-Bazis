<section id="plans"
         data-plans='{{ \App\Models\Apartment::toFront() }}'
         data-lang='@json($strings['plans'])'
         data-last="{{ \App\Models\Apartment::lastTime() }}"
>
</section>
