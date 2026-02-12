<?php

namespace App\libs;

use Illuminate\Http\Request;

class validate {
    public function user(Request $request){
        return $request->validate([
            'name' => ['required' , 'string' , 'max:255' , 'min:3' , 'unique:users'],
            'email' => ['required' , 'email' , 'unique:users'],
            'password' => ['required' , 'min:8' , 'confirmed' , 'alpha_num'],
        ]);
        return $validatedData;
    }
    public function admin(Request $request){
        return $request->validate([
            'name' => ['required' , 'string' , 'max:255' , 'min:3' , 'unique:admins'],
            'email' => ['required' , 'email' , 'unique:admins'],
            'password' => ['required' , 'min:8' , 'confirmed' , 'alpha_num'],
        ]);
    }
    public function prodcuts(Request $request){
        return $request->validate([
            'name' => ['required' , 'string' , 'max:255' , 'min:3' , 'unique:products'],
            'price' => ['required' , 'numeric' , 'min:1'],
            'quantity' => ['required' , 'numeric' , 'min:1'],
            'description' => ['required' , 'string' , 'max:255'],
            'image' => ['required' , 'image' , 'mimes:jpeg,png,jpg,gif,svg'],
        ]);
    }
    public function article(Request $request){
         return $request->validate([
            'title' => ['required' , 'string' , 'max:255' , 'min:3' , 'unique:articles'],
            'category_id' => ['required' , 'string'],
            'date' => ['required' , 'string'],
            'main_image' => ['required' , 'image' , 'mimes:jpeg,png,jpg,gif,svg' , 'max:2048'],
            'video' => ['sometimes' , 'file' , 'mimetypes:video/avi,video/mpeg' , 'max:5000'],
            'alt' => ['required' , 'string' , 'max:255'],
            'keyword' => ['required' , 'string' , 'max:255'],
            'meta_title' => ['required' , 'string' , 'max:255'],
            'tag_title' => ['required' , 'string' , 'max:255'],
            'meta_description' => ['required' , 'string' , 'max:255'],
            'page_url' => ['required' , 'string' , 'max:255'],
        ]);
    }
    public function story(Request $request){
        return $request->validate([
           ''
        ]);
    }
}
