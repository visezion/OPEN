<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Workdo\Churchly\Entities\BirthdayTemplate;
use Workdo\Churchly\Entities\ChurchMember;

class BirthdayCardController extends Controller
{
    public function generate(int $memberId, ?int $templateId = null)
    {
        // ✅ Find member
        $member = ChurchMember::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->find($memberId);

        if (!$member) {
            return redirect()->back()->with('error', __('Member not found.'));
        }

        // ✅ Load template
        $template = BirthdayTemplate::when($templateId, fn($q) => $q->where('id', $templateId))
            ->where('is_active', true)
            ->where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->first();

        if (!$template) {
            return redirect()->back()->with('error', __('Birthday template not found.'));
        }

        // ✅ Load template background
        $templatePath = Storage::disk('public')->path($template->file_path);
        $ext = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));

        if ($ext === 'jpg' || $ext === 'jpeg') {
            $bg = @imagecreatefromjpeg($templatePath);
        } elseif ($ext === 'png') {
            $bg = @imagecreatefrompng($templatePath);
            imagealphablending($bg, true);
            imagesavealpha($bg, true);
        } else {
            return redirect()->back()->with('error', __('Unsupported template format.'));
        }

        if (!$bg) {
            return redirect()->back()->with('error', __('Unable to load template image.'));
        }

        // ✅ Profile photo (priority: member → request → fallback avatar)
        if (!empty($member->profile_photo) && Storage::disk('public')->exists($member->profile_photo)) {
            $profilePath = Storage::disk('public')->path($member->profile_photo);
        } elseif ($photoPath = request()->get('photo')) {
            $profilePath = Storage::disk('public')->exists($photoPath)
                ? Storage::disk('public')->path($photoPath)
                : public_path('images/avatar-sample.png');
        } else {
            $profilePath = public_path('images/avatar-sample.png');
        }

        if (!file_exists($profilePath)) {
            // fallback if file is missing
            $profilePath = __DIR__ . '/../../../resources/default-avatar.png';
        }

        $profileExt = strtolower(pathinfo($profilePath, PATHINFO_EXTENSION));
        $profile = ($profileExt === 'png')
            ? @imagecreatefrompng($profilePath)
            : @imagecreatefromjpeg($profilePath);

        if (!$profile) {
            return redirect()->back()->with('error', __('Unable to load profile photo.'));
        }

        // ✅ Resize profile
        $resizedProfile = imagecreatetruecolor($template->photo_width, $template->photo_height);
        imagealphablending($resizedProfile, false);
        imagesavealpha($resizedProfile, true);

        imagecopyresampled(
            $resizedProfile,
            $profile,
            0,
            0,
            0,
            0,
            $template->photo_width,
            $template->photo_height,
            imagesx($profile),
            imagesy($profile)
        );

        // ✅ Insert profile
        imagecopy(
            $bg,
            $resizedProfile,
            $template->photo_x,
            $template->photo_y,
            0,
            0,
            $template->photo_width,
            $template->photo_height
        );

        // ✅ Text colors
        [$r, $g, $b] = $this->hexToRgb($template->name_font_color ?? '#000000');
        $nameColor = imagecolorallocate($bg, $r, $g, $b);

        [$r2, $g2, $b2] = $this->hexToRgb($template->slogan_font_color ?? '#444444');
        $sloganColor = imagecolorallocate($bg, $r2, $g2, $b2);

        // ✅ Fonts (fallback to system Arial if Poppins is missing)
        $fontBold = public_path('fonts/Poppins-Bold.ttf');
        $fontRegular = public_path('fonts/Poppins-Regular.ttf');
        $systemFont = 'C:/Windows/Fonts/arial.ttf'; // Windows fallback

        $displayName = 'Min. ' . strtoupper($member->name);

        // ✅ Name
        if (file_exists($fontBold)) {
            imagettftext(
                $bg,
                $template->name_font_size ?? 42,
                0,
                $template->name_x,
                $template->name_y,
                $nameColor,
                $fontBold,
                $displayName
            );
        } elseif (file_exists($systemFont)) {
            imagettftext(
                $bg,
                $template->name_font_size ?? 42,
                0,
                $template->name_x,
                $template->name_y,
                $nameColor,
                $systemFont,
                $displayName
            );
        } else {
            imagestring($bg, 5, $template->name_x, $template->name_y, $displayName, $nameColor);
        }

        // ✅ Slogan
        $slogan = 'THIS IS YOUR YEAR OF TOTAL RECOVERY, REALIGNMENT AND REASSURANCE';
        if (file_exists($fontRegular)) {
            imagettftext(
                $bg,
                $template->slogan_font_size ?? 20,
                0,
                $template->slogan_x,
                $template->slogan_y,
                $sloganColor,
                $fontRegular,
                $slogan
            );
        } elseif (file_exists($systemFont)) {
            imagettftext(
                $bg,
                $template->slogan_font_size ?? 20,
                0,
                $template->slogan_x,
                $template->slogan_y,
                $sloganColor,
                $systemFont,
                $slogan
            );
        }

        // ✅ Output response
        ob_start();
        imagepng($bg);
        $imageData = ob_get_clean();

        imagedestroy($bg);
        imagedestroy($resizedProfile);
        imagedestroy($profile);

        return Response::make($imageData, 200, ['Content-Type' => 'image/png']);
    }

    private function hexToRgb($hex): array
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) === 3) {
            return [
                hexdec(str_repeat($hex[0], 2)),
                hexdec(str_repeat($hex[1], 2)),
                hexdec(str_repeat($hex[2], 2)),
            ];
        }

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}
