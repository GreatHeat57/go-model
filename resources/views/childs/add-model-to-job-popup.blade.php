<div id="img-zoom-popup">
    <div class="w-lg-720">
        <span class="bold f-20 lh-28">Add a model to your job</span>
        <div class="divider"></div>
        <div class="form-group mb-40">
            {{ Form::label('jobname' , 'Jobname', ['class' => 'control-label required select-label position-relative']) }}
            {{ Form::select('jobname', [0 => 'Wählen Sie...',1 => 'English', 2 => 'Deutsch'], null, ['class' => 'form-control']) }}
        </div>
    </div>
</div>