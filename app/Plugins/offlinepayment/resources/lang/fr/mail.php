<?php

return [
	
	// payment_sent
	'payment_sent_title'             => 'Merci d\'avoir choisi le paiement hors ligne!',
	'payment_sent_content_1'         => 'Bonjour,<br><br>Nous avons bien reçu votre demande pour le payment hors ligne concernant l\'annonce ":title".<br>Nous allons attendre de recevoir votre paiement pour traiter votre demande.',
	'payment_sent_content_2'         => '<br><h1>Merci !</h1>',
	'payment_sent_content_3'         => '<br><strong>Suivez les informations ci-dessous pour effectuer le paiement:</strong><br><strong>Motif de paiement:</strong> Annonce #:adId - :packageName<br><strong>Montant:</strong> :amount :currency<br><br>:paymentMethodDescription',
	'payment_sent_content_4'         => '<br><br>Meilleures salutations,<br>L\'équipe :appName',
	
	
	// payment_notification
	'payment_notification_title'     => 'Nouvelle demande de paiement hors ligne',
	'payment_notification_content_1' => 'Bonjour Admin,<br><br>L\'utilisateur :advertiserName vient de faire une demande de paiement hors ligne pour son annonce ":title".',
	'payment_notification_content_2' => '<br><br><strong>DETAILS DU PAIEMENT</strong><br><strong>Motif du paiement:</strong> Annonce #:adId - :packageName<br><strong>Montant:</strong> :amount :currency<br><strong>Moyen de paiement:</strong> :paymentMethodName',
	'payment_notification_content_3' => '<br><br><strong>NOTE:</strong> Après avoir encaissé le montant du paiement hors ligne, vous devez approuver manuellement le paiement dans l\'Admin panel -> Payments -> List -> (Recherchez le "Motif du paiement" en utilisant l\'ID de l\'annonce et cocher la case "Approuvé").',
	'payment_notification_content_4' => '<br><br>Meilleures salutations,<br>L\'équipe :appName',
	
];
