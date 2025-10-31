<?php

namespace Workdo\Churchly\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

// ✅ Correct imports for BaconQrCode v3.0.0
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\GdImageBackEnd; // Works perfectly on XAMPP

class ChurchMember extends Model
{
    use HasFactory;

    protected $table = 'church_members';

    protected $fillable = [
        'user_id',
        'name',
        'profile_photo',
        'dob',
        'gender',
        'phone',
        'address',
        'email',
        'password',
        'member_id',
        'branch_id',
        'role_id',
        'church_doj',
        'documents',
        'membership_status',
        'family_id',
        'spouse_id',
        'emergency_contact',
        'emergency_phone',
        'is_active',
        'workspace',
        'created_by',
        'qr_code', // ✅ added for saving the QR file path
    ];

    protected $casts = [
        'dob' => 'date',
        'church_doj' => 'date',
        'is_active' => 'boolean',
    ];

    protected $hidden = ['password'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(ChurchBranch::class, 'branch_id');
    }

    public function departments()
    {
        return $this->belongsToMany(
            ChurchDepartment::class,
            'church_member_department',
            'church_member_id',
            'department_id'
        )->withPivot('designation_id')->withTimestamps();
    }

    public function customValues()
    {
        return $this->hasMany(ChurchMemberCustomValue::class, 'member_id');
    }

    public function designation()
    {
        return $this->belongsTo(ChurchDesignation::class, 'designation_id');
    }

    public function family()
    {
        return $this->belongsTo(ChurchMember::class, 'family_id');
    }

    public function spouse()
    {
        return $this->belongsTo(ChurchMember::class, 'spouse_id');
    }

    public function activities()
    {
        return $this->hasMany(ChurchActivityLog::class, 'member_id');
    }

    public function progress()
    {
        return $this->hasMany(DiscipleshipMemberProgress::class, 'member_id');
    }

    public function discipleshipReviews()
    {
        return $this->hasMany(DiscipleshipMemberProgress::class, 'reviewed_by');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'member_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    public function getFormattedMemberIdAttribute()
    {
        $company_settings = getCompanyAllSetting();
        $member_prefix = $company_settings['member_prefix'] ?? '#MBR';
        return $member_prefix . sprintf("%05d", $this->id);
    }

    public function getFormattedDobAttribute()
    {
        return $this->dob ? $this->dob->format('d M Y') : '-';
    }

    public function getFormattedChurchDojAttribute()
    {
        return $this->church_doj ? $this->church_doj->format('d M Y') : '-';
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeInWorkspace($query)
    {
        // ✅ Alias for consistency across all models
        return $this->scopeForWorkspace($query);
    }
    
    
    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where('workspace', $workspaceId);
    }

    public function scopeCreatedBy($query, $creatorId = null)
    {
        $creatorId = $creatorId ?? creatorId();
        return $query->where('created_by', $creatorId);
    }

    /*
    |--------------------------------------------------------------------------
    | Utilities
    |--------------------------------------------------------------------------
    */
    public static function generateMemberId()
    {
        $date = now()->format('Ymd');
        $countToday = self::whereDate('created_at', today())->count() + 1;
        return 'MBR-' . $date . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
    }


    /*
    |--------------------------------------------------------------------------
    | QR Code Generator (BaconQrCode v3.0, PHP 8.2 Compatible)
    |--------------------------------------------------------------------------
    */
    public function generateQrCode()
{
    // Ensure storage path exists
    if (!Storage::disk('public')->exists('qr_codes')) {
        Storage::disk('public')->makeDirectory('qr_codes');
    }

    $writer = new \BaconQrCode\Writer(
        new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(300),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        )
    );

    $payload = json_encode([
        'member_id'   => $this->id,
        'workspace'   => $this->workspace,
        'unique_code' => sha1($this->id . $this->email . now()),
    ]);

    $fileName = "member_{$this->id}.svg";
    $path = "qr_codes/{$fileName}";

    Storage::disk('public')->put($path, $writer->writeString($payload));

    if (Schema::hasColumn($this->getTable(), 'qr_code')) {
        $this->qr_code = $path;
        $this->save();
    }

    return $path;
}



    /*
    |--------------------------------------------------------------------------
    | Accessor: Public QR Code URL
    |--------------------------------------------------------------------------
    */
    public function getQrCodeUrlAttribute()
    {
        return $this->qr_code ? asset('storage/' . $this->qr_code) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events (Auto-generate QR)
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::created(function ($member) {
            $member->generateQrCode();
        });
    }
}
