@push('scripts')
    <script>
    var galleryMediaer = new qq.FineUploader({
        callbacks: {
            onError: function(id, name, errorReason, xhrOrXdr) {
                alert(qq.format('{} {}', name, xhrOrXdr.responseText));
            }
        },
        element: document.getElementById('fine-uploader-gallery'),
        request: {
            customHeaders: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            endpoint: '{{ route('backend.media.upload') }}',
        },
        template: 'qq-template',
    });
    </script>
@endpush
