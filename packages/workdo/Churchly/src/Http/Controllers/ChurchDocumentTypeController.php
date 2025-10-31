<?php

namespace App\Http\Controllers;


use Workdo\Churchly\Entities\ChurchDocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChurchDocumentTypeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ChurchDocumentType::class);
        $documents = ChurchDocumentType::where('workspace', getActiveWorkSpace())
            ->where('created_by', creatorId())
            ->get();

        return view('church_document_types.index', compact('documents'));
    }

    public function create()
    {
        $this->authorize('create', ChurchDocumentType::class);
        return view('church_document_types.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', ChurchDocumentType::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'is_required' => 'required|boolean',
        ]);

        ChurchDocumentType::create([
            'name' => $request->name,
            'is_required' => $request->is_required,
            'workspace' => getActiveWorkSpace(),
            'created_by' => creatorId(),
        ]);

        return redirect()->route('church_document_types.index')->with('success', __('Document type created successfully.'));
    }

    public function edit(ChurchDocumentType $churchDocumentType)
    {
        $this->authorize('update', $churchDocumentType);

        return view('church_document_types.edit', compact('churchDocumentType'));
    }

    public function update(Request $request, ChurchDocumentType $churchDocumentType)
    {
        $this->authorize('update', $churchDocumentType);

        $request->validate([
            'name' => 'required|string|max:255',
            'is_required' => 'required|boolean',
        ]);

        $churchDocumentType->update([
            'name' => $request->name,
            'is_required' => $request->is_required,
        ]);

        return redirect()->route('church_document_types.index')->with('success', __('Document type updated successfully.'));
    }

    public function destroy(ChurchDocumentType $churchDocumentType)
    {
        $this->authorize('delete', $churchDocumentType);
        $churchDocumentType->delete();

        return redirect()->route('church_document_types.index')->with('success', __('Document type deleted successfully.'));
    }
}
