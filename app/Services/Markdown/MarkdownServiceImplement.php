<?php

namespace App\Services\Markdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

class MarkdownServiceImplement implements MarkdownService
{
    function convertToHtml(string $markdown, string $theme = 'github-dark'): string
    {
        $environment = (new Environment())
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new HighlightCodeExtension(theme: $theme));

        $markdownConverter = new MarkdownConverter(environment: $environment);

        return $markdownConverter->convert($markdown);
    }
}
