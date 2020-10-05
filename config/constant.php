<?php

return [

	/*
		    |--------------------------------------------------------------------------
		    | Admin Email Address
		    |--------------------------------------------------------------------------
		    |
		    | Here you may provide the email address for send application error messages.
		    |
	*/
	/* 'admin_email' => env('ADMIN_MAIL_TO', 'null'),
	'admin_email2' => env('ADMIN_MAIL_BCC', 'null'),
	'admin_email_migration' => 'adminmigration_itellico@yopmail.com',
	'suppport_email' => 'support@go-models.com',

	'MODEL_CATEGORY_IMAGE_PATH' => '/uploads/categories/' */
	'messages_limit' => '6',
	'messages_per_page' => '6',
	'dashboard_limit' => '12',
	'gender_male' => '1',
	'gender_female' => '2',
	'gender_both'	=> '0',
	'partner_type_id' => '2',
	'model_type_id'	=> '3',
	'admin_type_id' => '1',
	'crm_male' => '1',
	'crm_female' => '0',
	'crm_partner' => '4',
	'crm_model' => '1',
	'description_limit' => '180',
	'title_limit' => '40',
	'message_content_limit' => '200',
	'IBAN_NUMBER' => 'AT301200010019660223',
	'BIC_NUMBER' => 'BKAUATWW',
	'POST_AUTHOR_ID' => '5',
	'JOB_TIME_START' => 0,
	'JOB_TIME_END' => 24,
	'PROFILE_THUMB' => [150, 200, 250 ],
	'THUMB' => 'thumb',
	'LOGO_THUMB' => 150,
	'COMPANY_THUMB' => 600,
	'available_contact_12_hours_from_format' => '09:00 AM',
	'available_contact_12_hours_to_format' => '07:00 PM', 
	'available_contact_24_hours_from_format' => '09:00',
	'available_contact_24_hours_to_format' => '19:00',

	'google_tag_manager_id' => (config('app.env') === 'live') ? 'GTM-T5RPTCX' : 'GTM-5MDBX23',
	
	/* Goole tag manager */
	'Google_Tag_Manager'=>(config('app.env') === 'live')?"<script defer>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.defer=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-T5RPTCX');</script>":'',

	/* noscript Goole tag manager */	
	'noscript_Google_Tag_Manager'=>(config('app.env') === 'live')?'<noscript defer><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5RPTCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>':'',

	'href_lang' => ['en_US'=>'en', 'de_DE'=>'de', 'en_GB'=>'en-GB'],

	// key : CRM payment method name and value : laravel payment method name
	'PAYMENT_METHODS'  => ['paypal' => 'paypal', 'cc' => 'card', 'ideal' => 'ideal', 'sofort' => 'sofort', 'eps' => 'eps', 'giro-pay' => 'giropay', 'direct-debit' => 'sepa', 'applepay' => 'applepay', 'bank-transfer' => 'offlinepayment'],

	/* osano cookie setting for live */
	/*'Cookie_Google_Tag_Manager'=>(config('app.env') === 'live')?"<script defer>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T5RPTCX');</script>":"",

	'Cookie_noscript_Google_Tag_Manager'=>(config('app.env') === 'live')?'<noscript defer><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T5RPTCX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>':'',*/

	/* osano cookie setting for staging */
	'Cookie_Google_Tag_Manager'=>(config('app.env') === 'staging')?"<script defer>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5MDBX23');</script>":"",

	'Cookie_noscript_Google_Tag_Manager'=>(config('app.env') === 'staging')?'<noscript defer><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5MDBX23" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>':'',

	'country_premium' => 'premium',
	'country_free' => 'free',
	'SEDCARD_POST_ARRAY' => [11953, 11951],
	'upgradelink' => 'upgrade=1',
	'user_type_free' => 'free',
	'user_type_premium' => 'premium',
	'user_type_premium_send' => 'premium_send',
	'CURL_AUTHORIZATION' => 'Basic YXBpOl9qZGhkZHcyMjMyYnZnSGZkYm5fbWJ2aGZ6ZGZiZGV3ZHM=',
	'free_model_book_upload_limit' => 30,
	'number_of_jobs_show_premium' => 3,
	'HIDE_OFFLINE_PAYMENT' => ['uk', 'ie'],
];
