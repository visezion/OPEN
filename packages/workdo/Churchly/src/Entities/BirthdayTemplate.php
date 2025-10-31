<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class BirthdayTemplate extends Model
{
    protected $fillable = [
        'name', 'file_path', 'is_active',
        'workspace', 'created_by',
        'photo_x', 'photo_y', 'photo_width', 'photo_height',
        'name_x', 'name_y', 'name_font_size', 'name_font_color',
        'slogan_x', 'slogan_y', 'slogan_font_size', 'slogan_font_color'
    ];
}
