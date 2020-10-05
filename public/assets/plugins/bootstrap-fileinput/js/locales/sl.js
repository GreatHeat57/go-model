/*!
 * FileInput Slovenian Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 * @author kv1dr <kv1dr.android@gmail.com>
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";

    $.fn.fileinputLocales['sl'] = {
        fileSingle: 'datoteka',
        filePlural: 'datotek',
        browseLabel: 'Prebrskaj &hellip;',
        removeLabel: 'Odstrani',
        removeTitle: 'Počisti izbrane datoteke',
        cancelLabel: 'Prekliči',
        cancelTitle: 'Prekliči nalaganje',
        uploadLabel: 'Naloži',
        uploadTitle: 'Naloži izbrane datoteke',
        msgNo: 'Ne',
        msgNoFilesSelected: 'Nobena datoteka ni izbrana',
        msgCancelled: 'Preklicano',
<<<<<<< HEAD
        msgPlaceholder: 'Select {files}...',
=======
        msgPlaceholder: 'Select {files}...',
>>>>>>> 8ad577ab59500eda53799ccd3423a0757924f237
        msgZoomModalHeading: 'Podroben predogled',
        msgSizeTooLarge: 'Datoteka "{name}" (<b>{size} KB</b>) presega največjo dovoljeno velikost za nalaganje <b>{maxSize} KB</b>.',
        msgFilesTooLess: 'Za nalaganje morate izbrati vsaj <b>{n}</b> {files}.',
        msgFilesTooMany: 'Število datotek, izbranih za nalaganje <b>({n})</b> je prekoračilo največjo dovoljeno število <b>{m}</b>.',
        msgFileNotFound: 'Datoteka "{name}" ni bila najdena!',
        msgFileSecured: 'Zaradi varnostnih omejitev nisem mogel prebrati datoteko "{name}".',
        msgFileNotReadable: 'Datoteka "{name}" ni berljiva.',
        msgFilePreviewAborted: 'Predogled datoteke "{name}" preklican.',
        msgFilePreviewError: 'Pri branju datoteke "{name}" je prišlo do napake.',
        msgInvalidFileType: 'Napačen tip datoteke "{name}". Samo "{types}" datoteke so podprte.',
        msgInvalidFileExtension: 'Napačna končnica datoteke "{name}". Samo "{extensions}" datoteke so podprte.',
<<<<<<< HEAD
        msgFileTypes: {
            'image': 'image',
            'html': 'HTML',
            'text': 'text',
            'video': 'video',
            'audio': 'audio',
            'flash': 'flash',
            'pdf': 'PDF',
            'object': 'object'
        },
        msgUploadAborted: 'Nalaganje datoteke je bilo preklicano',
        msgUploadThreshold: 'Procesiram...',
        msgUploadBegin: 'Initializing...',
        msgUploadEnd: 'Done',
        msgUploadEmpty: 'No valid data available for upload.',
        msgUploadError: 'Error',
=======
        msgFileTypes: {
            'image': 'image',
            'html': 'HTML',
            'text': 'text',
            'video': 'video',
            'audio': 'audio',
            'flash': 'flash',
            'pdf': 'PDF',
            'object': 'object'
        },
        msgUploadAborted: 'Nalaganje datoteke je bilo preklicano',
        msgUploadThreshold: 'Procesiram...',
        msgUploadBegin: 'Initializing...',
        msgUploadEnd: 'Done',
        msgUploadEmpty: 'No valid data available for upload.',
        msgUploadError: 'Error',
>>>>>>> 8ad577ab59500eda53799ccd3423a0757924f237
        msgValidationError: 'Napaki pri validiranju',
        msgLoading: 'Nalaganje datoteke {index} od {files} &hellip;',
        msgProgress: 'Nalaganje datoteke {index} od {files} - {name} - {percent}% dokončano.',
        msgSelected: '{n} {files} izbrano',
        msgFoldersNotAllowed: 'Povlecite in spustite samo datoteke! Izpuščenih je bilo {n} map.',
        msgImageWidthSmall: 'Širina slike "{name}" mora biti vsaj {size} px.',
        msgImageHeightSmall: 'Višina slike "{name}" mora biti vsaj {size} px.',
        msgImageWidthLarge: 'Širina slike "{name}" ne sme preseči {size} px.',
        msgImageHeightLarge: 'Višina slike "{name}" ne sme preseči {size} px.',
        msgImageResizeError: 'Nisem mogel pridobiti dimenzij slike za spreminjanje velikosti.',
        msgImageResizeException: 'Napaka pri spreminjanju velikosti slike.<pre>{errors}</pre>',
<<<<<<< HEAD
        msgAjaxError: 'Something went wrong with the {operation} operation. Please try again later!',
        msgAjaxProgressError: '{operation} failed',
        ajaxOperations: {
            deleteThumb: 'file delete',
            uploadThumb: 'file upload',
            uploadBatch: 'batch file upload',
            uploadExtra: 'form data upload'
        },
=======
        msgAjaxError: 'Something went wrong with the {operation} operation. Please try again later!',
        msgAjaxProgressError: '{operation} failed',
        ajaxOperations: {
            deleteThumb: 'file delete',
            uploadThumb: 'file upload',
            uploadBatch: 'batch file upload',
            uploadExtra: 'form data upload'
        },
>>>>>>> 8ad577ab59500eda53799ccd3423a0757924f237
        dropZoneTitle: 'Povlecite in spustite datoteke sem &hellip;',
        dropZoneClickTitle: '<br>(ali kliknite sem za izbiro {files})',
        fileActionSettings: {
            removeTitle: 'Odstrani datoteko',
            uploadTitle: 'Naloži datoteko',
<<<<<<< HEAD
            uploadRetryTitle: 'Retry upload',
            downloadTitle: 'Download file',
=======
            uploadRetryTitle: 'Retry upload',
            downloadTitle: 'Download file',
>>>>>>> 8ad577ab59500eda53799ccd3423a0757924f237
            zoomTitle: 'Poglej podrobnosti',
            dragTitle: 'Premaki / Razporedi',
            indicatorNewTitle: 'Še ni naloženo',
            indicatorSuccessTitle: 'Naloženo',
            indicatorErrorTitle: 'Napaka pri nalaganju',
            indicatorLoadingTitle: 'Nalagam ...'
        },
        previewZoomButtonTitles: {
            prev: 'Poglej prejšno datoteko',
            next: 'Poglej naslednjo datoteko',
            toggleheader: 'Preklopi glavo',
            fullscreen: 'Preklopi celozaslonski način',
            borderless: 'Preklopi način brez robov',
            close: 'Zapri predogled podrobnosti'
        }
    };
})(window.jQuery);
