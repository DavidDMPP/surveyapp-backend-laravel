<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return response()->json($surveys);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $photoPath = $request->file('photo')->store('survey_photos', 'public');

        $survey = Survey::create([
            'user_id' => $request->user()->id,
            'name' => $validatedData['name'],
            'photo' => $photoPath,
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        return response()->json($survey, 201);
    }

    public function show(Survey $survey)
    {
        return response()->json($survey);
    }

    public function update(Request $request, Survey $survey)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('survey_photos', 'public');
            $survey->photo = $photoPath;
        }

        $survey->update($validatedData);

        return response()->json($survey);
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return response()->json(null, 204);
    }
}