@extends('layouts.app')

<?php $attr = ['countryCode' => config('country.icode')]; ?>

@section('content')

<div class="container px-0 pt-40 pb-60">

    <div class="box-shadow bg-white w-xl-1220 mx-xl-auto">
        <div class="mx-auto">
            <div class="px-0">
                <div class="block margin-r-l">
                    <div class="row no-pd text-center param-block">
                        <h2 class="text-center prata lg-title">{{ t('Free vs Premium') }}</h2>
                        <p>{{ t('free_vs_premium_para') }}</p>
                        <div class="chart-table">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th class="disable-th item-name">{{ t('Service') }}</th>
                                        <th class="disable-th">{{ t('Free user account') }}</th>
                                        <th class="enable-th stra-icon back-img">{{ t('Premium account') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_1') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_2') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_3') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_4') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_5') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_6') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_7') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_8') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_9') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_10') }}</td>
                                        <td class="diable-item green-title">{{ t('Yes') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_11') }}</td>
                                        <td class="diable-item green-title">{{ t('Yes') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>

                                    @if($is_disable_premium_button)
                                        <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">{{ t('already_have_active_contract') }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="item-name">&nbsp;</td>
                                            @if($is_disable_basic_button)
                                                <td class="bg-white btn mobile-btn"><button class="disabled mobi mb-40" disabled>{{ t('Free Contract') }}</button></td>
                                            @else
                                                <td class="bg-white btn mobile-btn"><a href="{{  App\Helpers\CommonHelper::generateContractLink('_access_free', $user) }}" class="green mobi mb-40">{{ t('Free Contract') }}</a></td>
                                            @endif
                                            <td class=" bg-white btn mobile-btn"><a href="{{  App\Helpers\CommonHelper::generateContractLink('', $user) }}" class="green mobi mb-40">{{ $premium_button_label }}</a></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{ Html::style(config('app.cloud_url').'/css/bladeCss/static-inner-page.css') }}
{{ Html::style(config('app.cloud_url').'/css/premium-popup.css') }}

<style type="text/css">
    .chart-table table { table-layout: fixed; }
    .disabled { opacity: 0.6; cursor: not-allowed !important; }

    @media (max-width: 768px){
        .mobile-btn {  line-height: 10px !important; }
        .mobi { font-size: 10px !important; }
        .btn a { padding: 10px 20px !important; }
    }

</style>
@endsection