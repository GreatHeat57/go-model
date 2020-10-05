@extends('layouts.logged_in.app-model')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="prata">My jobs</h1>
                <div class="divider mx-auto"></div>
            </div>
        </div>
        <div class="custom-tabs mb-20">
            <ul class="d-none d-md-flex justify-content-center">
                <li><a href="#" class="active" data-id="0">All</a></li>
                <li><a href="#" data-id="1" class="position-relative">Applied<span class="msg-num tab applied">3</span></a></li>
                <li><a href="#" data-id="2" class="position-relative">Invited<span class="msg-num tab invited">3</span></a></li>
                <li><a href="#" data-id="3" class="position-relative">Rejected<span class="msg-num tab rejected">15</span></a></li>
                <li><a href="#" data-id="4" class="position-relative">Ongoing<span class="msg-num tab ongoing">7</span></a></li>
                <li><a href="#" data-id="5" class="position-relative">Closed<span class="msg-num tab closed">1</span></a></li>
            </ul>
        </div>
<?php if (isset($posts) && $posts->count() > 0) {
	foreach ($posts as $key => $post) {
		// Fixed 1

		if (!empty($post->post)) {
			$post = $post->post;
		}

		// Get Post's Country
		if ($post->city) {
			$country = $post->country->name;
		} else {
			$country = '-';
		}

		// Get Post's City
		if ($post->city) {
			$city = $post->city->name;
		} else {
			$city = '-';
		}

		// Get Post's Category
		if ($post->city) {
			$category = $post->category->name;
		} else {
			$category = '-';
		}

		// Get Post's Category
		if ($post->user) {
			$user_name = $post->user->name;
		} else {
			$user_name = '-';
		}
		?>
        <div class="row mx-0 mx-xl-auto bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-20 pl-30 mb-20 w-xl-1220">
            <span class="flag to-right to-top-0 applied"></span>
            <div class="col-md-6 pr-md-2 bordered">
                <div class="modelcard-top text-uppercase f-12 d-flex align-items-center mb-30">
                    <span class="d-block">job # {{$post->id}}</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">{{$category}}</span>
                </div>
                <a href="{{ route('my-job-details') }}"><span class="title">{{ $post->title }}</span></a>
                <span>Jobart, Jobart</span>
                <div class="divider"></div>
                <p class="mb-20">{!! nl2br($post->description) !!}</p>
            </div>
            <div class="col-md-6 pl-md-4 pt-58 pb-64 position-relative">
                <span class="info city mb-10">{{ $city }} ,{{ $country}}</span>
                <span class="info appointment mb-10">Date, Appointment</span>
                <span class="info partner mb-10">{{$user_name}}</span>
                <span class="status applied">Status</span>
                <div class="d-flex align-self-end justify-content-end corner-btn"><a href="{{ route('my-job-messages') }}" class="btn btn-white message position-relative align-self-end mini-all"><span class="msg-num">45</span></a></div>
            </div>
        </div>
         <?php }
} else {?>
    <div>You have not applied for any job</div>
<?php }?>
    </div>
     @include('childs.bottom-bar')
@endsection