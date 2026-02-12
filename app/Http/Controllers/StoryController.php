<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoryFormResource;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function get(int $id = null){
        if($id === null){
            $story = Story::all();
            return StoryFormResource::collection($story);

        }else{
            $story = Story::query()->findOrFail($id);
            return new StoryFormResource($story);
        }
    }
    public function store(Request $request)
    {
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

        $story = Story::query()->create($validatedData);

        return response()->json([
            'message' => 'استوری با موفقیت ذخیره شد',
            'data'    => $story
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'type'    => ['nullable','in:image,video'],
            'title'   => ['nullable','string','max:255'],
            'link'    => ['nullable','url'],

            'image_1' => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
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

        $story = Story::query()->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Handle image_1 (Profile Image)
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image_1')) {
            if ($story->image_1) {
                Storage::disk('public')->delete($story->image_1);
            }

            $validatedData['image_1'] =
                $request->file('image_1')->store('stories/profiles', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Handle Type = Image
        |--------------------------------------------------------------------------
        */
        if ($request->type === 'image') {

            // Delete old video if switching from video
            if ($story->video) {
                Storage::disk('public')->delete($story->video);
                $validatedData['video'] = null;
            }

            if ($request->hasFile('image_2')) {

                if ($story->image_2) {
                    Storage::disk('public')->delete($story->image_2);
                }

                $validatedData['image_2'] =
                    $request->file('image_2')->store('stories/content', 'public');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Handle Type = Video
        |--------------------------------------------------------------------------
        */
        if ($request->type === 'video') {

            // Delete old image_2 if switching from image
            if ($story->image_2) {
                Storage::disk('public')->delete($story->image_2);
                $validatedData['image_2'] = null;
            }

            if ($request->hasFile('video')) {
                if ($story->video) {
                    Storage::disk('public')->delete($story->video);
                }
                $validatedData['video'] =
                    $request->file('video')->store('stories/videos', 'public');
            }
        }


        $story->update($validatedData);
        $story->save();

        return response()->json([
            'message' => 'استوری با موفقیت بروزرسانی شد',
            'data'    => $story
        ], 200);
    }


    public function destroy(Request $request)
    {
        $story = Story::query()->findOrFail($request->id);

        if ($story->image_1) {
            Storage::disk('public')->delete($story->image_1);
        }

        if ($story->image_2) {
            Storage::disk('public')->delete($story->image_2);
        }

        if ($story->video) {
            Storage::disk('public')->delete($story->video);
        }

        $story->delete();

        return response()->json([
            'message' => "استوری با موفقیت حذف شد",
        ]);
    }
}
