<div class="modal fade" id="reportAbuse" role="dialog" style="z-index: 99999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
            </div>
            <div class="container pt-20  px-0">
                <h2 class="text-center prata px-38">{{ $post->title }}</h2>
                <div class="position-relative">
                    <div class="divider mx-auto"></div>
                </div>
                <p class="text-center mb-30 mx-lg-auto">{{ t('What is wrong with this job?') }}</p>

                <div class="bg-white ">
                    <div class="px-38">
                        <div class="alert alert-danger print-error-msg-report" style="display:none"></div>
                        <div class="alert alert-success print-success-msg-report" style="display:none"></div>
                    </div>
                </div>

                <div class="bg-white report-form-div">
                    <form role="form" method="POST" id="reportAbuse-form" action="{{ lurl('posts/' . $post->id . '/report') }}">
                        {!! csrf_field() !!}
                        <div class="py-30 px-38 form-input-report">

                            <div class="input-group _report_type">
                                <select id="report_type" name="report_type" class="form-control custom_select" required="required">
                                    <option id="first-option" value="">{{ t('Select a reason') }}</option>
                                        @foreach ($reportTypes as $reportType)
                                            <option value="{{ $reportType->id }}">{{ $reportType->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                           
                            @if (auth()->check())
                                <input type="hidden" name="email" value="{{ $user->email }}">
                            @else
                                <div class="input-group">
                                    {{ Form::email('email', old('email'),['class' => 'animlabel','id'=>'email']) }}
                                    {{ Form::label('email', t('Your E-mail'), ['class' => 'required']) }}
                                </div>
                            @endif

                            <!-- message -->
                            <div class="input-group <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">

                                {{ Form::label('message', t('Message (upto 500 letters)'), ['class' => 'position-relative control-label input-label required']) }}
                                <textarea  name="message" class="animlabel textarea-description _message"  placeholder="" rows="5" minlength = '20' maxlength="500" required="true">{{ old('message') }}</textarea>
                            </div>

                            <input type="hidden" name="post" value="{{ $post->id }}">
                            <input type="hidden" name="abuseForm" value="1">
                        </div>

                        <div class="text-center mb-20">
                            <a href="#" class="btn btn-white mini-mobile arrow_left position-relative" data-dismiss="modal">{{ t('Cancel') }}</a>
                            <button type="submit" class="btn btn-success login report-submit">{{ t('Send message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .select2-container {
        z-index: 99999 !important;
    }
</style>

<script type="text/javascript">
    
    $(document).ready(function (){
        jQuery.noConflict()(function($){
            $(".custom_select").select2({
                minimumResultsForSearch: Infinity,
                width: '100%'
            });
        });

        $('#reportAbuse-form').on('submit',function(e){

            e.preventDefault();

            var data = $("#reportAbuse-form").serialize();

            $.ajax({
                
                method: "POST",
                url: "{{ lurl('posts/' . $post->id . '/report') }}",
                data: data,
                dataType: "json",
                beforeSend: function(){
                    $(".loading-process").show();
                },
                complete: function(){
                    $(".loading-process").hide();
                },
                success: function (response) {

                    if( response != undefined && response.status == false ){

                        $(".print-error-msg-report").html('');
                        $(".print-error-msg-report").css('display','block');
                        $("div,div textarea").removeClass('invalid-input');

                        if (typeof response.errors == "string") {
                            $(".print-error-msg-report").append('<p>'+response.errors+'</p>');

                        } else {
                            $.each(response.errors, function( key, value ) {

                                $('._'+key).addClass('invalid-input');
                                $(".print-error-msg-report").append('<p>'+value[0]+'</p>');
                            });
                        }

                        // setTimeout(function(){
                        //     $(".print-error-msg-report").css('display','none');
                        // }, 10000);
                    } else {
                        if( response.message != undefined && response.message !== ""){
                            $(".print-success-msg-report").html(response.message);
                            $(".print-success-msg-report").css('display','block');
                            $("div,div textarea").removeClass('invalid-input');
                            $(".print-error-msg-report").html('').css('display','none');
                        }

                        // setTimeout(function(){
                        //     $('#reportAbuse-form')[0].reset();
                        //     $(".print-error-msg-report").html('');
                        //     $(".print-error-msg-report").css('display','none');
                        //     $(".print-success-msg-report").html('');
                        //     $(".print-success-msg-report").css('display','none');
                        //     $('#reportAbuse').modal('toggle');
                        // }, 10000);
                    }
                }
            });
        });
    });
</script>

 