<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fields' => [
                [
                    'fieldType' => 'select',
                    'name' => 'type',
                    'label' => 'نوع',
                    'value' => $this->type,
                    'options' => [
                        ['title' => 'عکس', 'value' => 'image'],
                        ['title' => 'ویدیو', 'value' => 'video'],
                    ],
                ],
                [
                    'fieldType' => 'input',
                    'name' => 'title',
                    'label' => 'عنوان',
                    'value' => $this->title,
                ],
                [
                    'fieldType' => 'input',
                    'name' => 'link',
                    'label' => 'لینک استوری',
                    'value' => $this->link,
                ],
                [
                    'fieldType' => 'draggable',
                    'name' => 'image_1',
                    'label' => 'عکس پروفایل',
                    'maxSize' => 2,
                    'value' => $this->image_1,
                ],
                [
                    'fieldType' => 'draggable',
                    'name' => 'image_2',
                    'label' => 'عکس استوری',
                    'maxSize' => 2,
                    'value' => $this->image_2,
                ],
                [
                    'fileType' => 'video',
                    'fieldType' => 'draggable',
                    'name' => 'video',
                    'label' => 'ویدیو',
                    'maxSize' => 2,
                    'value' => $this->video,
                ],
            ],
        ];
    }
}
