<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ParseRssPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:parse-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Парсит RSS и сохраняет посты в базу данных';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // URL RSS канала
        $rssUrl = 'https://another-it.ru/feed/';

        try {
            // Получаем данные RSS
            $response = Http::get($rssUrl);
            Log::info('Ответ от RSS: ' . $response->body());

            // Проверяем успешность запроса
            if ($response->failed()) {
                throw new \Exception('Не удалось получить данные из RSS.');
            }

            // Парсим XML
            $xml = simplexml_load_string($response->body());

            // Проверяем наличие постов
            if (isset($xml->channel->item)) {
                foreach ($xml->channel->item as $item) {
                    // Извлекаем нужные данные из каждого поста
                    $title = (string)$item->title;
                    $link = (string)$item->link;
                    $description = (string)$item->description;
                    $pubDate = (string)$item->pubDate;

                    // Преобразуем дату публикации в формат, который будет удобен для базы данных
                    $publishedAt = \Carbon\Carbon::parse($pubDate);

                    // Проверим, есть ли категория в базе (например, категория "Новости")
                    $category = Category::firstOrCreate([
                        'name' => 'Новости', // Или другая логика для определения категории
                    ]);

                    // Сохраняем пост в базу
                    Post::create([
                        'title' => $title,
                        'text' => $description,
                        'category_id' => $category->id,
                        'image' => null, // Если нужно, можешь добавить логику для парсинга изображения
                    ]);

                    $this->info("Пост '{$title}' был успешно добавлен.");
                }
            } else {
                throw new \Exception('Нет постов в RSS.');
            }
        } catch (\Exception $e) {
            // Логируем ошибку и выводим в консоль
            Log::error('Ошибка при парсинге RSS: ' . $e->getMessage());
            $this->error('Ошибка: ' . $e->getMessage());
        }
    }
}
