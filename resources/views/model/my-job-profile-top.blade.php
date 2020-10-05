<div class="text-center">
    <p><a href="{{ route('my-jobs') }}">My jobs /</a></p>
    <h1 class="prata">Athletic Male Models Wanted Experience Not Essential</h1>
    <div class="divider mx-auto"></div>
</div>

<div class="custom-tabs mb-20 mb-xl-30">
    {{ Form::select('tabs',[0 => 'Details', 1 => 'Messages'],null) }}
    <ul class="d-none d-md-block">
        <!-- add active class to the "a" tag -->
        <li><a href="{{ route('my-job-details') }}">Details</a></li>
        <li><a href="{{ route('my-job-messages') }}" class="position-relative">Messages<span class="msg-num tab">7</span></a></li>
    </ul>
</div>