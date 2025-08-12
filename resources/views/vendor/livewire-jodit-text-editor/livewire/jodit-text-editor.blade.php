<div wire:ignore>
    <textarea id="{{ $joditId }}">{!! $value !!}</textarea>
</div>

@script
    <script>
        const buttons = @json($buttons);

        const editor = Jodit.make('#' + @js($joditId), {
            "placeholder": '',
            "autofocus": false,
            "toolbarSticky": true,
            "uploader": {
                "insertImageAsBase64URI": true
            },
            "toolbarButtonSize": "medium",
            "showCharsCounter": false,
            "showWordsCounter": false,
            "showXPathInStatusbar": false,
            "defaultActionOnPaste": "insert_clear_html",
        });

        document.getElementById(@js($joditId)).addEventListener('change', function() {
            @this.set('value', this.value);
        });

        Livewire.on('update-jodit-content', (description) => {
            // Check if this is an array with [editorId, content]
            // if (Array.isArray(event.detail) && event.detail.length === 2) {
            //     const [targetId, newContent] = event.detail;

            //     // Only update if the editor ID matches this instance
            //     if (targetId === @js($identifier)) {
            //         editor.value = newContent;
            //     }
            // } else {
            //     // Original behavior: update all editors (backward compatibility)
            //     editor.value = event.detail[0];
            // }
            // console.log(description);
        });
    </script>
@endscript
