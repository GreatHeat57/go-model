<div class="modal fade" id="termPopup" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; z-index: 999999;">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				@if (empty($page->picture))
				<div class="container px-0 pt-20">
					<h1 class="text-center prata" style="color:<?php if (!empty($page) && !empty($page->name_color)) {echo $page->name_color;}?>"><strong>{{ $page->name }}</strong></h1>
					<div class="divider mx-auto" wfd-id="109"></div>
				</div>
				@endif
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">{{ t('Close') }}</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 page-content">
						@if (empty($page->picture))
							<h2 class="text-center w-lg-596 mx-lg-auto" style="text-align: center; color: {!! $page->title_color !!};">{{ $page->title }}</h2>
						@endif
						<div class="text-content text-left from-wysiwyg">
							{!! $page->content !!}
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success save" data-dismiss="modal">{{ t('OK') }}</button>
			</div>
		</div>
	</div>
</div>
<style>
	.modal-body p {
		text-align: justify;
		font-size: 15px;
		font-family: "work_sansregular", Arial, Tahoma;
	}
</style>
