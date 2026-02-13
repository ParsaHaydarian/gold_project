<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FAQResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pagination' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'limit' => $this->perPage(),
                'total' => $this->total(),
                'total_page' => $this->lastPage(),
            ],

            'data' => $this->all(),

            'tableHeader' => [
                'title' => 'لیست سوالات',
                'items' => [
                    [
                        'type' => 'custom',
                        'title' => 'افزودن',
                        'key' => 'add',
                    ],
                ],
            ],

            'tableHeadCells' => [
                'question' => 'پرسش',
                'show' => 'پاسخ',
                'edit' => 'ویرایش',
                'delete' => 'حذف',
            ],
        ];
    }
}
