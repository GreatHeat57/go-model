<!-- CKeditor -->
<div @include('admin::panel.inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <textarea
    	id="ckeditor-{{ $field['name'] }}"
        name="{{ $field['name'] }}"
        @include('admin::panel.inc.field_attributes', ['default_class' => 'form-control ckeditor'])
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
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- <script src="{{ asset('vendor/vendor/admin/ckeditor/ckeditor.js') }}"></script> -->
        <script type="text/javascript" src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc"></script>
        <!-- <script src="{{ asset('vendor/vendor/admin/ckeditor/adapters/jquery.js') }}"></script> -->
        <!-- <script src="https://cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script> -->
    @endpush

@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
<script>
    jQuery(document).ready(function($) {
        // CKEdito Toolbar
        // CKEDITOR.config.toolbar = [
        //     ['Bold','Italic','Underline','Strike','-','RemoveFormat','-','NumberedList','BulletedList','-','Undo','Redo','-','Table','-','Link','Unlink','Smiley','Source']
        // ];
        // CKEDITOR.config.extraAllowedContent = true;
        // CKEDITOR.config.extraAllowedContent = 'p div span';
        // CKEDITOR.replace('ckeditor-description');
        // $('textarea[name="{{ $field['name'] }}"].ckeditor').ckeditor({
        //     //"filebrowserBrowseUrl": "{{ url(config('larapen.admin.route_prefix').'/elfinder/ckeditor') }}",
        //     //"extraPlugins" : '{{ isset($field['extra_plugins']) ? implode(',', $field['extra_plugins']) : 'oembed,widget' }}',
        //     language: '{{ config('app.locale') }}'
        // });
        tinymce.init({
          selector: 'textarea',
          height: 500,
          theme: 'modern',
          plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
          toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
          image_advtab: true,
          templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
          ],
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
          ]
         });

    });
</script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
