<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = Project::select('projects.*')
                ->orderBy('order', 'desc');

            if ($request->get('trashed')) {
                $projects->onlyTrashed();
            }

            $startDate = $request->get('start_date') ?? $request->get('end_date');
            $endDate = $request->get('end_date') ?? $request->get('start_date');

            if ($startDate && $endDate) {
                $projects->createdBetween($startDate, $endDate);
            }

            $datatable = datatables()->eloquent($projects);

            $datatable->editColumn('order', function ($project) {
                return view('backend.projects.table.table-order', compact('project'));
            });

            $datatable->addColumn('actions', function ($project) {
                return view('backend.projects.table.table-actions', compact('project'));
            });

            return $datatable->make(true);
        }

        return view('backend.projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects'],
            'url' => ['required', 'url', 'max:255'],
            'image' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'short_description' => ['required'],
            'description' => ['required']
        ]);

        $data['slug'] = Str::slug($request->get('slug'));

        $project = Project::create(collect($data)->except('image')->toArray());

        $project->update([
            'order' => $project->id
        ]);

        if ($request->hasFile('image')) {
            $imagePath = public_path(Project::IMAGE_PATH);

            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0777, true);
            }

            $basename = $project->id . '.' . $request->image->extension();
            $request->image->move($imagePath, $basename);

            $project->update([
                'image' => $basename
            ]);
        }

        return redirect()->route('backend.projects.index')
            ->withSuccess(__('Project added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('backend.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,' . $project->id . ',id'],
            'url' => ['required', 'url', 'max:255'],
            'image' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'short_description' => ['required'],
            'description' => ['required']
        ]);

        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('image')) {
            $imagePath = public_path(Project::IMAGE_PATH);

            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0777, true);
            }

            $data['image'] = $project->id . '.' . $request->image->extension();
            $request->image->move($imagePath, $data['image']);
        } else {
            unset($data['image']);
        }

        $project->update($data);

        return redirect()->route('backend.projects.index')
            ->withSuccess(__('Project updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        return $project->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function restore(Project $project)
    {
        return $project->restore();
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Project $project)
    {
        File::delete(public_path($project->imagePath));

        return $project->forceDelete();
    }

    /**
     * Reorder the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {
        $data = $request->all();

        $projects = Project::find(array_keys($data))->pluck('order', 'id');

        if (count($projects)) {
            foreach ($data as $key => $id) {
                Project::find($id)->update([
                    'order' => $projects[$key]
                ]);
            }
        }
    }
}
