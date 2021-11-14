@component('mail::message')

# Code de confirmation

{{ DB::table('password_resets')->where('email', Request::get('email'))->first()->token }}

Merci à vous,<br>
Sangdon
@endcomponent