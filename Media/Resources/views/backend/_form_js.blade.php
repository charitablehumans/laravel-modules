@push('scripts')
    <script>
    var galleryMediaer = new qq.FineUploader({
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
