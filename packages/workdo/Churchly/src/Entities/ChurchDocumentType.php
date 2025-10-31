<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchDocumentType extends Model
{
    protected $table = 'church_document_type';

    protected $fillable = [
        'name',
        'is_required',
        'workspace',
        'created_by',
    ];

    /**
     * Scope to filter by active workspace automatically.
     */
    public function scopeInWorkspace($query)
    {
        return $query->where('workspace', getActiveWorkSpace());
    }

    /**
     * Get the creator user.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
