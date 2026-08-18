<?php

namespace App\Support;

/**
 * Converts the plain-text convention Super Admin types into legal-content
 * fields (## heading, - bullet, blank line = new paragraph) into HTML for
 * display. Keeps the editing textarea free of raw HTML tags — the person
 * typing into it doesn't need to know markup to format a document.
 */
class SimpleMarkdown
{
    public static function toHtml(string $text): string
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($text));
        $html = '';
        $listOpen = false;
        $paragraphBuffer = [];

        $flushParagraph = function () use (&$paragraphBuffer, &$html) {
            if (! empty($paragraphBuffer)) {
                $escaped = e(implode(' ', $paragraphBuffer));
                $escaped = preg_replace('/([\w.+-]+@[\w-]+(?:\.[\w-]+)*\.[a-zA-Z]{2,})/', '<a href="mailto:$1">$1</a>', $escaped);
                $html .= '<p>'.$escaped.'</p>'."\n";
                $paragraphBuffer = [];
            }
        };

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '') {
                $flushParagraph();

                continue;
            }

            if (str_starts_with($trimmed, '## ')) {
                $flushParagraph();
                if ($listOpen) {
                    $html .= "</ul>\n";
                    $listOpen = false;
                }
                $html .= '<h6 class="fw-semibold mt-4 mb-2">'.e(substr($trimmed, 3)).'</h6>'."\n";

                continue;
            }

            if (str_starts_with($trimmed, '- ')) {
                $flushParagraph();
                if (! $listOpen) {
                    $html .= "<ul>\n";
                    $listOpen = true;
                }
                $html .= '<li>'.e(substr($trimmed, 2)).'</li>'."\n";

                continue;
            }

            if ($listOpen) {
                $html .= "</ul>\n";
                $listOpen = false;
            }
            $paragraphBuffer[] = $trimmed;
        }

        $flushParagraph();
        if ($listOpen) {
            $html .= "</ul>\n";
        }

        return $html;
    }
}
