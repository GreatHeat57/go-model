@if (isset($errors) and $errors->any())
    <div class="col-lg-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p><strong>{{ t('Oops ! An error has occurred, Please correct the red fields in the form') }}</strong></p>
            <ul class="list list-check">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (Session::has('flash_notification'))
    @include('flash::message')
@endif