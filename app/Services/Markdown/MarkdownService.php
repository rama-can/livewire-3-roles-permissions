<?php

namespace App\Services\Markdown;

interface MarkdownService
{
    function convertToHtml(string $markdown, string $theme = 'github-dark'): string;
}
