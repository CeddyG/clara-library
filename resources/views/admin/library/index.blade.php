@extends('admin/dashboard')

@section('CSS')
    <!-- Select 2 -->
    {!! Html::style('bower_components/select2/dist/css/select2.min.css') !!}
    <!-- FileInput -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Liste</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
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
            <!-- /.box-body -->
            <div class="box-footer clearfix"></div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! BootForm::open()->id('form-library') !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('general.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                {!! BootForm::hidden('id_library')->id('id_library') !!}
                {!! BootForm::text(__('clara-library::library.title_library'), 'title_library') !!}
                {!! BootForm::text(__('clara-library::library.slug_library'), 'slug_library') !!}
                {!! BootForm::textarea(__('clara-library::library.description_library'), 'description_library')->addClass('ckeditor') !!}
                <div class="form-group">
                    <label>URL</label><br />
                    <span id="url_library"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('general.close') }}</button>
                <button type="submit" class="btn btn-primary" id="submit-modal">{{ __('general.save') }}</button>
            </div>
            {!! BootForm::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('JS')
    
    <!-- Select 2 -->
    {!! Html::script('bower_components/select2/dist/js/select2.full.min.js') !!}
    
    <script>
        $(document).ready(function() {
            $('.select2').wrap('<div class="input-group input-group-select2"></div>');
            $( ".input-group-select2" ).each(function () {
                var url = $(this).find('.select2').attr(('data-url-create'));
                $(this).prepend('<a href="'+ url +'" target="_blank" class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></a>');
            });
            
            $('.select2').select2({
                ajax: {
                    url: function () {
                        return $(this).attr('data-url-select');
                    },
                    dataType: 'json',
                    delay: 10,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            field: $(this).attr('data-field'),
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data
                        params.page = params.page || 1;
                
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count 
                }
                        };
                    },
                    cache: true
                },
                them: 'bootstrap'
            });
        } );
    </script> 
    
    <!-- FileInput -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/locales/{{ App::getLocale() }}.js"></script>
    
    <script>
        $('.fileinput').fileinput({
            language: '{{ App::getLocale() }}',
            uploadUrl: '{{ url('upload') }}',
            showClose: false,
            maxImageWidth: 200,
            resizeImage: true,
            overwriteInitial: false,
            showUpload: false, // hide upload button
            showRemove: false, // hide remove button
            showUploadedThumbs: true        
        });
        $('.file-input').hide();
        
        $('body').on('click', '.kv-cust-btn', function() {
            var key = $(this).data('key');
            var url = '{{ route('api.admin.library.edit', 'dummyId') }}';
            
            $.ajax({
                url: url.replace('dummyId', key),   
                async: false,
                data: {
                    column: [
                        'title_library',
                        'slug_library',
                        'description_library',
                        'full_url'
                    ]
                },
                success: function(data) {
                    if (data.description_library == null)
                    {
                        data.description_library = '';
                    }
                    
                    $('#id_library').val(key);
                    $('#title_library').val(data.title_library);
                    $('#slug_library').val(data.slug_library);
                    CKEDITOR.instances['description_library'].setData(data.description_library);
                    $('#url_library').html(data.full_url);
                }
            });
            
            $('#modal').modal();
        }); 
        
        $('#form-library').on('submit', function(event) {
            event.preventDefault();
            
            var id = $('#id_library').val();
            var url = '{{ route('api.admin.library.update', 'dummyId') }}';
            
            $.ajax({
                url: url.replace('dummyId', id),
                type: 'PUT',    
                async: false,
                data: {
                    'title_library': $('#title_library').val(),
                    'slug_library': $('#slug_library').val(),
                    'description_library': CKEDITOR.instances['description_library'].getData()
                    
                },
                success: function(data) {
                    buildFileInput();
                    $('#modal').modal('hide');
                }
            });
        });
        
        var editButton = '<button type="button" class="kv-cust-btn btn btn-sm btn-kv btn-default  btn-outline-secondary" title="Edit"{dataKey}>' +
            '<i class="fa fa-edit"></i>' +
            '</button>';
        
        $('#fk_library_category').on('change', function(){
            buildFileInput();
        });
        
        function buildFileInput()
        {
            var iFkCategory = $('#fk_library_category').val();
            $.ajax({
                url: '{{ route('api.admin.library.index') }}',
                data: {
                    fk_library_category: iFkCategory
                },
                success: function(data) {                    
                    var sUrl = '{{ asset('') }}';
                    var sUrlDel = '{{ route('api.admin.library.destroy', 'dummyId') }}';
                    var aFiles = [];
                    var aUrl = [];
                    
                    for (var i = 0 ; i < data.length ; i++)
                    {
                        aUrl.push(sUrl+data[i].url_library);
                        aFiles.push(
                            {
                                key: data[i].id_library,
                                caption: data[i].title_library, 
                                downloadUrl: sUrl+data[i].url_library,
                                url: sUrlDel.replace('dummyId', data[i].id_library),
                                filename: sUrl+data[i].url_library
                            }
                        );
                    }
                    
                    $('.fileinput').fileinput('destroy');
                    $('.fileinput').fileinput({
                        language: '{{ App::getLocale() }}',
                        uploadUrl: '{{ route('api.admin.library.store') }}',
                        uploadExtraData: {
                            fk_library_category: iFkCategory
                        },
                        ajaxDeleteSettings: {
                            method: 'DELETE'
                        },
                        showClose: false,
                        overwriteInitial: false,
                        showUploadedThumbs: true,
                        initialPreviewAsData: true,    
                        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
                        fileActionSettings: {
                            showDrag: false
                        },
                        showUpload: false, // hide upload button
                        showRemove: false, // hide remove button
                        otherActionButtons: editButton,
                        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
                        previewFileIconSettings: { // configure your icon file extensions
                            'doc': '<i class="fa fa-file-word-o text-primary"></i>',
                            'xls': '<i class="fa fa-file-excel-o text-success"></i>',
                            'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                            'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
                            'zip': '<i class="fa fa-file-zip-o text-muted"></i>',
                            'htm': '<i class="fa fa-file-code-o text-info"></i>',
                            'txt': '<i class="fa fa-file-text-o text-info"></i>',
                            'mov': '<i class="fa fa-file-video-o text-warning"></i>',
                            'mp3': '<i class="fa fa-file-audio-o text-warning"></i>'    
                        },
                        previewFileExtSettings: { // configure the logic for determining icon file extensions
                            'doc': function(ext) {
                                return ext.match(/(doc|docx)$/i);
                            },
                            'xls': function(ext) {
                                return ext.match(/(xls|xlsx)$/i);
                            },
                            'ppt': function(ext) {
                                return ext.match(/(ppt|pptx)$/i);
                            },
                            'zip': function(ext) {
                                return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                            },
                            'htm': function(ext) {
                                return ext.match(/(htm|html)$/i);
                            },
                            'txt': function(ext) {
                                return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                            },
                            'mov': function(ext) {
                                return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                            },
                            'mp3': function(ext) {
                                return ext.match(/(mp3|wav)$/i);
                            }
                        },
                        initialPreview: aUrl,
                        initialPreviewConfig: aFiles
                    }).on("filebatchselected", function(event, files) {
                        $(this).fileinput('upload');
                    }).on("fileuploaded", function(event, data, previewId, index) {
                        buildFileInput();
                    });
                }
            });
        }
    </script>

    {!! Html::script('bower_components/ckeditor/ckeditor.js') !!}
    
    <script>
        $(function () {
            CKEDITOR.config.extraPlugins = 'colorbutton,colordialog';
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('.ckeditor');
        });
    </script>
@endsection
