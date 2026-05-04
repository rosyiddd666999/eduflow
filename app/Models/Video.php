<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'type',
        'file_path',
        'url',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    protected static function booted()
    {
        static::saving(function ($video) {
            if ($video->type === 'upload' && $video->isDirty('file_path')) {
                // Kita ambil nama filenya saja (menghapus prefix 'videos/')
                $fileName = basename($video->file_path);

                // Isi kolom url secara otomatis
                $video->url = rtrim(env('CPANEL_VIDEO_BASE_URL'), '/') . '/' . $fileName;
            }
        });
    }
}
