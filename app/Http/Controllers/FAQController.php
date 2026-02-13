<?php

namespace App\Http\Controllers;

use App\Http\Resources\FAQCollection;
use App\Http\Resources\FAQResource;
use Illuminate\Http\Request;
use App\Models\FAQ;
class FAQController extends Controller
{
    public function get(Request $request){
        $response = FAQ::query()
            ->orderBy('order')
            ->paginate(5);
        return new FAQResource($response);
    }
    public function store(Request $request){
        $validated = $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order' => ['nullable','integer','min:1'],
        ]);

        $validated['show'] = substr($validated['answer'] , 0 , 10);

        if(!isset($validated['order'])){
            $validated['order'] = FAQ::query()->max('order') + 1;
        }

        //Making space for new FAQ
        FAQ::query()
            ->where('order' , '>=' , $validated['order'])
            ->increment('order');

        FAQ::query()->create($validated);

        return response()->json([
            "message" => "با موفقیت اضافه شد",
        ]);
    }
    public function update(Request $request, FAQ $faq)
    {
        $validated = $request->validate([
            'question' => 'required',
            'answer'   => 'required',
            'order'    => ['required', 'integer', 'min:1'],
        ]);

        $validated['show'] = mb_substr($validated['answer'], 0, 10);

        $newOrder = $validated['order'] ?? $faq->order;
        $oldOrder = $faq->order;

        if ($newOrder != $oldOrder) {
            if ($newOrder > $oldOrder) {
                FAQ::query()
                    ->where('order', '>', $oldOrder)
                    ->where('order', '<=', $newOrder)
                    ->decrement('order');
            } else {
                FAQ::query()
                    ->where('order', '>=', $newOrder)
                    ->where('order', '<', $oldOrder)
                    ->increment('order');
            }
        }
        $faq->update($validated);
        return response()->json([
            "message" => "با موفقیت ویرایش شد",
        ]);
    }
    public function delete(Request $request , int $id){
        FAQ::query()->findOrFail($id)->delete();

        return response()->json([
            'message' => "حذف شد"
        ]);
    }
}
