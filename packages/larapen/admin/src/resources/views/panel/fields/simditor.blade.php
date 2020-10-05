<!-- textarea -->
<div @include('admin::panel.inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <textarea
    	name="{{ $field['name'] }}"
        @include('admin::panel.inc.field_attributes')

    	>{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($xPanel->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <link media="all" rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/simditor/styles/simditor.css') }}" />
    <link media="all" rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/simditor/styles/simditor-html.css') }}" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="{{ asset('assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/module.js') }}"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/uploader.js') }}"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
    <script src="https://cdn.rawgit.com/beautify-web/js-beautify/v1.8.6/js/lib/beautify.js"></script>
    <script src="https://cdn.rawgit.com/beautify-web/js-beautify/v1.8.6/js/lib/beautify-css.js"></script>
    <script src="https://cdn.rawgit.com/beautify-web/js-beautify/v1.8.6/js/lib/beautify-html.js"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/simditor.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('assets/plugins/js-beautify/beautify-html.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('assets/plugins/simditor/scripts/simditor-html.js') }}"></script>

    @endpush

@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
<script>
    (function() {
        $(function() {
            var $preview, editor, mobileToolbar, toolbar, allowedTags;
            Simditor.locale = '{{ config('app.locale') }}-US';
            toolbar = ['bold','italic','underline','fontScale','|','ol','ul','blockquote','table','link','image','|','html'];
            mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
            if (mobilecheck()) {
                toolbar = mobileToolbar;
            }
            allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','h5','h6','hr','table', 'tr', 'td', 'div', 'form','button','iframe','thead','tbody', 'picture', 'source'];
            allowedAttributes = {
                img: ['src', 'alt', 'width', 'height', 'data-non-image', 'style', 'onerror','data-src', 'class', 'srcset'],
                a: ['href', 'target', 'class'],
                font: ['color', 'style'],
                div: ['class', 'style' , 'id'],
                h1: ['class', 'style' , 'id'],
                h2: ['class', 'style' , 'id'],
                h3: ['class', 'style' , 'id'],
                h4: ['class', 'style' , 'id'],
                h5: ['class', 'style' , 'id'],
                h6: ['class', 'style' , 'id'],
                button: ['class','style', 'id', 'role'],
                span: [ 'aria-label', 'class', 'style', 'id'],
                iframe:[ 'style', 'type', 'src', 'width', 'height' ,'id', 'class'],
                ul: [ 'class', 'style', 'id'],
                ol: [ 'class', 'style', 'id'],
                p: [ 'class', 'style', 'id'],
                table: [ 'style', 'type', 'src', 'width', 'height' ,'id', 'class', 'border'],
                tr: ['class'],
                td: ['class'],
                th: ['class'],
                source: ['media', 'srcset', 'onerror', 'data-image'],
                picture:['class'],
            };
            

            allowedStyles = {
                div: ['border-bottom', 'color' , 'text-align']
            };
            editor = new Simditor({
                textarea: $('#{{ (isset($field['attributes']) and isset($field['attributes']['id'])) ? $field['attributes']['id'] : 'input' }}'),
                //placeholder: '{{ t('Describe what makes your ad unique') }}...',
                toolbar: toolbar,
                pasteImage: false,
                defaultImage: '{{ asset('assets/plugins/simditor/images/image.png') }}',
                upload: {
                    url : '/ajax/smiditor/uploadSimditorImg',
                    params: { '_token' : '{{ csrf_token() }}'},
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: 'Uploading is in progress, are you sure to leave this page?'
                },
                allowedTags: allowedTags,
                allowedAttributes: allowedAttributes,
                allowedStyles: allowedStyles
            });
            $preview = $('#preview');
            if ($preview.length > 0) {
                return editor.on('valuechanged', function(e) {
                    return $preview.html(editor.getValue());
                });
            }
        });
    }).call(this);
</script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}