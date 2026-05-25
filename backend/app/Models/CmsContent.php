<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsContent extends Model
{
    protected $fillable = ['section', 'content'];

    /**
     * Get content for a given section, falling back to a default if not in DB.
     */
    public static function getSection(string $section): ?self
    {
        return static::where('section', $section)->first();
    }
}
