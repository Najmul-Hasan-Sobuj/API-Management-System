<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\TemplatePage;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Create predefined templates
        $templates = [
            [
                'name' => 'Blog Post',
                'slug' => 'blog-post',
                'description' => 'Template for blog posts with featured image and categories',
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => 'Title',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'name' => 'excerpt',
                        'label' => 'Excerpt',
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
                        'required' => true,
                    ],
                    [
                        'name' => 'category',
                        'label' => 'Category',
                        'type' => 'select',
                        'options' => 'Technology,Design,Business,Marketing',
                        'required' => true,
                    ],
                    [
                        'name' => 'tags',
                        'label' => 'Tags',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
            ],
            [
                'name' => 'Product',
                'slug' => 'product',
                'description' => 'Template for product listings with pricing and specifications',
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => 'Product Name',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => 'Description',
                        'type' => 'rich-text',
                        'required' => true,
                    ],
                    [
                        'name' => 'price',
                        'label' => 'Price',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'name' => 'images',
                        'label' => 'Product Images',
                        'type' => 'image',
                        'required' => true,
                    ],
                    [
                        'name' => 'specifications',
                        'label' => 'Specifications',
                        'type' => 'textarea',
                        'required' => true,
                    ],
                    [
                        'name' => 'category',
                        'label' => 'Category',
                        'type' => 'select',
                        'options' => 'Electronics,Clothing,Home,Books',
                        'required' => true,
                    ],
                ],
            ],
        ];

        foreach ($templates as $templateData) {
            $template = Template::create($templateData);
            
            // Create sample pages for each template
            TemplatePage::factory()
                ->count(5)
                ->create(['template_id' => $template->id]);
        }
    }
} 