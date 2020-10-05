@if(!empty( $applications ) && count($applications) > 0 ) 
    
    <input type="hidden" id="myurl" url="{{ url()->current() }}" />
    <input type="hidden" id="pageNo" value="<?php echo isset($pageNo) ? $pageNo : 1 ?>"/>
    <input type="hidden" id="is_last_page" value="<?php echo isset($is_last_page) ? $is_last_page : 0 ?>"/>
    <div class="row tab_content mb-40 append-data">
        @foreach($applications as $k => $application) 
            
            <?php
                $conversations_id = '';
                $user = $application->user;
                $logo = (isset($user->profile->logo)) ? $user->profile->logo : '';
            ?>

            <div class="row mx-0 mx-lg-auto bg-white box-shadow position-relative pt-40 pb-40 pl-30 pr-20 mb-20 w-lg-750 w-xl-1220">
                    <div class="mr-md-40 mb-lg-30 mb-xl-0">
                        <div class="d-flex justify-content-center align-items-center mb-sm-30 rounded-circle border bg-lavender msg-img-holder">

                            @if($logo !== "" && $logo !== null && Storage::exists($logo))
                                <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}">
                                    <img src="{{ \Storage::url($user->profile->logo) }}" alt="{{ trans('metaTags.User') }}" class="logoImage from-img full-width"/>
                                </a>
                            @else
                                <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}"><img srcset="{{ URL::to('images/user.png') }},
                                                 {{ URL::to('images/user.png') }} 2x,
                                                 {{ URL::to('images/user.png') }} 3x"
                                src="{{ URL::to('images/user.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/></a>
                            @endif
                        </div>
                    </div>
                <div>
                    <div class="modelcard-top text-uppercase d-flex align-items-center mb-30 f-12">
                        <span class="d-block">{{ (isset($user->profile->city))? $user->profile->city : '' }}</span>
                        <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                        @if( isset($user->country_name) && !empty($user->country_name) )
                            <span class="d-block">{{ $user->country_name }}</span>
                        @endif
                        
                    </div>
                    
                    <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}"><span class="bold title pb-20" title="{{ $postTitle }}">{{ (isset($user->profile->full_name))? $user->profile->full_name : '' }}</span></a>
                    
                    <div class="modelcard-top">
                        
                        @if($ismodel == 1)
                            <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class=""><span class="d-inline-block">{{ t('View profile') }}</span></a>
                        @else
                            <a href="{{ lurl(trans('routes.user').'/'.$user->username) }}" class=""><span class="d-inline-block">{{ t('View profile') }}</span></a>
                        @endif
                        
                        
                        <?php if(isset($application->message_id) && $application->message_id > 0){ ?>

                            <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>

                            <a href="{{ lurl('account/conversations/'.$application->message_id.'/messages') }}" class=""><span class="d-inline-block">{{ t('Send a Message') }}</span></a>

                        <?php }
                        /*else{ ?>

                            <a href="#" class=""><span class="d-inline-block">{{ t('Send a Message') }}</span></a>

                        <?php  }*/ ?>
                        

                        @if($ismodel == 1)
                            <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>

                            <a href="{{ lurl('account/'.$user->id.'/downloadsdcard') }}" class=""><span class="d-inline-block">{{ t('Download Sedcard') }}</span></a>
                        @endif
                        
                        <span class="bullet rounded-circle bg-lavender d-inline-block mx-2"></span>

                        @if($ismodel == 1)
                            <a href="{{ lurl('account/'.$user->id.'/downloadmbook') }}" class=""><span class="d-inline-block">{{ t('Download Modelbook') }}</span></a>
                        @else
                            <a href="{{ lurl('partner-public-portfolio/'.$user->id) }}" class=""><span class="d-inline-block">{{ t('Download Portfolio') }}</span></a>
                        @endif    

                    </div>
                    
                    <div class="divider"></div>
                    <?php /*
                    <div class="d-flex d-xl-block justify-content-start align-items-center position-absolute-xl text-xl-right xl-to-top-40 xl-to-right-30">
                        <span class="form-group custom-checkbox">
                            <input class="checkbox_field" id="studio_{{$user->id}}" name="entries[]" type="checkbox" value="{{ $application->id }}">
                            <label for="studio_{{$user->id}}" class="checkbox-label">{{ t('Delete') }}</label>
                        </span>
                    </div>
                    <?php */ ?>
                </div>
            </div>
        @endforeach
    </div>

    @if(isset($is_last_page) && (!$is_last_page) )
    <div class="text-center"><a href="javascript:void(0);" id="more-posts" class="btn btn-white refresh more-posts">{{ t('load more') }}</a></div>
    @endif

@else
    <div class="bg-white text-center box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
        <h5 class="prata">{{ t('No records found') }}</h5>
    </div>
@endif

@section('after_scripts')
<script>
    $(document).ready(function (){
        
        $('#mypost-search-submit').click( function(e){
            e.preventDefault();
            $("#search-form").submit();
        });

        $('#checkAll').click( function(){
            checkAll(this);
        });

        var search = $('#searchtext').val();

        $('a.delete-btn, button.delete-btn').click(function(e){
            e.preventDefault(); /* prevents the submit or reload */
            var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");
            
            if (confirmation) {
                if( $(this).is('a') ){
                    var url = $(this).attr('href');
                    if (url !== 'undefined') {
                        window.location.href = url;
                    }
                } else {
                    $('form[name=listForm]').submit();
                }
            }
            return false;
        });

        postData = '';

        var ismodel = '<?php echo $ismodel;  ?>';
        var postTitle = '<?php echo $postTitle;  ?>';

        if($("#is_last_page").val() == 1){
            $("#more-posts").addClass("disabled");
        }
        
        $('.more-posts').click(function(){
                
                var url = $("#myurl").attr("url");
                var pageNo = $("#pageNo").val(); 
                var formData = 'ismodel='+ismodel+ '&postTitle='+postTitle+'&page='+pageNo;
                var type = 'get';

                if(search != '' && search != undefined && search != null){
                    formData = 'search='+search+'&ismodel='+ismodel+ '&postTitle='+postTitle+'&page='+pageNo;
                }
                
                var is_last_page = $("#is_last_page").val();

                if (is_last_page == 1) {
                    alert("On the last record page");
                    return false;
                }
                
                var data = formData;

                $.ajax({
                    url: url,
                    type : type,
                    dataType :'json',
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    data : data,
                    success : function(res){
                        
                        var append = $(res.html).filter(".append-data").html();

                        $("#pageNo").val(res.pageNo);
                        
                        if(res.is_last_page == 1){
                            $("#is_last_page").val(res.is_last_page);
                            $("#more-posts").addClass("disabled");
                            $("#more-posts").hide();
                        }

                        $('.append-data').append(append);
                    }
                });
            });
    });
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