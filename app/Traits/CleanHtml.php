<?php

namespace App\Traits;

trait CleanHtml
{
    public static function clean_html($html_str)
    {
        $xml = new \DOMDocument();
        libxml_use_internal_errors(true);
        $allowed_tags = ['html', 'body', 'b', 'strong', 'br', 'em', 'hr', 'i', 'li', 'ol', 'p', 's', 'span', 'table', 'tr', 'td', 'u', 'ul', 'img', 'a', 'div', 'iframe', 'h1', 'h2', 'h3', 'h4', 'h5', 'h5'];
        $allowed_attrs = ['class', 'style', 'href', 'target', 'src', 'contenteditable', 'allowfullscreen', 'frameborder', 'allow'];
        if (! strlen($html_str)) {
            return false;
        }
        if ($xml->loadHTML(mb_convert_encoding($html_str, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
            // remove  unwanted tags
            foreach ($xml->getElementsByTagName('*') as $tag) {
                if (! in_array($tag->tagName, $allowed_tags)) {
                    $tag->parentNode->removeChild($tag);
                } else {
                    foreach ($tag->attributes as $attr) {
                        if (! in_array($attr->nodeName, $allowed_attrs)) {
                            $tag->removeAttribute($attr->nodeName);
                        }
                    }
                }
            }
        }

        return $xml->saveHTML($xml->documentElement);
    }
}
