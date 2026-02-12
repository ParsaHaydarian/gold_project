<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Story extends Model
{
    protected $fillable = [
        'type',
        'title',
        'link',
        'image_1',
        'image_2',
        'video',
    ];

    /**
     * Get the full URL for the profile image.
     */
    public function getImage1UrlAttribute()
    {
        return $this->image_1 ? Storage::url($this->image_1) : null;
    }

    /**
     * Get the full URL for the story image.
     */
    public function getImage2UrlAttribute()
    {
        return $this->image_2 ? Storage::url($this->image_2) : null;
    }

    /**
     * Get the full URL for the video.
     */
    public function getVideoUrlAttribute()
    {
        return $this->video ? Storage::url($this->video) : null;
    }
}
