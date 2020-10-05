<div class="bg-white box-shadow bottom-bar">
    <div class="d-flex justify-content-center align-items-center container px-0">

    	@if (getSegment(2) == 'create')
		    <a id="skipBtn" href="{{ lurl('posts/create/' . $post->tmp_token . '/finish') }}" class="btn btn-success mini-mobile mr-20">{{ t('Skip') }}</a>
		@else
		    <a id="skipBtn" href="{{ lurl($post->uri) }}" class="btn btn-success mini-mobile mr-20">{{ t('Skip') }}</a>
		@endif

        <button id="submitPostForm" class="btn btn-white mini-mobile submitPostForm">{{ t('Pay') }}</a>
    </div>
</div>


