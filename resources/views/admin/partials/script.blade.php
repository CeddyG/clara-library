<!-- FileInput -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.5.1/js/locales/{{ App::getLocale() }}.js"></script>

<script>
    var currentFileElement = null;
    
    $('.fileinput-element').wrap('<div class="input-group input-group-fileinput-element"></div>');
    $('.input-group-fileinput-element').each(function () {
        $(this).prepend('<span class="input-group-addon addon-fileinput"><i class="glyphicon glyphicon-folder-open"></i></span>');
    });
    
    $('.addon-fileinput').on('click', function(){
        currentFileElement = $(this).next('.fileinput-element');

        $('#modal-file-input').modal();
    });

    $('body').on('click', '.kv-file-content', function(){
        console.log($(this).find('.kv-file-download'));
        currentFileElement.val(
            $(this).next('.file-thumbnail-footer').find('.kv-file-download').attr('href')
        );

        $('#modal-file-input').modal('hide');
    });

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
        console.log(id);
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