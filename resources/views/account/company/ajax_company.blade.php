<?php

if(!empty( $companies ) && count($companies) > 0 ){ ?>
    <?php   foreach($companies as $k => $company) { ?>
        <div class="row mx-0 mx-xl-auto bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-20 pl-30 mb-20 w-xl-1220" >
            <div class="col-md-6 pr-md-2 bordered" >
               
                <?php $attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>
               <a href="{{ lurl(trans('routes.v-account-companies-edit', $attr), $attr) }}" title="{{ str_limit($company->name) }}"><span class="title">{{ str_limit($company->name, config('constant.title_limit')) }}</span></a>

                <span>
                    <?php $attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>
                    <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}" class="">{{ $company->posts()->count() }} ( {{ t('Ads') }} )</a>
                </span>

                <div class="divider" ></div>
                <p class="mb-20">{{ str_limit($company->description, config('constant.description_limit')) }}</p>

                <span class="pt-20 pb-10 form-group custom-checkbox">
                    <input class="checkbox_field" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $company->id }}">
                    <label for="studio_{{$k}}" class="checkbox-label" title="{{ t('Delete') }}">{{ t('Delete') }}</label>
                </span>

            </div>

            <div class="col-md-6 pl-md-4 pt-58 pb-64 position-relative" >
                <div class="d-flex justify-content-center align-items-center mb-sm-30 border bg-lavender msg-img-holder">
                    @if($company->logo !== "")
                        <img class="logoImage" src="{{ resize(\App\Models\Company::getLogo($company->logo), 'medium') }}" class="from-img full-width" alt="user">&nbsp;
                    @else
                        <img class="logoImage from-img full-width" src="{{ url(config('app.cloud_url').'/images/user.jpg') }}" alt="user">
                    @endif
                </div>

                <div class="d-flex align-self-end justify-content-end corner-btn" ><a href="{{ lurl(trans('routes.v-account-companies-edit', $attr), $attr) }}" title="{{ t('Edit') }}" class="btn btn-white edit_grey position-relative align-self-end mini-all"></a></div>
            </div>
        </div>
    <?php } ?>

<?php } ?>