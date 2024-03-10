<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

class FileManager
{
    public static function create(string $file_path): void
    {
        $file = fopen($file_path, 'w') or exit('Unable to open file!');
        fclose($file);
    }

    public static function append(string $file_path, string $text): void
    {
        $file = fopen($file_path, 'a') or exit('Unable to open file!');
        fwrite($file, PHP_EOL.self::fixString($text));
        fclose($file);
    }

    public static function replace(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, self::fixString($replace), file_get_contents($path)));
    }

    public static function writteAfter(string $search, string $add, string $path): void
    {
        file_put_contents($path, str_replace($search, $search.self::fixString($add), file_get_contents($path)));
    }

    public static function fixString(string $content): string
    {
        return str_replace('*', '    ', $content);
    }

    public static function loadJsonFile(string $path): array
    {
        return json_decode(file_get_contents($path), true);
    }

    public static function writteJson(string $path, array $content): void
    {
        file_put_contents(
            $path,
            json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    public static function appendToJsonKey(string $path, array $new_content, $key): void
    {
        $content = self::loadJsonFile($path);
        $content[$key] = array_merge($content[$key], $new_content);
        ksort($content[$key]);

        file_put_contents(
            $path,
            json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
