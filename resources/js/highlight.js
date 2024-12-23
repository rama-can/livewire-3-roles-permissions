import hljs from 'highlight.js';

document.addEventListener('livewire:navigated', () => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightElement(block);
    });
});
