<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\User;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all notes from the database
        $notes = Note::all();

        // Return the notes as a JSON response
        return response()->json($notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Create a new Note record with the validated data
        Note::create($validatedData);

        // Return a JSON response indicating success
        return response()->json([
            'status' => true,
            'message' => "Note taking Success"
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
    
        try {
            // Find the note by id
            $note = Note::findOrFail($id);
    
            // Update the note's attributes with the validated request data
            $note->update($validatedData);
    
            // Return a response with the updated note
            return response()->json([
                'message' => 'Note updated successfully!',
                'note' => $note
            ], 200);
        } catch (\Exception $e) {
            // Return an error response if the update fails
            return response()->json([
                'message' => 'Failed to update note. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Assuming you have a model called 'Note' and you use dependency injection
        $note = Note::findOrFail($id);
        $note->delete();

        // Return a response, could be a JSON response or just a success message
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}
