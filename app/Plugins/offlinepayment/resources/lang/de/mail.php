<?php

return [

	// payment_sent for the ad :title
	'payment_sent_title' => 'Vielen Dank, dass Sie sich für die Offline-Zahlung entschieden haben!',
	'payment_sent_content_1' => 'Hallo, <br> <br>wir haben Ihre Offline-Zahlungsanforderung für die Anwendung erhalten.<br> Wir warten auf Ihre Zahlung, um Ihre Anfrage zu bearbeiten.',
	'payment_sent_content_2' => '<br><h1>Vielen Dank !</h1>',
	'payment_sent_content_3' => '<br><strong>Befolgen Sie die folgenden Informationen, um die Zahlung vorzunehmen:</strong><br><strong>Betrag:</strong> :amount :currency<br><br>:paymentMethodDescription',
	'payment_offline_account_details' => '<br><br><strong>Unten finden Sie die Bankdaten für Zahlungen:</strong><br><br><strong> :app_name</strong><br><strong>IBAN:</strong> :IBAN_NUMBER <br> <strong>BIC:</strong> :BIC_NUMBER <br><br> <strong>Bei Banküberweisung/ Verwendungszweck:</strong> :GO_CODE',
	'payment_sent_content_4' => '<br><br>Mit freundlichen Grüßen,<br>The :appName Mannschaft',

	// payment_notification
	'payment_notification_title' => 'Neue Offline-Zahlungsanforderung',
	'payment_notification_content_1' => 'Hallo Admin,<br><br>Der Benutzer :advertiserName hat gerade eine Offline-Zahlungsanforderung für die Anzeige gestellt ":title".',
	'payment_notification_content_2' => '<br><br><strong>DIE ZAHLUNGSDETAILS</strong><br><strong>Grund der Zahlung:</strong> Ad #:adId - :packageName<br><strong>Menge:</strong> :amount :currency<br><strong>Zahlungsmethode:</strong> :paymentMethodName',
	'payment_notification_content_3' => '<br><br><strong>HINWEIS:</strong>Nach Erhalt des Betrags der Offline-Zahlung, Sie müssen die Zahlung im Admin-Bereich manuell genehmigen -> Zahlungen -> Liste -> (Suche das "Grund der Zahlung" Verwenden Sie die Anzeigen-ID und aktivieren Sie das Kontrollkästchen Genehmigt).',
	'payment_notification_content_4' => '<br><br>Mit freundlichen Grüßen,<br>The :appName Mannschaft',

];
