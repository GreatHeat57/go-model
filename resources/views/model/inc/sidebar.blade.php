<!-- this (.mobile-filter-sidebar) part will be position fixed in mobile version -->
<?php
	$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
    $tmpExplode = explode('?', $fullUrl);
    $fullUrlNoParams = current($tmpExplode);
    echo $fullUrlNoParams;
?>
<div class="col-sm-3 page-sidebar mobile-filter-sidebar" style="padding-bottom: 20px;">
	<aside>
		<div class="inner-box enable-long-words">
			<!-- Date -->
			
			<form role="form" class="form-inline" action="{{ $fullUrlNoParams }}" method="GET">
				{!! csrf_field() !!}
			<div class="list-filter">
				<h5 class="list-title"><strong><a href="#"> {{ t('Last Activity') }} </a></strong></h5>
				<div class="filter-date filter-content">
					<ul>
						@if (isset($dates) and !empty($dates))
							@foreach($dates as $key => $value)
							<li>
								<input type="radio" name="lastActivity" value="{{ $key }}" id="lastActivity_{{ $key }}" {{ (Request::get('lastActivity')==$key) ? 'checked="checked"' : '' }}>
								<label for="lastActivity_{{ $key }}">{{ $value }}</label>
							</li>
							@endforeach
						@endif
						<input type="hidden" id="postedQueryString" value="{{ httpBuildQuery(Request::except(['lastActivity'])) }}">
					</ul>
				</div>
			</div>
			
			<!-- eyeColor -->
			<div class="list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Eye color') }}</a></strong></h5>
				<div class="filter-content filter-employment-type">
					<ul id="blocEyeColor" class="browse-list list-unstyled">
						@if (isset($eyeColors) and !empty($eyeColors))
							@foreach($eyeColors as $key => $eyeColor)
								<li>
									<input type="radio" name="eyeColor" id="employment_{{ $key }}" value="{{ $key }}" class="emp emp-type" {{ (Request::get('eyeColor')==$key) ? 'checked="checked"' : '' }}>
									<label for="employment_{{ $key }}">{{ $eyeColor }}</label>
								</li>
							@endforeach
						@endif
						<input type="hidden" id="eyeColorQueryString" value="{{ httpBuildQuery(Request::except(['type'])) }}">
					</ul>
				</div>
			</div>

			<!-- Gender -->
			<div class="list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Gender') }}</a></strong></h5>
				<div class="filter-content filter-employment-type">
					<ul id="gender_value" class="browse-list list-unstyled">
								<li>
									<input type="radio" name="gender_id"  value="0" class="emp gender" {{ (Request::get('gender_id')=='0') ? 'checked="checked"' : '' }}>
									<label for="gender_male }}">{{ t('Male') }}</label>
								</li>
								<li>
									<input type="radio" name="gender_id"  value="1" class="emp gender" {{ (Request::get('gender_id')=='1') ? 'checked="checked"' : '' }}>
									<label for="gender_female">{{ t('Female') }}</label>
								</li>
							
						<input type="hidden" id="genderQueryString" value="{{ httpBuildQuery(Request::except(['type'])) }}">
					</ul>
				</div>
			</div>

			<!-- skinColor -->
			<div class="list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Skin color') }}</a></strong></h5>
				<div class="filter-content filter-employment-type">
					<ul id="blocSkinColor" class="browse-list list-unstyled">
						@if (isset($skinColors) and !empty($skinColors))
							@foreach($skinColors as $key => $skinColor)
								<li>
									<input type="radio" name="skinColor" id="employment_{{ $key }}" value="{{ $key }}" class="emp emp-type" {{ (Request::get('skinColor')==$key) ? 'checked="checked"' : '' }}>
									<label for="employment_{{ $key }}">{{ $skinColor }}</label>
								</li>
							@endforeach
						@endif
						<input type="hidden" id="skinColorQueryString" value="{{ httpBuildQuery(Request::except(['type'])) }}">
					</ul>
				</div>
			</div>

			<!-- hairColor -->
			<div class="list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Hair color') }}</a></strong></h5>
				<div class="filter-content filter-employment-type">
					<ul id="blocHairColor" class="browse-list list-unstyled">
						@if (isset($hairColors) and !empty($hairColors))
							@foreach($hairColors as $key => $hairColor)
								<li>
									<input type="radio" name="hairColor" id="employment_{{ $key }}" value="{{ $key }}" class="emp emp-type" {{ (Request::get('hairColor')==$key) ? 'checked="checked"' : '' }}>
									<label for="employment_{{ $key }}">{{ $hairColor }}</label>
								</li>
							@endforeach
						@endif
						<input type="hidden" id="hairColorQueryString" value="{{ httpBuildQuery(Request::except(['type'])) }}">
					</ul>
				</div>
			</div>


				<!-- Height -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Height') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minHeight" id="minHeight" class="form-control">
									<option value=""></option>
									@foreach($properties['height'] as $key => $height)
										<option value="{{ $key }}" {{ (Request::get('minHeight')==$key) ? 'selected' : '' }}>{{ $height }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxHeight" id="maxHeight" class="form-control">
									<option value=""></option>
									@foreach($properties['height'] as $key => $height)
										<option value="{{ $key }}" {{ (Request::get('maxHeight')==$key) ? 'selected' : '' }}>{{ $height }}</option>
									@endforeach
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<!-- Weight -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Weight') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minWeight" id="minWeight" class="form-control">
									<option value=""></option>
									@foreach($properties['weight'] as $key => $weight)
										<option value="{{ $key }}" {{ (Request::get('minWeight')==$key) ? 'selected' : '' }}>{{ $weight }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxWeight" id="maxWeight" class="form-control">
									<option value=""></option>
									@foreach($properties['weight'] as $key => $weight)
										<option value="{{ $key }}" {{ (Request::get('maxWeight')==$key) ? 'selected' : '' }}>{{ $weight }}</option>
									@endforeach
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<!-- Chest -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Chest') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minChest" id="minChest" class="form-control">
									<option value=""></option>
									@for($i = 50; $i < 151; $i++)
										<option value="{{ $i }}" {{ (Request::get('minChest')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxChest" id="maxChest" class="form-control">
									<option value=""></option>
									@for($i = 50; $i < 151; $i++)
										<option value="{{ $i }}" {{ (Request::get('minChest')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<!-- Waist -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Waist') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minWaist" id="minWaist" class="form-control">
									<option value=""></option>
									@for($i = 50; $i < 151; $i++)
										<option value="{{ $i }}" {{ (Request::get('minWaist')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxWaist" id="maxWaist" class="form-control">
									<option value=""></option>
									@for($i = 50; $i < 151; $i++)
										<option value="{{ $i }}" {{ (Request::get('maxWaist')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<!-- Hips -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Hips') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minHips" id="minHips" class="form-control">
									<option value=""></option>
									@for($i = 60; $i < 151; $i++)
										<option value="{{ $i }}" {{ (Request::get('minHips')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxHips" id="maxHips" class="form-control">
									<option value=""></option>
									@for($i = 60; $i < 151; $i++)
										<option value="{{ $i }}" {{ (Request::get('maxHips')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<!-- Dress size -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Dress size') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minDressSize" id="minDressSize" class="form-control">
									<option value=""></option>
									@foreach($properties['dress_size'] as $key => $dressSize)
										<option value="{{ $key }}" {{ (Request::get('minDressSize')==$key) ? 'selected' : '' }}>{{ $dressSize }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxDressSize" id="maxDressSize" class="form-control">
									<option value=""></option>
									@foreach($properties['dress_size'] as $key => $dressSize)
										<option value="{{ $key }}" {{ (Request::get('maxDressSize')==$key) ? 'selected' : '' }}>{{ $dressSize }}</option>
									@endforeach
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<!-- Shoe size -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Shoe size') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minShoeSize" id="minShoeSize" class="form-control">
									<option value=""></option>
									@foreach($properties['shoe_size'] as $key => $shoeSize)
										<option value="{{ $key }}" {{ (Request::get('minShoeSize')==$key) ? 'selected' : '' }}>{{ $shoeSize }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxShoeSize" id="maxShoeSize" class="form-control">
									<option value=""></option>
									@foreach($properties['shoe_size'] as $key => $shoeSize)
										<option value="{{ $key }}" {{ (Request::get('maxShoeSize')==$key) ? 'selected' : '' }}>{{ $shoeSize }}</option>
									@endforeach
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<!-- Age -->
				<div class="list-filter">
					<h5 class="list-title"><strong><a href="#">{{ t('Age') }}</a></strong></h5>
					<div class="filter-salary filter-content ">
							<div class="form-group col-sm-5 no-padding">
								<select name="minAge" id="minAge" class="form-control">
									<option value=""></option>
									@for($i = 1; $i < 101; $i++)
										<option value="{{ $i }}" {{ (Request::get('minAge')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
							<div class="form-group col-sm-1 no-padding text-center hidden-xs"> -</div>
							<div class="form-group col-sm-5 no-padding">
								<select name="maxAge" id="maxAge" class="form-control">
									<option value=""></option>
									@for($i = 1; $i < 101; $i++)
										<option value="{{ $i }}" {{ (Request::get('maxAge')==$i) ? 'selected' : '' }}>{{ $i }}</option>
									@endfor
								</select>
							</div>
						<div class="clearfix"></div>
					</div>
					<div style="clear:both"></div>
				</div>

				<div style="padding-bottom: 10px"></div>

				<div class="list-filter">
					<div class="form-group col-sm-11 no-padding">
						<button class="btn btn-block btn-primary" onclick="search()">
							<i class="fa fa-search"></i> <strong>{{ t('Search') }}</strong>
						</button>
					</div>
				</div>

			</form>

			<div style="clear:both"></div>
		</div>
		
	</aside>
</div>

@section('after_styles')
	<style>
		@media (min-width: 768px){
			.form-inline .form-control {
				width: 100%;
			}
		}
	</style>
@endsection

@section('after_scripts')
	@parent
	<script>
		var baseUrl = '{{ $fullUrlNoParams }}';

		function search ()
		{

			alert();
			return false;
			
			$('input[type=radio][name=lastActivity]').click(function() {
				var postedQueryString = $('#postedQueryString').val();
				
				if (postedQueryString != '') {
					postedQueryString = postedQueryString + '&';
				}
				postedQueryString = postedQueryString + 'lastActivity=' + $(this).val();

				var searchUrl = baseUrl + '?' + postedQueryString;
				redirect(searchUrl);
			});

			$('#blocEyeColor input[type=radio]').click(function() {
				var eyeColorQueryString = $('#eyeColorQueryString').val();

				if (eyeColorQueryString != '') {
					eyeColorQueryString = eyeColorQueryString + '&';
				}
				eyeColorQueryString = eyeColorQueryString + 'eyeColor=' + $(this).val();

				var searchUrl = baseUrl + '?' + eyeColorQueryString;
				redirect(searchUrl);
			});

			$('#gender_value input[type=radio]').click(function() {
				var genderQueryString = $('#genderQueryString').val();

				if (genderQueryString != '') {
					genderQueryString = genderQueryString + '&';
				}
				genderQueryString = genderQueryString + 'gender_id=' + $(this).val();

				var searchUrl = baseUrl + '?' + genderQueryString;
				redirect(searchUrl);
			});

			$('#blocSkinColor input[type=radio]').click(function() {
				var skinColorQueryString = $('#skinColorQueryString').val();

				if (skinColorQueryString != '') {
					skinColorQueryString = skinColorQueryString + '&';
				}
				skinColorQueryString = skinColorQueryString + 'skinColor=' + $(this).val();

				var searchUrl = baseUrl + '?' + skinColorQueryString;
				redirect(searchUrl);
			});

			$('#blocHairColor input[type=radio]').click(function() {
				var hairColorQueryString = $('#hairColorQueryString').val();

				if (hairColorQueryString != '') {
					hairColorQueryString = hairColorQueryString + '&';
				}
				hairColorQueryString = hairColorQueryString + 'hairColor=' + $(this).val();

				var searchUrl = baseUrl + '?' + hairColorQueryString;
				redirect(searchUrl);
			});
		}
	</script>
@endsection