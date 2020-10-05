@if(!empty( $posts ) && count($posts) > 0 )
 @foreach($posts as $k => $post) 

                <?php 

                    $postUrl = lurl($post->uri);

                    if (in_array($pagePath, ['pending-approval', 'archived'])) {
                        $postUrl = $postUrl . '?preview=1';
                    }

                    if ($post->city) {
                        $city = $post->city->name;
                    } else {
                        $city = '-';
                    }

                    $iconPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';


                ?>
                <div class="col-md-6 mb-20">
                            <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30 position-relative">
                                <div class="col-md-6 col-xl-3 mt-20 position-absolute to-top-0" style="right: 5px;">
                                    <div class="custom-checkbox position-absolute to-top-0 to-right-0">
                                        <input class="checkbox_field" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $post->id }}" title="{{ t('Delete') }}">
                                        <label for="studio_{{$k}}" title="{{ t('Delete') }}" class="checkbox-label"><strong>&nbsp;</strong></label>
                                    </div>
                                </div>

                                <a href="{{ route('job-profile') }}"><span class="title">{{ str_limit($post->title, config('constant.title_limit')) }}</span></a>
                                <!-- <span>Jobart, Jobart</span> -->
                                <div class="divider"></div>
                                <p class="mb-30">{{ str_limit(strip_tags($post->description), config('constant.description_limit')) }}</p>
                                <span class="info city mb-10">{{ $city }} 
                                    @if (file_exists(public_path($iconPath)))
                                        <img src="{{ url($iconPath) }}" data-toggle="tooltip" title="{{ $post->country_code }}">
                                    @endif
                                </span>
                                <!-- <span class="info appointment mb-10">18.08.2018, 10:00</span> -->
                                <?php $applications = \App\Models\Message::where('post_id', $post->id)->where('to_user_id', auth()->user()->id)->groupBy('from_user_id')->get();?>
                                <span class="info partner mb-10">
                                    <a href="{{lurl('account/my-posts/'.$post->id.'/applications')}}">{{ count($applications) }} {{ t('applications') }}</a>
                                </span>
                                <span class="info partner mb-30">
                                    {{ t('Visitors') }} {{ $post->visits or 0 }}
                                </span>

                                <span class="info posted">{{ t('Posted On') }} <strong>{{ $post->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</strong></span>

                                <div class="d-flex justify-content-end bordered2 mt-20" wfd-id="59">
                                    @if ($post->user_id == Auth::User()->id and $post->archived==0)
                                        <?php $attrId['id'] = $post->id; ?>
                                        <a href="{{ lurl(trans('routes.post-edit', $attrId), $attrId) }}" class="btn btn-white post_white mr-20 mt-20">{{ t('Edit') }}</a>
                                    @endif
                                    @if ($post->user_id == Auth::User()->id and $post->archived==1)
                                     <a class="btn btn-white post_white mr-20 mt-20" href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/repost') }}">{{ t('Repost') }}</a>
                                    @endif
                                    <a href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/delete') }}" class="btn btn-white trash_white mt-20">{{ t('Delete') }}</a>
                                </div>
                            </div>
                        </div>
            @endforeach
@endif