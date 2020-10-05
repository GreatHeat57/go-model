<?php

return [
	
	// payment_sent
	'payment_sent_title'             => 'Thanks for choosing offline payment!',
	'payment_sent_content_1'         => 'Hello,<br><br>We have received your offline payment request for the application.<br>We will wait to receive your payment to process your request.',
	'payment_sent_content_2'         => '<br><h1>Thank you !</h1>',
	'payment_sent_content_3'         => '<br><strong>Follow the information below to make the payment:</strong><br>Amount:</strong> :amount :currency<br><br>:paymentMethodDescription',
	'payment_offline_account_details' => '<br><br><strong>Below is the bank details to make payments:</strong><br><br><strong> :app_name</strong><br><strong>IBAN:</strong> :IBAN_NUMBER <br> <strong>BIC:</strong> :BIC_NUMBER <br><br> 
<strong>For bank transfer / purpose of use:</strong> :GO_CODE',
	'payment_sent_content_4'         => '<br><br>Kind Regards,<br>The :appName Team',
	
	
	// payment_notification
	'payment_notification_title'     => 'New offline payment request',
	'payment_notification_content_1' => 'Hello Admin,<br><br>The user :advertiserName has just made an offline payment request for her ad ":title".',
	'payment_notification_content_2' => '<br><br><strong>THE PAYMENT DETAILS</strong><br><strong>Reason of the payment:</strong> Ad #:adId - :packageName<br><strong>Amount:</strong> :amount :currency<br><strong>Payment Method:</strong> :paymentMethodName',
	'payment_notification_content_3' => '<br><br><strong>NOTE:</strong> After receiving the amount of the offline payment, you must manually approve the payment in the Admin panel -> Payments -> List -> (Search the "Reason of the payment" using the Ad ID and check the "Approved" checkbox).',
	'payment_notification_content_4' => '<br><br>Kind Regards,<br>The :appName Team',
	
];
