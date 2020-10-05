{{-- Simditor --}}
@if (config('settings.single.simditor_wysiwyg'))
    <link media="all" rel="stylesheet" type="text/css" href="{{ asset(config('app.cloud_url').'/assets/plugins/simditor/styles/simditor.css') }}" />
@endif

{{-- CKEditor --}}
{{-- Use this plugin by deactiving the "Simditor WYSIWYG Editor" --}}
@if (!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg'))
    {{-- ... --}}
@endif
