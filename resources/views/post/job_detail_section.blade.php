
    <span class="title">{{ t('Job\'s Details') }}</span>
        <div class="divider"></div>

         @if( isset($post->is_home_job) && $post->is_home_job == 1)
            <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">{{ t('home_modeling_job_description') }}</div>
         @endif

        <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">
            <div class="col-md-6">
                
                @if( isset($post->end_application) && $post->end_application != "")
                    <p>
                        <span class="bold d-inline-block mr-1">{{t('Application Deadline')}}:</span><span class="d-inline-block">{{ \App\Helpers\CommonHelper::getFormatedDate($post->end_application) }} </span>
                    </p>
                @endif


                @if (auth()->check())
                    
                    @if (auth()->user()->id == $post->user_id)
                        <p><a title="{{ t('applications') }}" href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">
                            <span class="bold d-inline-block mr-1">{{ t('Application') }}:</span><span class="d-inline-block">{{ $post->jobApplicationsCount->count() }}</span></a></p>
                    @else
                        <p><span class="bold d-inline-block mr-1">{{ t('Application') }}:</span><span class="d-inline-block">{{ $post->jobApplicationsCount->count() }}</span></p>
                    @endif
                @endif

                <p>
                    <span class="bold d-inline-block mr-1">{{ t('Job Views') }}:</span><span class="d-inline-block">{{ $post->jobVisits->count() }} {{ trans_choice('global.count_views', getPlural($post->jobVisits->count())) }}</span>
                </p>
            </div>
            <div class="col-md-6">

                <p>
                    <span class="bold d-inline-block mr-1">{{ t('Location') }}:</span><span class="d-inline-block">
                    <?php


                        // $currency_symbol = isset($post->currency->html_entity)? $post->currency->html_entity : isset($post->currency->font_arial)? $post->currency->font_arial : config('currency.symbol');

                        $currency_symbol = config('currency.symbol');

                        if(isset($post->currency->html_entity)){
                            $currency_symbol = $post->currency->html_entity;
                        }else{
                            if(isset($post->currency->font_arial)){
                                $currency_symbol = $post->currency->font_arial;
                            }
                        }

                        $city_name = '';
                        if(isset($post->city) && !empty($post->city)){
                            $city_name = explode(',', $post->city);
                            $city_name = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $post->city;
                        }

                        $city = $city_name;
                        $country = ($post->country_name) ? $post->country_name : '';
                        $show_city_country = '';

                        if(!empty($city)){
                            $show_city_country = $city;
                        }
                            
                        if(!empty($city) && !empty($country)){
                            $show_city_country .= ', ';
                        }

                        echo $show_city_country .= $country;
                    ?>
                    
                    </span>
                </p>

                <p><span class="bold d-inline-block mr-1">{{t('Posted On')}}:</span><span class="d-inline-block">{{ \App\Helpers\CommonHelper::getFormatedDate($post->created_at) }} </span></p>

                
            </div>
        </div>

          <!-- Partner Categories -->

        @if (count($cat) > 0)
            <div class="bb-light-lavender3 mb-40 pb-40">
                <span class="title">{{ t('Category') }}</span>
                <div class="divider"></div>
                @foreach($cat as $cat)
                <span class="tag mr-2 mb-2">{{ $cat->name }}</span>
                @endforeach
            </div>
        @endif


        <!-- Model Categories -->
        @if ($post->ismodel)
            @if (count($post->model_cat) > 0)
                <div class="bb-light-lavender3 mb-40 pb-40">
                    <span class="title">{{ t('Model Categories') }}</span>
                    <div class="divider"></div>
                    @foreach($post->model_cat as $mcat)
                        <span class="tag mr-2 mb-2">{{ $mcat->name }}</span>
                    @endforeach
                </div>
            @endif
        @endif

         <!-- Partner Categories -->
        @if (!$post->ismodel)
            @if (count($post->branch_cat) > 0)
                <div class="bb-light-lavender3 mb-40 pb-40">
                    <span class="title">{{ t('Partner Category') }}</span>
                    <div class="divider"></div>
                    @foreach($post->branch_cat as $bcat)
                        <span class="tag mr-2 mb-2">{{ $bcat->name }}</span>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="bb-light-lavender3 mb-40 details-desc description-table overflow-wrap">
            <span class="title">{{ t('Details') }}</span>
            <div class="divider"></div>
            <p class="mb-40" style="text-align: justify;"><?php echo transformDescription($post->description) ?></p>
        </div>

       <!--  @if (!empty($post->company_description))
        <div class="bb-light-lavender3 mb-40 details-desc">
            <span class="title">{{ t('Company Description') }}</span>
            <div class="divider"></div>
            <p class="mb-40" style="text-align: justify;">{!! nl2br(createAutoLink(strCleaner($post->company_description))) !!}</p>
        </div>
        @endif -->


        <span class="title">{{t('Looking for')}}</span>
        <div class="divider"></div>

        <div class="row mx-0 bb-light-lavender3 mb-40 pb-40">
            <div class="col-md-6">
                <p><span class="bold d-inline-block mr-1">{{ t('Start Date') }}:</span><span class="d-inline-block">
                @if($post->is_date_announce == "1")
                    {{ t('to be announced') }}
                @else
                    {{ ($post->start_date != "") ? \App\Helpers\CommonHelper::getFormatedDate($post->start_date) : '' }}
                @endif
                </span></p>

                @if((isset($post->salary_min) && $post->salary_min > 0) || isset($post->salary_max) && $post->salary_max > 0)
                <p><span class="bold d-inline-block mr-1">{{ t('Salary') }}:</span><span class="d-inline-block">
                    @if ($post->salary_min > 0 or $post->salary_max > 0)
                        @if ($post->salary_min > 0)
                            {!! \App\Helpers\Number::money($post->salary_min, $currency_symbol) !!}
                        @endif
                        @if ($post->salary_max > 0)
                            @if ($post->salary_min > 0)
                                &nbsp;-&nbsp;
                            @endif
                            {!! \App\Helpers\Number::money($post->salary_max, $currency_symbol) !!}
                        @endif
                    @else
                        {!! \App\Helpers\Number::money('--') !!}
                    @endif
                    @if (!empty($salaryType))
                        {{ $salaryType->name }}
                    @endif
                </span></p>
                @endif

                <p>
                    <span class="bold d-inline-block mr-1">{{ t('Negotiable') }}:</span><span class="d-inline-block">{{ ($post->negotiable == 1)? t('Yes'):t('No') }}</span>
                </p>

                <p><span class="bold d-inline-block mr-1">{{ t('TFP') }}:</span><span class="d-inline-block">
                    {{ ($post->tfp == 1)? t('Yes') : t('No') }}
                </span></p>

                <p>
                    <span class="bold d-inline-block mr-1">{{ t('Gender') }}:</span><span class="d-inline-block">
                        @if($post->gender_type_id == config('constant.gender_male'))
                        {{ t("Male") }}
                        @elseif($post->gender_type_id == config('constant.gender_female'))
                        {{ t("Female") }}
                        @elseif($post->gender_type_id == '0')
                        {{ t("Both") }}
                        @else
                        {{ '--' }}
                        @endif
                    </span>
                </p>
                @if ($post->ismodel)

                    @if(isset($height) && $height != "")
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Height') }}:</span><span class="d-inline-block">{{ (isset($height)) ? $height : '--' }}</span>
                        </p>
                    @endif

                    @if(isset($waist) && $waist != "")
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Waist') }}:</span><span class="d-inline-block">
                            {{ (isset($waist))? $waist : '--' }}
                                </span>
                        </p>
                    @endif

                    @if(isset($shoeSize) && $shoeSize != "")
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Shoesize') }}:</span><span class="d-inline-block">{{ (isset($shoeSize))? $shoeSize : '--' }}</span>
                        </p>
                    @endif

                    @if(isset($properties['hair_color'][$post->hairColor]))
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Hair color') }}:</span><span class="d-inline-block">{{ (isset($properties['hair_color'][$post->hairColor]))? $properties['hair_color'][$post->hairColor] : '--' }}</span>
                        </p>
                    @endif

                    @if(isset($properties['skin_color'][$post->skinColor]))
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Skin color') }}:</span><span class="d-inline-block">{{ (isset($properties['skin_color'][$post->skinColor]))? $properties['skin_color'][$post->skinColor] : '--' }}
                            </span>
                        </p>
                    
                    @endif

                    @if(isset($is_dress_size) && $is_dress_size == true)
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Preferred dress sizes') }}:</span>
                            <!-- START BABY DRESS SIZE -->
                            @if(isset($baby_dress))

                                @if(!empty($baby_dress))
                                    <br />
                                    <span class="d-inline-block mb-2"><u>{{ t('Kids') }}</u>: {{ rtrim($baby_dress, ", ")  }}</span>
                                @endif
                            @endif
                            <!-- END BABY DRESS SIZE -->

                            <!-- START WOMEN DRESS SIZE -->
                            @if(isset($women_dress))

                                @if(!empty($women_dress))

                                    <br />
                                    <span class="d-inline-block mb-2"><u>{{ t('Female') }}</u>: {{ rtrim($women_dress, ", ")  }}</span>
                                @endif
                            @endif
                            <!-- END WOMEN DRESS SIZE -->

                            <!-- START MEN DRESS SIZE -->
                            @if(isset($men_dress))

                                @if(!empty($men_dress))

                                    <br />
                                    <span class="d-inline-block mb-2"><u>{{ t('Male') }}</u>: {{ rtrim($men_dress, ", ")  }}</span>
                                @endif
                            @endif
                            <!-- END MEN DRESS SIZE -->
                        </p>
                    @endif
                @endif

            </div>
            <div class="col-md-6">
                @if($post->end_date != "")
                    <p><span class="bold d-inline-block mr-1">{{ t('End Date') }}:</span><span class="d-inline-block"> {{ ($post->end_date != "") ? \App\Helpers\CommonHelper::getFormatedDate($post->end_date) : $post->end_date }}
                    </span></p>
                @endif
                <p>
                    <span class="bold d-inline-block mr-1">{{ t('Job Type') }}:</span><span class="d-inline-block"> 
                        @if (!empty($postType))
                            {{ $postType->name }}
                        @endif

                        <?php /* @if (!empty($postType))
                            <?php $attr = ['countryCode' => config('country.icode')]; ?>
                            <a href="{{ lurl(trans('routes.v-search', $attr), $attr) . '?type[]=' . $post->post_type_id }}">{{ $postType->name }}</a>
                        @endif */ ?>
                    </span>
                </p>

               <p>
                    <span class="bold d-inline-block mr-1">{{ t('Required experience') }}:</span><span class="d-inline-block"> {{ (!empty($experienceType)) ? t($experienceType) : '--' }}</span>
                </p>

                @if ($post->ismodel)

                    @if(isset($age) && $age != "")
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Age') }}:</span><span class="d-inline-block"> {{ (isset($age))? $age : '--' }} </span>
                        </p>
                    @endif

                    @if(isset($weight) && $weight != "")
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Weight') }}:</span><span class="d-inline-block">{{ (isset($weight))? $weight : '--' }}</span>
                        </p>
                    @endif

                    @if(isset($chest) && $chest != "")
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Chest') }}:</span><span class="d-inline-block">{{ (isset($chest))? $chest : '--' }}</span>
                        </p>
                    @endif

                    @if(isset($hips) && $hips != "")
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Hips') }}:</span><span class="d-inline-block">{{ (isset($hips))? $hips : '--' }}</span>
                        </p>
                    @endif

                    @if(isset($properties['eye_color'][$post->eyeColor]))
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Eye color') }}:</span><span class="d-inline-block">{{ (isset($properties['eye_color'][$post->eyeColor]))? $properties['eye_color'][$post->eyeColor] : '--' }}</span>
                        </p>
                    @endif

                    @if(isset($is_shoe_size) && $is_shoe_size == true)
                        <p>
                            <span class="bold d-inline-block mr-1">{{ t('Preferred shoe sizes') }}:</span>

                            <!-- START BABY SHOE SIZE -->
                            @if(isset($baby_shoe))

                                @if(!empty($baby_shoe))
                                    <br />
                                    <span class="d-inline-block mb-2"><u>{{ t('Kids') }}</u>: {{ rtrim($baby_shoe, ", ")  }}</span>
                                @endif
                            @endif
                            <!-- END BABY SHOE SIZE -->

                            <!-- START WOMEN SHOE SIZE -->
                            @if(isset($women_shoe))

                                @if(!empty($women_shoe))
                                    <br />
                                    <span class="d-inline-block mb-2"><u>{{ t('Female') }}</u>: {{ rtrim($women_shoe, ", ")  }}</span> 
                                @endif
                            @endif
                            <!-- END WOMEN SHOE SIZE -->

                            <!-- START MEN SHOE SIZE -->
                            @if(isset($men_shoe))

                                @if(!empty($men_shoe))
                                    <br />
                                    <span class="d-inline-block mb-2"><u>{{ t('Male') }}</u>: {{ rtrim($men_shoe, ", ")  }}</span> 
                                @endif
                            @endif
                            <!-- END MEN SHOE SIZE -->
                        </p>
                    @endif
                @endif
            </div>
        </div>


