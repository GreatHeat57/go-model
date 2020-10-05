<?php

return [

	// payment_sent
	'payment_sent_title' => 'Gracias por elegir el pago en línea!',
	'payment_sent_content_1' => 'Hola, <br> <br> Hemos recibido su solicitud de pago sin conexión para el anuncio ": title". <br> Esperaremos para recibir su pago para procesar su solicitud.',
	'payment_sent_content_2' => '<br><h1>Gracias !</h1>',
	'payment_sent_content_3' => '<br><strong>Siga la siguiente información para realizar el pago:</strong><br><strong>Razón de pago:</strong> Ad #:adId - :packageName<br><strong>Cantidad:</strong> :amount :currency<br><br>:paymentMethodDescription',
	'payment_sent_content_4' => '<br><br>Saludos cordiales,<br>los :appName Equipo',

	// payment_notification
	'payment_notification_title' => 'Nueva solicitud de pago offline',
	'payment_notification_content_1' => 'Hola admin,<br><br>El usuario :advertiserName acaba de realizar una solicitud de pago sin conexión para su anuncio ": title".',
	'payment_notification_content_2' => '<br><br><strong>LOS DETALLES DE PAGO</strong><br><strong>Razón del pago:</strong> Ad #:adId - :packageName<br><strong>Cantidad:</strong> :amount :currency<br><strong>Método de pago:</strong> :paymentMethodName',
	'payment_notification_content_3' => '<br><br><strong>NOTA:</strong> Después de recibir el monto del pago fuera de línea, debe aprobar manualmente el pago en el panel de administración -> Pagos -> Lista -> (Busque el "Motivo del pago" mediante la identificación del anuncio y marque la casilla de verificación "Aprobado").',
	'payment_notification_content_4' => '<br><br>Saludos cordiales,<br>los :appName Equipo',

];
