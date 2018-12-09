<div class="modal fade" id="modal-file-input">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('general.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">{{ __('clara-library::library.library') }}</h4>
            </div>
            <div class="modal-body">
                {!! BootForm::open() !!}
                    {!! BootForm::select(__('clara-library::library.folder'), 'fk_library_category')
                        ->class('select2 form-control')
                        ->data([
                            'url-select'    => route('api.admin.library-category.select'), 
                            'url-create'    => route('admin.library-category.create'),
                            'field'         => 'name_library_category'
                    ]) !!}
                {!! BootForm::close() !!}
                <input name="file" type="file" class="file fileinput" data-preview-file-type="text" multiple>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('general.close') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->