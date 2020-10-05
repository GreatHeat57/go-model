{{--
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@section('content')
	@include('common.spacer')
	<?php

if (isset($data)) {
	$sedcards = $data[0];
	$sedcard_5 = $data[1];
}

?>
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (Session::has('flash_notification'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-sm-3 page-sidebar">
					@include('account.inc.sidebar')
				</div>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-town-hall"></i> {{ t('My sedcards') }} </h2>
						 <div class="mb30">
							<a href="{{ lurl('account/sedcards/create/'.$countSedcard) }}" class="btn btn-default"><i class="icon-plus"></i> {{ t('Add a new sedcard') }}</a>
						</div>
						<br>

						<div class="table-responsive">
							<form name="listForm" method="POST" action="{{ lurl('account/sedcards/delete') }}">
								{!! csrf_field() !!}
								<div class="table-action">
									<label for="checkAll">
										<input type="checkbox" id="checkAll">
										{{ t('Select') }}: {{ t('All') }} |
										<button type="submit" class="btn btn-sm btn-default delete-action">
											<i class="fa fa-trash"></i> {{ t('Delete') }}
										</button>
									</label>
									<!-- <div class="table-search pull-right col-xs-7">
										<div class="form-group">
											<label class="col-xs-5 control-label text-right">{{ t('Search') }} <br>
												<a title="clear filter" class="clear-filter" href="#clear">[{{ t('clear') }}]</a> </label>
											<div class="col-xs-7 searchpan">
												<input type="text" class="form-control" id="filter">
											</div>
										</div>
									</div> -->
								</div>
								<table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo"
									   data-filter="#filter" data-filter-text-only="true">
									<thead>
									<tr>
										<th data-type="numeric" data-sort-initial="true"></th>
										<th> {{ t('File') }}</th>
										<th data-sort-ignore="true"> {{ t('Name') }} </th>
										<th> {{ t('Option') }}</th>
									</tr>
									</thead>
									<tbody>

									<?php
if (isset($sedcards) && count($sedcard_5) > 0):

	foreach ($sedcard_5 as $key => $sedcard):
	?>
																<tr>
																	<td style="width:2%" class="add-img-selector">
																		<div class="checkbox">

																			<label>
																				@if ($sedcard['id']!=0)
																				<input type="checkbox" name="entries[]" value="{{ $sedcard['id'] }}">
																				@endif
																			</label>
																		</div>
																	</td>
																	<td style="width:14%" class="add-img-td">
																		<?php if ($sedcard['id'] != 0) {?>
																		<?php if ($sedcard['cropped_image'] == "") {?>
																		<img src="{{ \Storage::url($sedcard['filename']) }}" height="100px" width="100px">
																		<?php } elseif ($sedcard['filename'] != "") {?>
											<img src="<?php echo url(config('filesystems.default') . '/' . str_replace("uploads", "", $sedcard['cropped_image'])); ?>" height="100px" width="100px">
											<?php }?>
											<?php } else {?>
											<img src="<?php echo url('/images/user.jpg'); ?>" height="100px" width="100px">
											<?php }?>
										</td>
										<td style="width:58%" class="ads-details-td">
											<div>

											<?php if ($sedcard['image_type'] == 1) {?>
												<h4>{{ t('Portrait photo') }}</h4>
												<p>{{ t('Upload here a nice portrait photo of you, where you are easy to recognize! (No sunglasses, hat etc)') }}</p>
											<?php } else if ($sedcard['image_type'] == 2) {?>
												<h4>{{ t('Whole body photo') }}</h4>
												<p>{{ t('Upload a frontal full body photo of you here') }}</p>
											<?php } else if ($sedcard['image_type'] == 3) {?>
											    <h4>{{ t('Beauty Shot') }}</h4>
											    <p>{{ t('For women: Upload a photo of yourself with make-up or another hairstyle here, For men: Here you can upload a picture with styled hair or another hairstyle, For baby; Kindermodels: Either a happy, smiling portrait photo or with a different hairstyle (curls, hair accessories etc)') }}</p>
											<?php } else if ($sedcard['image_type'] == 4) {?>
											   <h4>{{ t('Outfit') }}</h4>
											  <p>{{ t('Upload a photo here with a stylish outfit') }}</p>
											<?php } else if ($sedcard['image_type'] == 5) {?>
												<h4>{{ t('Free choice') }}</h4>
												<p>{{ t('Here you can upload a favorite photo of your choice, Tip: A photo of your facial profile (your face from the side), For baby models: A picture with the mother') }}</p>
											<?php }?>
											</div>
										</td>
										<td style="width:10%" class="action-td">
											<div>
												@if ($sedcard['user_id']==$user->id AND $sedcard['id']!=0)
													<p>
														<a class="btn btn-primary btn-sm" href="{{ lurl('account/sedcards/' . $sedcard['id'] . '/edit') }}">
															<i class="fa fa-edit"></i> {{ t('Edit') }}
														</a>
													</p>
													<!-- <p>
														<a class="btn btn-danger btn-sm delete-action" href="{{ lurl('account/sedcards/'.$sedcard['id'].'/delete') }}">
															<i class="fa fa-trash"></i> {{ t('Delete') }}
														</a>
													</p> -->
												@endif

												@if ($sedcard['id']==0)
													<p>
														<a class="btn btn-primary btn-sm" href="{{ lurl('account/sedcards/create') }}/<?php echo $sedcard['image_type']; ?>">
															<i class="fa fa-edit"></i> {{ t('Upload') }}
														</a>
													</p>
												@endif
											</div>
										</td>
									</tr>
									<?php endforeach;?>
									<?php endif;?>
									</tbody>
								</table>
							</form>
						</div>
						<?php if (count($sedcard_5) > 0) {?>
						<!-- ADDED BY EXPERT TEAM -->
						<div class="genrate-sedcard">
							<p>
								<a class="btn btn-primary btn-sm" href="{{ lurl('account/sedcards/genrate/') }}/<?php echo $user->id; ?>">
								  {{ t('GenrateSedcard') }}
								</a>
								<a class="btn btn-primary btn-sm" href="{{ lurl('account/'.$user->id.'/downloadsdcard') }}">
								  {{ t('Download Sedcard') }}
								</a>
							</p>
						</div>
						<?php }?>
						<!-- ENDED BY EXPERT TEAM -->
						<div class="pagination-bar text-center">
							{{ (isset($sedcards)) ? $sedcards->links() : '' }}
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

			$('#checkAll').click(function () {
				checkAll(this);
			});

			$('a.delete-action, button.delete-action').click(function(e)
			{
				e.preventDefault(); /* prevents the submit or reload */
				var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");

				if (confirmation) {
					if( $(this).is('a') ){
						var url = $(this).attr('href');
						if (url !== 'undefined') {
							redirect(url);
						}
					} else {
						$('form[name=listForm]').submit();
					}

				}

				return false;
			});
		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
@endsection
