<script>
$('.media_choose').each(function () {
    $(this).click(function () {
        if (this.getAttribute('data-fancybox_to') == 'tinymce') { // if tinymce

            if (top.tinymce.activeEditor.windowManager.getParams()) {
                var input = top.tinymce.activeEditor.windowManager.getParams().input;
                var win = top.tinymce.activeEditor.windowManager.getParams().window;
                win.document.getElementById(input).value = this.getAttribute('data-attached_file');
                top.tinymce.activeEditor.windowManager.close();
            }

        } else {

            var content = window.parent.document.getElementById('images_template').innerHTML
                .replace('$images_media_id', this.getAttribute('data-media_id'))
                .replace('$images_media_attached_file', this.getAttribute('data-attached_file'))
                .replace('$images_media_attached_file_thumbnail', this.getAttribute('data-attached_file_thumbnail'));

            window.parent.document
                .getElementById(this.getAttribute('data-fancybox_to'))
                .innerHTML += content;

            toastr.options = { closeButton: true, positionClass: 'toast-bottom-center', progressBar: true, timeOut: '2000' }
            toastr.success(this.getAttribute('data-success-message'));

        }
    });
});
</script>
