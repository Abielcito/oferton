@component('mail::message')
#Mejores Ofertas del Dia

@component('mail::panel')
![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")
@endcomponent


<dl>
    <dt>Deseas obtener las mejores ofertas en tiempo real</dt>
    <dd>haz click en el boton.</dd>
    @component('mail::button', ['url' => ''])
    Success button
    @endcomponent
</dl>

@component('mail::table')
{!! $params['dealsTable'] !!}
@endcomponent

Gracias,
{{ config('app.name') }}

@endcomponent