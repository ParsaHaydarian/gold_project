<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FAQCollection extends ResourceCollection
{
    public $collects = FAQResource::class;

    public function toArray(Request $request): array
    {
        return [
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'limit' => $this->resource->perPage(),
                'total' => $this->resource->total(),
                'total_page' => $this->resource->lastPage(),
            ],

            'data' => $this->collection,

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
