<div class="bg-white box-shadow bottom-bar">
    <form role="form" method="POST" id="message_form" action="{{ lurl('account/conversations/' . $conversation->id . '/reply') }}" >
    	{!! csrf_field() !!}
    <div class="d-flex justify-content-between w-lg-750 w-xl-970 mx-lg-auto">
        {{ Form::text('message', null, ['id' => 'message', 'class' => 'mr-10','placeholder' => t('Type a message')]) }}
        {{ Form::submit('Send', ['class' => 'btn btn-success post mini-all', 'id' => 'send-message', 'title' => t('Send message')]) }}
    </div>
    </form>
</div>
