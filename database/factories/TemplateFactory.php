<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TemplateFactory extends Factory
{
    protected $model = Template::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph,
            'fields' => $this->getSampleFields(),
            'is_active' => true,
        ];
    }

    protected function getSampleFields(): array
    {
        return [
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'required' => true,
            ],
            [
                'name' => 'content',
                'label' => 'Content',
                'type' => 'rich-text',
                'required' => true,
            ],
            [
                'name' => 'featured_image',
                'label' => 'Featured Image',
                'type' => 'image',
                'required' => false,
            ],
            [
                'name' => 'category',
                'label' => 'Category',
                'type' => 'select',
                'options' => 'General,News,Events,Products',
                'required' => true,
            ],
            [
                'name' => 'publish_date',
                'label' => 'Publish Date',
                'type' => 'date',
                'required' => true,
            ],
        ];
    }
} 