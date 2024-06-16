<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requirement;

class RequirementController extends Controller
{
    public function createRequirement(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'estimation' => 'nullable|numeric',
        ]);

        $requirement = Requirement::create($validatedData);

        return response()->json(['message' => 'Requerimiento creado exitosamente', 'requirement' => $requirement]);
    }
}
