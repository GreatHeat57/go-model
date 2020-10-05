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
						<h2 class="title-2"><i class="icon-town-hall"></i> {{ t('My model profile') }} </h2>

						<div class="paragraph">
							<h4><i class="icon-graduation-cap"></i> {{ t('Education') }} </h4>

							<table class="table">
								<thead>
									<tr>
										<th style="width:40%">{{t('Qualification')}}</th>
										<th style="width:20%">{{t('Dates')}}</th>
										<th style="width:30%">{{t('School / Colleges')}}</th>
										<th style="width:10%"></th>
									</tr>
								</thead>
								<tbody>
									<?php
if (isset($education) && sizeof($education) > 0):
	foreach ($education as $key => $edu):
	?>
										<tr>
											<td>{{$edu['title']}}</td>
											@php
												if(!isset($edu['up_to_date']) || $edu['up_to_date']=='1')
												{
													$to_date=date('Y-m-d');
												}
												else
												{
													$to_date=$edu['to'];
												}
											@endphp
											<td>{{date("Y", strtotime($edu['from']))}} - {{date("Y", strtotime($to_date))}}</td>
											<td>{{$edu['institute']}}</td>
											<td>
												<a href="{{ lurl('account/profile/education/'.$key.'/edit') }}"><i class="fa fa-edit"></i></a>
												<a href="{{ lurl('account/profile/education/'.$key.'/delete') }}"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										<?php endforeach;?>
									<?php else: ?>
									<tr>
										<td>{{t('There are no educations yet')}}</td>
									</tr>
									<?php endif;?>
								</tbody>
							</table>

							<a href="{{ lurl('account/profile/education/create') }}">+ {{ t('Add new') }}</a>

						</div>

						<div style="padding-bottom: 15px"></div>

						<div class="paragraph">
							<h4><i class="icon-briefcase"></i> {{ t('Experiences in the model business') }} </h4>

							<table class="table">
								<thead>
									<tr>
										<th style="width:50%">{{t('JObs / Clients')}}</th>
										<th style="width:40%">{{t('Dates')}}</th>
										<th style="width:10%"></th>
									</tr>
								</thead>
								<tbody>
									<?php
if (isset($experience) && sizeof($experience) > 0):
	foreach ($experience as $key => $exp):
	?>
										<tr>
											<td>{{$exp['title']}} @ {{$exp['company']}}</td>
											@php
													if(!isset($exp['up_to_date']) || $exp['up_to_date']=='1')
													{
														 $to_date=date('Y-m-d');
													}
													else
													{
														$to_date=$exp['to'];
													}

											@endphp
											<td>{{date("Y", strtotime($exp['from']))}} - {{date("Y", strtotime($to_date))}}</td>
											<td>
												<a href="{{ lurl('account/profile/experience/'.$key.'/edit') }}"><i class="fa fa-edit"></i></a>
												<a href="{{ lurl('account/profile/experience/'.$key.'/delete') }}"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										<?php endforeach;?>
									<?php else: ?>
									<tr>
										<td>{{t('There are no experiences yet')}}</td>
									</tr>
									<?php endif;?>
								</tbody>
							</table>

							<a href="{{ lurl('account/profile/experience/create') }}">+ {{ t('Add new') }}</a>

						</div>

						<div style="padding-bottom: 15px"></div>

						<div class="paragraph">

							<h4><i class="icon-eye"></i> {{ t('Talents') }} </h4>

							<table class="table">
								<thead>
									<tr>
										<th style="width:50%">{{t('What can I do best?')}}</th>
										<th style="width:40%">{{t('Level')}}</th>
										<th style="width:10%"></th>
									</tr>
								</thead>
								<tbody>
									<?php
if (isset($talent) && sizeof($talent) > 0):
	foreach ($talent as $key => $exp):
	?>
										<tr>
											<td>{{$exp['title']}}</td>
											<td>{{$exp['proportion']}}</td>
											<td>
												<a href="{{ lurl('account/profile/talent/'.$key.'/edit') }}"><i class="fa fa-edit"></i></a>
												<a href="{{ lurl('account/profile/talent/'.$key.'/delete') }}"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										<?php endforeach;?>
									<?php else: ?>
									<tr>
										<td>{{t('There are no talents yet')}}</td>
									</tr>
									<?php endif;?>
								</tbody>
							</table>

							<a href="{{ lurl('account/profile/talent/create') }}">+ {{ t('Add new') }}</a>

						</div>

						<div style="padding-bottom: 15px"></div>

						<div class="paragraph">

							<h4><i class="icon-trophy"></i> {{ t('Achievements / References') }} </h4>

							<table class="table">
								<thead>
									<tr>
										<th style="width:50%">{{t('Achievements / References')}}</th>
										<th style="width:40%">{{t('Dates')}}</th>
										<th style="width:10%"></th>
									</tr>
								</thead>
								<tbody>
									<?php
if (isset($reference) && sizeof($reference) > 0):
	foreach ($reference as $key => $ref):
	?>
										<tr>
											<td>{{$ref['title']}}</td>
											<td>{{date("Y", strtotime($ref['date']))}}</td>
											<td>
												<a href="{{ lurl('account/profile/reference/'.$key.'/edit') }}"><i class="fa fa-edit"></i></a>
												<a href="{{ lurl('account/profile/reference/'.$key.'/delete') }}"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										<?php endforeach;?>
									<?php else: ?>
									<tr>
										<td>{{t('There are no achievements / references')}}</td>
									</tr>
									<?php endif;?>
								</tbody>
							</table>

							<a href="{{ lurl('account/profile/reference/create') }}">+ {{ t('Add new') }}</a>

						</div>

						<div style="padding-bottom: 15px"></div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_styles')
	<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	<link media="all" rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/assets/plugins/simditor/styles/simditor.css') }}" />
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.paragraph {
			padding: 10px 20px;
			background: #F8F8F8;
		}
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
@endsection
