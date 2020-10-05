<!-- All Conversation's Messages -->
<?php

    $previous_date = '';
    $previous_date_arr = array();
    if (isset($messages) && $messages->count() > 0) {
        $index = ($messages->count() - 1);
        foreach ($messages as $key => $message) {
            $showhr = false;
            // echo $message->created_at->format('d-m-y') . '  ' . $previous_date;
            if ($message->from_user_id == auth()->user()->id) {
                $chatclass = 'justify-content-end';
                $shadowclass = 'bg-light-lavender-6  b-dark-lavender box-shadow py-20 px-20 w-75p details-desc details-desc overflow-wrap';

            } else {
                $chatclass = 'justify-content-start';
                $shadowclass = 'bg-white box-shadow border py-20 px-20 w-75p details-desc overflow-wrap';
            }
            if ($key == $index) {
                $previous_date = $message->created_at->format('d-m-y');
            }
            if ($message->created_at->format('d-m-y') == $previous_date && !in_array($previous_date, $previous_date_arr)) {
                $showhr = true;
                array_push($previous_date_arr, $previous_date);
            }

            ?>
            @if($showhr = false)
            <div class="date-divider text-center my-40 mb-40">
                <span>{{ \App\Helpers\CommonHelper::getFormatedDate($message->created_at) }}</span>
            </div>
            @endif
            <div class="d-flex {{ $chatclass }} mb-20">
                @if(\Auth::User()->id != $message->from_user_id )

                    <div class="from-img-holder mr-10 rounded-circle border bg-lavender d-flex  align-items-center img-27 img-md-49">

                    <?php
                        if($conversation->from_user_id == $message->from_user_id)
                        {
                            $message_user_profile = $profile_image;
                        }
                        else
                        {
                            $message_user_profile = $profile_image_from;
                        }
                    ?>
                        @if(!empty($message_user_profile) && file_exists(public_path('uploads').'/'.$message_user_profile))
                            <img src="{{ \Storage::url($message_user_profile) }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img-radius full-width "/>
                        @else
                            <img srcset="{{ URL::to(config('app.cloud_url').'/images/user.png') }},
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 2x,
                                             {{ URL::to(config('app.cloud_url').'/images/user.png') }} 3x"
                                 src="{{ URL::to(config('app.cloud_url').'/images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/>
                        @endif
                    </div>
                @endif

                <div class="{{ $shadowclass }}" id="{{ 'message'.$message->id }}">
                    <?php /* ?>
                        @if ($message->from_user_id == auth()->user()->id)
                        <span title="{{ t('Delete') }}" class="btn-invitation btn-rejected rejected delete-btn-msg" id="{{ 'msg-'.$message->id }}"></span>
                        @endif
                    <?php */ ?>

                    <p class="mb-10">{!! \App\Helpers\CommonHelper::geturlfromstring(nl2br($message->message)) !!}</p>
                    @if(!empty($message->filename))
                    <div class="text-left"><a target="_blank" class="bold" href="{{ $message->filename }}">View Image</a></div>
                    @endif
                    <div class="text-right dark-grey2 f-14 lh-15">{{ \App\Helpers\CommonHelper::getFormatedDate($message->created_at, true) }} </div>
                </div>
            </div>

            <?php
            $previous_date = $message->created_at->format('d-m-y');
        }
    }
?> 
