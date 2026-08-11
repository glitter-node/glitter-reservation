<?php

namespace Modules\Glitter\Reservation\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FrontendI18nContractTest extends TestCase
{
    private const MODULE_IDENTIFIER = 'glitter-reservation';

    #[DataProvider('localeProvider')]
    public function test_every_layout_translation_key_resolves_from_the_module_dictionary(string $locale): void
    {
        $moduleRoot = dirname(__DIR__, 2);
        $dictionary = [
            self::MODULE_IDENTIFIER => $this->decodeJson("{$moduleRoot}/resources/lang/{$locale}.json"),
        ];
        $keys = $this->extractLayoutTranslationKeys("{$moduleRoot}/resources/layouts");

        self::assertNotEmpty($keys);

        foreach ($keys as $key) {
            $resolved = $this->resolveNestedValue($dictionary, $key);

            self::assertIsString($resolved, "Unresolved {$locale} frontend translation key: {$key}");
            self::assertNotSame($key, $resolved, "Translation key fell back to itself: {$key}");
        }
    }

    public static function localeProvider(): array
    {
        return [['ko'], ['en']];
    }

    private function extractLayoutTranslationKeys(string $layoutDirectory): array
    {
        $keys = [];
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($layoutDirectory));

        foreach ($files as $file) {
            if (! $file->isFile() || $file->getExtension() !== 'json') {
                continue;
            }

            $content = file_get_contents($file->getPathname());
            preg_match_all('/\\$t:([A-Za-z0-9_.-]+)/', $content, $matches);
            array_push($keys, ...$matches[1]);
        }

        return array_values(array_unique($keys));
    }

    private function decodeJson(string $path): array
    {
        return json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    }

    private function resolveNestedValue(array $dictionary, string $key): mixed
    {
        $value = $dictionary;

        foreach (explode('.', $key) as $segment) {
            if (! is_array($value) || ! array_key_exists($segment, $value)) {
                return null;
            }

            $value = $value[$segment];
        }

        return $value;
    }
}
