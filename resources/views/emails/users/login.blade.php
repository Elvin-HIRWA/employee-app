@component('mail::message')
#Hello  

Employee Registered successfully

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
