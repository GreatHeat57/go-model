
@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="prata">{{t('Transaction')}}</h1>
                <div class="divider mx-auto"></div>
                <p>{{t('transaction subtitle')}}</p>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white search mini-under-desktop">{{t('Search')}}</a>
            </div>
        </div>

        <div class="row justify-content-md-between searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-auto">
                {{ Form::open() }}
                {{ Form::text('search', null, ['class' => 'search', 'placeholder' => t('Search')]) }}
                {{ Form::submit('Keresés') }}
                {{ Form::close() }}
            </div>
        </div>

        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs',[0 => 'All', 1 => 'Ingoing', 2 => 'Outgoing'],null) }}
            <ul class="d-none d-md-block">
                <li><a href="#" class="active">{{ t('All')</a></li>
                <li><a href="#">{{t('ingoing')}}</a></li>
                <li><a href="#">{{t('outgoing')}}</a></li>
            </ul>
        </div>

    <?php
if (isset($transactions) && $transactions->count() > 0):
	foreach ($transactions as $key => $transaction):

		// Fixed 2
		if (empty($transaction->post)) {
			continue;
		}

		if (!$countries->has($transaction->post->country_code)) {
			continue;
		}

		// Get Package
		$package = \App\Models\Package::transById($transaction->package_id);
		if (empty($package)) {
			continue;
		}

		// Currency
		$currency = \App\Models\Currency::find($package->currency_code);
		$currencySymbol = (!empty($currency)) ? $currency->symbol : '';
		?>
												        <div class="d-lg-flex justify-content-lg-between box-shadow bg-white py-20 px-38 position-relative mb-30">
												            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
												                <span class="d-block dark-grey2 f-12">ID</span>
												                <span>#{{ $transaction->id }}</span>
												            </div>
												            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
												                <span class="d-block dark-grey2 f-12">Date</span>
												                <span>{{ $transaction->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}</span>
												            </div>
												            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
												                <span class="d-block dark-grey2 f-12">Details</span>
												                <span>@if ($transaction->active == 1)
										@if (!empty($transaction->paymentMethod))
										{{ t('Paid by') }} {{ $transaction->paymentMethod->display_name }}
										@else
										{{ t('Paid by') }} --
										@endif
										@else
										{{ t('Pending payment') }}
										@endif</span>
												            </div>
												            <div class="d-flex justify-content-start pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
												                <div class="mr-20">
												                    <span class="d-block dark-grey2 f-12">In/out</span>
												                    <span class="ico-out"></span>
												                </div>
												                <div>
												                    <span class="d-block dark-grey2 f-12">Receipt</span>
												                    <span class="ico-draft"></span>
												                </div>
												            </div>
												            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
												                <span class="d-block dark-grey2 f-12">Status</span>
										                        @if ($transaction->active == 1)
										            <span class="text-uppercase cancelled">{{ t('Done') }}</span>
										        @else
										            <span class="text-uppercase successful">{{ t('Pending') }}</span>
										        @endif
												            </div>
												            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
												                <span class="d-block dark-grey2 f-12">Payment mode / Total</span>
												                <span>Bank transfer -{{ $package->price .''.$currencySymbol}}</span>
												            </div>
												        </div>
												        <?php endforeach;?>
														        <?php endif;?>
        <!-- <div class="d-lg-flex justify-content-lg-between box-shadow bg-white py-20 px-38 position-relative mb-30">
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <span class="d-block dark-grey2 f-12">ID</span>
                <span>#00000289</span>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <span class="d-block dark-grey2 f-12">Date</span>
                <span>07.04.2017</span>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <span class="d-block dark-grey2 f-12">Details</span>
                <span>purchase</span>
            </div>
            <div class="d-flex justify-content-start pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <div class="mr-20">
                    <span class="d-block dark-grey2 f-12">In/out</span>
                    <span class="ico-in"></span>
                </div>
                <div>
                    <span class="d-block dark-grey2 f-12">Receipt</span>
                    <span class="ico-draft"></span>
                </div>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <span class="d-block dark-grey2 f-12">Status</span>
                <span class="text-uppercase successful">successful</span>
            </div>
            <div class="pb-20 pb-lg-0 mb-20 mb-lg-0 bb-sm-light-lavender3">
                <span class="d-block dark-grey2 f-12">Payment mode / Total</span>
                <span>Bank transfer -4.77 EUR</span>
            </div>
        </div> -->
    </div>
    @include('childs.bottom-bar')
@endsection