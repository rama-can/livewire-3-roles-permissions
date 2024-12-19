@push('styles')
<style>
    .CodeMirror {
        height: 400px;
        overflow: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css"
/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
@endpush

<div
    x-data="{ content: @entangle($attributes->wire('model')) }"
    wire:ignore
    x-init="
    console.log('EasyMDE', EasyMDE); // Verifikasi apakah EasyMDE terdefinisi
    if (typeof EasyMDE === 'undefined') {
        console.error('EasyMDE is not loaded');
    } else {
        let uniqueId = '{{ $attributes->get('id') ?? 'editor-' . uniqid() }}';
        $refs.markdownEditor.id = uniqueId;

        $nextTick(() => {
            let editor = new EasyMDE({
                element: $refs.markdownEditor,
                toolbar: ['bold', 'italic', 'heading', '|', 'unordered-list', 'ordered-list', '|', 'link', 'image', '|', 'preview', 'side-by-side', 'fullscreen'],
                spellChecker: false,
                autosave: {
                    enabled: false,
                },
                renderingConfig: {
                    codeSyntaxHighlighting: true,
                    highlightCallback: (code) => {
                        return hljs.highlight(code, { language: lang }).value;
                    },
                },
            });
            //

            editor.value(content);
            editor.codemirror.on('change', () => {
                content = editor.value();
            });

            $watch('content', (value) => {
                if (editor.value() !== value) {
                    editor.value(value);
                }
            });
        });
    }
    "
    class="mt-4"
>
    <label for="{{ $attributes->get('id') ?? 'editor' }}" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
        {{ $label }}
    </label>
    <textarea x-ref="markdownEditor" class="hidden"></textarea>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js" defer></script>
@endpush
