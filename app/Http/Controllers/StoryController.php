<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function get(Request $request){
        $fields = [
                'fields' => [
                    ['fieldType' => 'select',
                        'name' => 'type',
                        'label' => 'نوع',
                        'options' => [
                            ['title' => 'عکس', 'value' => 'image'],
                            ['title' => 'ویدیو', 'value' => 'video'],
                        ],
                    ],
                    [
                        'fieldType' => 'input',
                        'name' => 'title',
                        'label' => 'عنوان',
                    ],
                    [
                        'fieldType' => 'input',
                        'name' => 'link',
                        'label' => 'لینک استوری',
                    ],
                    [
                        'fieldType' => 'draggable',
                        'name' => 'image_1',
                        'label' => 'عکس پروفایل',
                        'maxSize' => 2,
                    ],
                    [
                        'fieldType' => 'draggable',
                        'name' => 'image_2',
                        'label' => 'عکس استوری',
                        'maxSize' => 2,
                    ],
                    [
                        'fileType' => 'video',
                        'fieldType' => 'draggable',
                        'name' => 'video',
                        'label' => 'ویدیو',
                        'maxSize' => 2,
                    ],
                ],
            ];

        return $fields;
    }

    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'type'    => ['required','in:image,video'],
            'title'   => ['required','string','max:255'],
            'link'    => ['nullable','url'],
            'image_1' => ['required','image','mimes:jpeg,png,jpg','max:2048'],

            'image_2' => ['required_if:type,image','nullable','image','mimes:jpeg,png,jpg','max:2048'],

            'video'   => ['required_if:type,video','nullable','file','mimes:mp4,mov,avi','max:5120'],
        ], [], [
            'type'    => 'نوع',
            'title'   => 'عنوان',
            'link'    => 'لینک استوری',
            'image_1' => 'عکس پروفایل',
            'image_2' => 'عکس استوری',
            'video'   => 'ویدیو',
        ]);

        if ($request->hasFile('image_1')) {
            $validatedData['image_1'] = $request->file('image_1')->store('stories/profiles', 'public');
        }

        if ($request->type === 'image') {
            if ($request->hasFile('image_2')) {
                $validatedData['image_2'] = $request->file('image_2')->store('stories/content', 'public');
            }
            $validatedData['video'] = null;
        }

        if ($request->type === 'video') {
            if ($request->hasFile('video')) {
                $validatedData['video'] = $request->file('video')->store('stories/videos', 'public');
            }
            $validatedData['image_2'] = null;
        }

        $story = Story::query()->createOrUpdate($validatedData);

        return response()->json([
            'message' => 'استوری با موفقیت ذخیره شد',
            'data'    => $story
        ], 201);
    }

    public function destroy(Request $request)
    {
        Story::query()->findOrFail($request->id)->delete();
        return response()->json([
            'message' => "استوری با موفقیت حذف شد",
        ]);
    }

}
