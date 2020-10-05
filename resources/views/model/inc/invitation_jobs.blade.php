<div class="modal fade" id="inviteJob" tabindex="-1" role="dialog" style="top: 10% !important;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">{{ t('Close') }}</span>
				</button>
			</div>
            <div class="container pt-20  px-0">

                <h2 class="text-center prata">{{ t('Invite for Job') }}</h2>
                <div class="position-relative">
                    <div class="divider mx-auto"></div>
                </div>

    			<div class="bg-white">
                    <div class="px-38">
                        <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    </div>
                </div>

                <div class="bg-white">
                    <form role="form" method="POST" action="{{ lurl('account/invitation') }}" id="invit_form">
                    {!! csrf_field() !!}
                    <div class="py-30 px-38">
                        
                    <?php if(isset($posts) && !empty($posts) && count($posts) > 0 ) {  ?>
                        <div class="input-group">
                            {{ Form::label(t('Select Post Job'), t('Select Post Job') , ['class' => 'control-label required input-label position-relative select-label']) }}
                               <select name="jobid" id="job-id" class="form-control">
                                    <option value="">{{ t('Select') }}</option>
                                    <?php foreach ($posts as $key => $value) { ?>
                                        <option value="{{ $value->id }}">{{ $value->title }}</option>
                                    <?php } ?>
                                </select>
                        </div>
                    <?php } else{ ?>
                        <div class="text-center mb-20">
                            <h3>{{ t('Jobs are not suited to the user profile') }}</h3>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="model_id" id="model_id" value="{{ $model_id }}">
                    </div>
                    <?php if(isset($posts) && !empty($posts) && count($posts) > 0 ) {  ?>
                        <div class="text-center mb-20">
                            <a href="#" class="btn btn-white mini-mobile arrow_left position-relative" data-dismiss="modal">{{ t('Cancel') }}</a>
                            <button type="submit" class="btn btn-white members invited_white invitaiton-send">{{ t('Send Invitation') }}</button>
                        </div>
                    <?php } ?>
                    </form>
                </div>

            </div>
		</div>
	</div>
</div>
<script>
    $(document).ready( function(){
        $('.invitaiton-send').click( function(evt){
            evt.preventDefault();

            var jobid = $('#job-id').val();
            var modelid = $('#model_id').val();
            var token = $("input[name=_token]").val();

            if(jobid == "" || jobid == null || jobid == undefined){
                $('.print-error-msg').addClass('alert-danger').html('{{ t("Please select job post") }}').show();
                return false;
            }

           var dataObject = { 'jobid' : jobid, 'modelid' : modelid, '_token' : token };
            var url = "<?=lurl('account/invitation')?>";
            
             $.ajax({
                method: "POST",
                url: url,
                dataType: 'JSON',
                data: dataObject,
                beforeSend: function(){
                    $(".invitaiton-send").attr('disabled',true);
                    $(".loading-process").show();
                },
                complete: function(){
                    $(".loading-process").hide();
                    $(".invitaiton-send").attr('disabled',false);
                },
            }).done(function(response) {
                if(response.success){
                    $('.print-error-msg').removeClass('alert-danger').addClass('alert-success').html(response.message).show();
                }else{
                   $('.print-error-msg').addClass('alert-danger').html(response.message).show(); 
                }
                // setTimeout(function(){
                //     $('.print-error-msg').hide();
                // }, 3000);
            });


        })
    });
</script>
