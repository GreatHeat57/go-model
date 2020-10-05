<div @include('admin::panel.inc.field_wrapper_attributes') >
	<label>{!! $field['label'] !!}</label>
	<textarea name="{{ $field['name'] }}" @include('admin::panel.inc.field_attributes')>{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>
</div>

@push('crud_fields_styles')
<link rel="stylesheet" href="{{ asset('vendor-admin/adminlte/plugins/jQuery-tagEditor-master/jquery.tag-editor.css') }}">
@endpush

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
<script charset="UTF-8" src="{{ asset('vendor-admin/adminlte/plugins/jQuery-tagEditor-master/jquery.caret.min.js') }}"></script>
<script charset="UTF-8" src="{{ asset('vendor-admin/adminlte/plugins/jQuery-tagEditor-master/jquery.tag-editor.min.js') }}"></script>
<script>
    $('[name="tags"]').tagEditor();
</script>
@endpush