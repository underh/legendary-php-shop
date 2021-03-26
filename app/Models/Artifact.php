<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Artifact extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'attributes',
        'modifiers',
        'price',
        'image',
    ];

    protected $casts = [
        'attributes' => 'collection',
        'modifiers' => 'collection',
        'price' => 'float',
    ];

    public function getTitleAttribute($value)
    {
        return html_entity_decode($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = htmlentities($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = htmlentities($value);
    }

    public function getDescriptionAttribute($value)
    {
        return html_entity_decode($value);
    }

    public function getImageUrl()
    {
        return str_replace(
            'http://minio:9000',
            'http://127.0.0.1:10000',
            $this->getFirstMediaUrl()
        );
    }
}
