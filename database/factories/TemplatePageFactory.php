<?php

namespace Database\Factories;

use App\Models\Template;
use App\Models\TemplatePage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TemplatePageFactory extends Factory
{
    protected $model = TemplatePage::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        $template = Template::factory()->create();
        
        return [
            'template_id' => $template->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(3, true),
            'data' => $this->generateSampleData($template),
            'is_published' => $this->faker->boolean(70),
            'published_at' => $this->faker->optional(0.7)->dateTimeThisMonth(),
        ];
    }

    protected function generateSampleData(Template $template): array
    {
        $data = [];
        
        foreach ($template->fields as $field) {
            $value = match($field['type']) {
                'text' => $this->faker->sentence,
                'textarea' => $this->faker->paragraph,
                'rich-text' => $this->faker->paragraphs(2, true),
                'image' => $this->faker->imageUrl(),
                'file' => $this->faker->filePath(),
                'select' => $this->faker->randomElement(explode(',', $field['options'] ?? '')),
                'checkbox' => $this->faker->boolean,
                'radio' => $this->faker->randomElement(explode(',', $field['options'] ?? '')),
                'date' => $this->faker->date(),
                'datetime' => $this->faker->dateTime(),
                'number' => $this->faker->numberBetween(1, 1000),
                'email' => $this->faker->email,
                'url' => $this->faker->url,
                'color' => $this->faker->hexColor,
                'time' => $this->faker->time,
                default => null,
            };

            // Ensure the value is not an array unless it's specifically meant to be
            if (is_array($value) && !in_array($field['type'], ['rich-text'])) {
                $value = implode(', ', $value);
            }

            $data[$field['name']] = $value;
        }
        
        return $data;
    }
} 