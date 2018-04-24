<div id="frontend_pages_home_popup" style="display: none">
    <div class="row">
        {!! $frontendHomePopup->content !!}
    </div>
    <div class="row">
        <a href="{{ $frontendHomePopupButtonUrl ? $frontendHomePopupButtonUrl : '#' }}" target="_blank">{{ $frontendHomePopupButtonText }}</a>
    </div>
</div>

<a class="hidden" data-fancybox data-src="#frontend_pages_home_popup" href="javascript:;" id="frontend_pages_home_popup_click">Button</a>

@push('scripts')
    <script>
    $('#frontend_pages_home_popup_click').trigger('click');
    </script>
@endpush
