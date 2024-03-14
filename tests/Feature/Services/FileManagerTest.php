<?php

namespace Sdkconsultoria\WhatsappCloudApi\Tests\Feature\Services;

use Faker\Factory;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Sdkconsultoria\WhatsappCloudApi\Services\FileManager;

class FileManagerTest extends TestCase
{
    public function test_create_file(): string
    {
        $faker = Factory::create();
        $file_path = __DIR__.'/files/'.$faker->unique()->word();
        FileManager::create($file_path);
        $this->assertTrue(file_exists($file_path));

        return $file_path;
    }

    #[Depends('test_create_file')]
    public function test_append_to_file(string $file_path): array
    {
        $faker = Factory::create();
        $word = $faker->unique()->name();

        FileManager::append($file_path, $word);

        $file_content = file_get_contents($file_path);

        $this->assertStringContainsString($word, $file_content);

        return [
            'word' => $word,
            'file_path' => $file_path,
        ];
    }

    #[Depends('test_append_to_file')]
    public function test_writte_after_to_file(array $data): void
    {
        $faker = Factory::create();
        $new_word = $faker->unique()->name();

        FileManager::writteAfter($data['word'], $new_word, $data['file_path']);

        $file_content = file_get_contents($data['file_path']);

        // $this->assertStringNotContainsString($data['word'], $file_content);
        $this->assertStringContainsString($data['word'].$new_word, $file_content);
    }

    #[Depends('test_append_to_file')]
    public function test_replace_file(array $data): void
    {
        $faker = Factory::create();
        $new_word = $faker->unique()->name();

        FileManager::replace($data['word'], $new_word, $data['file_path']);

        $file_content = file_get_contents($data['file_path']);

        $this->assertStringNotContainsString($data['word'], $file_content);
        $this->assertStringContainsString($new_word, $file_content);
    }

    public function test_append_json_file(): void
    {
        $new_content = ['content' => 'new-content'];

        $file_path = $this->createJsonFile();
        FileManager::appendToJsonKey($file_path, $new_content, 'devDependencies');

        $new_json = $this->getJsonContent();
        $new_json['devDependencies'] = array_merge($new_json['devDependencies'], $new_content);

        $this->assertJsonStringEqualsJsonFile(
            $file_path,
            json_encode($new_json)
        );
    }

    protected function createJsonFile(): string
    {
        $faker = Factory::create();
        $file_path = __DIR__.'/files/'.$faker->unique()->word().'.json';
        FileManager::create($file_path);
        FileManager::writteJson($file_path, $this->getJsonContent());

        return $file_path;
    }

    protected function getJsonContent()
    {
        return [
            'scripts' => [
                'dev' => 'npm run development',
                'development' => 'mix',
                'watch' => 'mix watch',
            ],
            'devDependencies' => [
                'axios' => '^0.25',
                'laravel-mix' => '^6.0.6',
                'lodash' => '^4.17.19',
                'postcss' => '^8.1.14',
            ],
        ];
    }
}
