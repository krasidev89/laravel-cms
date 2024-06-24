<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('order', 'desc')->get();

        return view('frontend.projects.index', compact('projects'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->first();

        if (empty($project)) {
            abort(404);
        }

        return view('frontend.projects.show', compact('project'));
    }
}
