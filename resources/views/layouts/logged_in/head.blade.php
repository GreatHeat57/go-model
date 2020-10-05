{{-- Html::style(mix('/css/app_user.css')) --}}
{{ Html::style(config('app.cloud_url').'/css/app_user.css') }}
{{ Html::style(config('app.cloud_url').'/assets/croppie/croppie.min.css') }}
{{ Html::style(config('app.cloud_url').'/assets/css/font-awesome.min.css') }}
{{ Html::style(config('app.cloud_url').'/css/formValidator.css') }}
@stack('head')