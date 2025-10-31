<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\Churchly\Entities\ChurchMemberField;

class FormSetupController extends Controller
{
    public function index()
    {
        $fields = ChurchMemberField::where('workspace', getActiveWorkSpace())
            ->orderBy('order', 'asc') // ✅ order respected
            ->get();

        return view('churchly::members.setup.formsetup', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_key'   => 'required|string|max:255|unique:church_member_custom_fields,field_key',
            'field_label' => 'required|string|max:255',
            'field_type'  => 'required|string|in:text,textarea,date,drupdown,file,checkbox',
            'field_value' => 'nullable|string',
            'order'       => 'nullable|integer',
        ]);

        ChurchMemberField::create([
            'field_key'   => $request->field_key,
            'field_label' => $request->field_label,
            'field_type'  => $request->field_type,
            'field_value' => $request->field_value,
            'order'       => $request->order ?? 0,
            'workspace'   => getActiveWorkSpace(),
            'created_by'  => creatorId(),
        ]);

        return back()->with('success', 'Custom field added successfully!');
    }

    public function edit($id)
    {
        $field = ChurchMemberField::findOrFail($id);
        return view('churchly::members.setup.editfield', compact('field'));
    }

    public function update(Request $request, $id)
    {
        $field = ChurchMemberField::findOrFail($id);

        $request->validate([
            'field_key'   => 'required|string|max:255|unique:church_member_custom_fields,field_key,' . $id,
            'field_label' => 'required|string|max:255',
            'field_type'  => 'required|string|in:text,textarea,date,drupdown,file,checkbox',
            'field_value' => 'nullable|string',
            'order'       => 'nullable|integer',
        ]);

        $field->update([
            'field_key'   => $request->field_key,
            'field_label' => $request->field_label,
            'field_type'  => $request->field_type,
            'field_value' => $request->field_value,
            'order'       => $request->order ?? 0,
        ]);

        return redirect()->route('formsetup.index')->with('success', 'Custom field updated!');
    }

    public function destroy($id)
    {
        ChurchMemberField::findOrFail($id)->delete();
        return back()->with('success', 'Custom field deleted successfully!');
    }
}
