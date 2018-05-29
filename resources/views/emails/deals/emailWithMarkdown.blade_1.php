@component('mail::message')
 # Email con Markdown

@component('mail::panel')
Body component into panel

![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")
![alt text](https://www.nucleus.be/wp-content/uploads/2018/01/Laravel-780x200.jpg "Logo Title Text 1")
@endcomponent


<dl>
    <dt>Definition list</dt>
    <dd>Is something people use sometimes.</dd>

    <dt>Markdown in HTML</dt>
    <dd>Does *not* work **very** well. Use HTML <em>tags</em>.</dd>
</dl>

@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| ![alt text](https://www.nucleus.be/wp-content/uploads/2018/01/Laravel-780x200.jpg "Logo Title Text 1")      | Centered      | $10      |
| ![alt text](https://www.nucleus.be/wp-content/uploads/2018/01/Laravel-780x200.jpg "Logo Title Text 1")      | Right-Aligned | $20      |
@endcomponent

@component('mail::promotion')
RANDOM-CODE-PROMOTIONAL
@endcomponent

@component('mail::button', ['url' => ''])
Success button
@endcomponent

Thanks,
{{ config('app.name') }}

@endcomponent