@extends('layouts.app')

@section('content')
	<div class="faqpage_container">
	    {{-- {!! trans('frontPage.faq_content') !!} --}}
	    {!! $page->content !!}
	</div>
@endsection

@push('scripts')
    <script>
        $('body').on('click','.faq-nav a',function(e){
            $('html,body').animate({scrollTop: $("#"+$(this).attr('href').replace('#','')).offset().top},'fast');
            e.preventDefault();
        });
    </script>
@endpush