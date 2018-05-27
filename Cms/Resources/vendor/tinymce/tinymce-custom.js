function tinymce_init()
{
    // delete var document_base_url = document.querySelector('meta[name=app_url]').getAttribute('content');
    // delete document_base_url += document_base_url.endsWith('/') ? '' : '/';
    tinyMCE.baseURL = document.querySelector('meta[name=app_url]').getAttribute('content')+'/bower/tinymce';
    tinyMCE.init({
        branding: false,
        codemirror: {
            config: { // CodeMirror config object
                mode: 'application/x-httpd-php',
                indentWithTabs: true,
                lineNumbers: true,
                // lineWrapping: false,
            },
            // fullscreen: true, // Default setting is false
            // height: 600, // Default value is 550
            indentOnInit: true, // Whether or not to indent code on init.
            jsFiles: [ // Additional JS files to load
                'mode/clike/clike.js',
                'mode/php/php.js'
            ],
            path: 'codemirror', // Path to CodeMirror distribution
            // saveCursorPosition: true, // Insert caret marker
            // width: 800 // Default value is 800
        },
        // delete document_base_url: document_base_url,
        file_browser_callback: function (field_name, url, type, win) {
            var mime_type_like = '';
            if (type == 'image') {
                mime_type_like = 'image/';
            } else if (type == 'media') {
                mime_type_like = 'audio/,video/';
            }

            tinyMCE.activeEditor.windowManager.open({
                file: document.querySelector('meta[name=app_url]').getAttribute('content')+'/backend/media?fancybox_to=tinymce&layout=media_iframe&mime_type_like_in='+mime_type_like,
                height: window.innerHeight - 40,
                title: document.querySelector('meta[name=app_name]').getAttribute('content'),
                width: window.innerWidth - 50,
            }, {
                input: field_name,
                window: win
            });

            return false;
        },
        image_advtab: true,
        // menubar: false,
        // mobile: { theme: 'mobile' },
        plugins: 'advlist charmap code codemirror codesample fullscreen help hr image link lists media pagebreak textcolor visualblocks visualchars wordcount',
        relative_urls: false,
        remove_script_host: false,
        resize: false,
        selector: 'textarea.tinymce',
        skin_url: document.querySelector('meta[name=app_url]').getAttribute('content')+'/bower/tinymce/skins/lightgray',
        theme_url: document.querySelector('meta[name=app_url]').getAttribute('content')+'/bower/tinymce/themes/modern/theme.min.js',
        toolbar: false,
        // toolbar: [
        //     'formatselect bold italic bullist numlist | alignleft aligncenter alignright alignjustify link pagebreak',
        //     'strikethrough hr forecolor backcolor | removeformat charmap outdent indent | undo redo help codesample | code fullscreen'
        // ]
    });
}

$(document).ajaxSuccess(function() {
    tinymce_init();
});

$(document).ready(function() {
    tinymce_init();
});
