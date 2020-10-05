@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

<?php
$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
$tmpExplode = explode('?', $fullUrl);
$fullUrlNoParams = current($tmpExplode);

$showSocial = false;

	if(
	   ( isset($company->googleplus) && !empty($company->googleplus) ) 
	|| ( isset($company->linkedin) && !empty($company->linkedin)) 
	|| ( isset($company->facebook) && !empty($company->facebook)) 
	|| ( isset($company->twitter) && !empty($company->twitter)) 
	|| ( isset($company->pinterest) && !empty($company->pinterest))
	)
	{ 
	$showSocial = true; 
	}

	$companyInfoExists = false;
	if (
		(isset($company->address) and !empty($company->address)) or
		(isset($company->phone) and !empty($company->phone)) or
		(isset($company->mobile) and !empty($company->mobile)) or
		(isset($company->fax) and !empty($company->fax))
	) {
		$companyInfoExists = true;
	}

?>

@section('content')
    <div class="container pt-40 pb-60 px-0">
    	<div class="container pt-40 px-0 pb-30">
		    <div class="text-center mb-30 position-relative">
		        <h1 class="f-h2 prata">{{ ($company->name)? $company->name : '' }}</h1>
		        <div class="divider mx-auto"></div>
		        @if (auth()->check())
		        	@if (auth()->user()->id == $company->user_id)
		        		<?php $attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>
		        		<a href="{{ lurl(trans('routes.v-account-companies-edit', $attr), $attr) }}" class="btn btn-default edit_grey mini-under-desktop position-absolute-md md-to-right-0 md-to-top-25 ">{{ t('Edit') }}</a>
		        	@endif
				@endif
		    </div>
		</div>
        <div class="box-shadow bg-white py-60 px-38  px-lg-0 w-xl-1220 mx-xl-auto">
            <div class="w-lg-750 w-xl-970 mx-auto">
                
                <div class="pb-40 mb-40 bb-light-lavender3">
                    <span class="title">{{ t('Company Information') }}</span>
                    <div class="divider"></div>
                    <div class="border">
                        <div class="img-holder mini d-flex align-items-center justify-content-center">
                           <!--  <img src="{{ resize(\App\Models\Company::getLogo($company->logo), 'medium') }}" alt="Go Models"/> -->
                        </div>
                        <div class="row mx-0 pt-60 px-20 pb-10 position-relative">
                        	<img src="{{ resize(\App\Models\Company::getLogo($company->logo), 'large') }}" alt="{{ trans('metaTags.Go-Models') }}" class="rounded-circle posted_by-img border"/>
                            <div class="col-md-12 col-xl-12">
                                <span class="title mb-10">{{ t('About') }}</span>
                                <p class="mb-0">{!! $company->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            
                @if($showSocial)
	         		<div class="pb-40 mb-40  bb-light-lavender3">
	                    <h2 class="bold f-18 lh-18">{{ t('Website & Social Networks') }}</h2>
	                    <div class="divider"></div>
	                    
	                    <div class="row">
	                        <div class="col-md-12 mb-30">
	                            @if (isset($company->facebook) and !empty($company->facebook))
		                            <div class="d-flex justify-content-start align-items-center mb-30 ">
		                                <div class="social-big facebook rounded-circle mr-20"></div>
		                                {{ isset($company->facebook) ? $company->facebook : '' }}
		                            </div>
		                        @endif

	                            @if (isset($company->googleplus) and !empty($company->googleplus))
		                            <div class="d-flex justify-content-start align-items-center mb-30 mb-md-0">
		                                <div class="social-big wix rounded-circle mr-20"></div>
		                                {{ isset($company->googleplus) ? $company->googleplus : '' }}
		                            </div>
	                            @endif

	                        </div>

	                        <div class="col-md-12">
	                            @if (isset($company->twitter) and !empty($company->twitter))
		                            <div class="d-flex justify-content-start align-items-center mb-30">
		                                <div class="social-big twitter rounded-circle mr-20"></div>
		                                {{ isset($company->twitter) ? $company->twitter : '' }}
		                            </div>
		                        @endif

	                            @if (isset($company->linkedin) and !empty($company->linkedin))
		                            <div class="d-flex justify-content-start align-items-center mb-30">
		                                <div class="social-big linkedin rounded-circle mr-20"></div>
		                                {{ isset($company->linkedin) ? $company->linkedin : '' }}
		                            </div>
	                            @endif

	                            @if (isset($company->pinterest) and !empty($company->pinterest))
		                            <div class="d-flex justify-content-start align-items-center mb-30">
		                                <div class="social-big pinterest rounded-circle mr-20"></div>
		                                {{ isset($company->pinterest) ? $company->pinterest : '' }}
		                            </div>
		                        @endif
	                        </div>
	                    </div>
	                </div>
                @endif

                @if($companyInfoExists)
	                <div class="pb-40 mb-40  bb-light-lavender3">
	                    <h2 class="bold f-18 lh-18">{{ t('Contact Information') }}</h2>
	                    <div class="divider"></div>

	                    @if(isset($company->address) && !empty($company->address))
	                    <div class="pb-40">
	                        {{ Form::label(t('Address'), t('Address'), ['class' => 'position-relative input-label']) }}
	                        <span>{{ (isset($company->address) ? $company->address : '') }}</span>
	                    </div>
	                    @endif

	                    @if(isset($company->phone) && !empty($company->phone))
	                    <div class="pb-40">
	                        {{ Form::label(t('Phone'), t('Phone'), ['class' => 'position-relative input-label']) }}
	                        <span>{{ (isset($company->phone) ? $company->phone : '') }}</span>
	                    </div>
	                     @endif

	                    @if(isset($company->mobile) && !empty($company->mobile))
	                    <div class="pb-40">
	                        {{ Form::label(t('Mobile Phone'), t('Mobile Phone'), ['class' => 'position-relative input-label']) }}
	                        <span>{{ (isset($company->mobile) ? $company->mobile : '') }}</span>
	                    </div>
	                     @endif

	                    @if(isset($company->fax) && !empty($company->fax))
	                    <div class="pb-40">
	                        {{ Form::label(t('Fax'), t('Fax'), ['class' => 'position-relative input-label']) }}
	                        <span>{{ (isset($company->fax) ? $company->fax : '') }}</span>
	                    </div>
	                     @endif
	                    
	                </div>
                @endif
            </div>
        </div>

    </div>
    <div class="container px-0 pt-40 pb-60">
        @include('search.company.inc.posts')
    </div>
@endsection
<style type="text/css">
	.img-holder.mini { height: 50px !important; }
</style>