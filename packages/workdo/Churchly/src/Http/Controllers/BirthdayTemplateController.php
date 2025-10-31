<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Workdo\Churchly\Entities\BirthdayTemplate;

class BirthdayTemplateController extends Controller
{
    public function index()
    {
        // only fetch user + workspace templates
        $templates = BirthdayTemplate::where('created_by', creatorId())
            ->where('workspace', getActiveWorkSpace())
            ->latest()
            ->get();

        return view('churchly::birthday_templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $path = $request->file('file')->store('birthday_templates', 'public');

        $template = new BirthdayTemplate();
        $template->name       = $request->name;
        $template->file_path  = $path;
        $template->workspace  = getActiveWorkSpace();
        $template->created_by = creatorId();
        $template->is_active  = false;
        $template->save();

        return redirect()->route('birthday_templates.index')
            ->with('success', __('Template uploaded successfully.'));
    }

    public function activate($id)
    {
        // deactivate old active
        BirthdayTemplate::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->update(['is_active' => false]);

        // activate chosen
        $template = BirthdayTemplate::findOrFail($id);
        $template->is_active = true;
        $template->save();

        return redirect()->route('birthday_templates.index')
            ->with('success', __('Template activated successfully.'));
    }


    public function edit($id)
    {
        $template = BirthdayTemplate::findOrFail($id);
        return view('churchly::birthday_templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = BirthdayTemplate::findOrFail($id);

        $template->update($request->only([
            'photo_x', 'photo_y', 'photo_width', 'photo_height',
            'name_x', 'name_y', 'name_font_size',
            'slogan_x', 'slogan_y', 'slogan_font_size',
        ]));

        return redirect()->route('birthday_templates.index')->with('success', 'Template positions updated successfully.');
    }

}
