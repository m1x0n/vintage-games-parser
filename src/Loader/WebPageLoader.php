<?php

namespace VintageGamesParser\Loader;

class WebPageLoader implements ContentLoaderInterface
{
    const USER_AGENT =
        "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36";

    public function load($path)
    {
        $options = [
            'http' => [
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "User-Agent: " . self::USER_AGENT . "\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $file = file_get_contents($path, false, $context);

        return $file;
    }
}