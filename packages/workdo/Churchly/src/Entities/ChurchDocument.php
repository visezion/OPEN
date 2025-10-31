<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchDocument extends Model
{
    protected $table = 'church_documents';

    protected $fillable = [
        'name',
        'role',
        'document',
        'description',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'workspace' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * Optional: Relationship to the user who created the document.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
