<?php

namespace App\Services;

use App\Models\Project; // Import the ImageUploadTrait
use App\Traits\CrudTrait;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Models\ProjectTeacnolagy;

class ProjectService
{
    use CrudTrait, ImageUploadTrait;
    protected function getModel()
    {
        return new Project();
    }

    public function index()
    {
        $projects = $this->getModel()->with('projectTeacnologes')->get();

        // Iterate through projects to add image URLs to each project
        foreach ($projects as $project) {
            if ($project->images) {
                $images = json_decode($project->images, true);
                // Add the image URLs to the project's images array
                $project->images = collect($images)->map(function ($image) {
                    return asset('public/storage/' . $image);
                })->toArray();
            }
        }

        return response()->json($projects);
    }


    public function store(Request $request)
    {

        // Validate the request if needed
        $data = $request->all();

        // Check if multiple images were uploaded
        if ($request->hasFile('images')) {

            $images = [];

            foreach ($request->file('images') as $file) {
                // Upload each image using the uploadImage method from the ImageUploadTrait
                $imagePath = $this->uploadImage($file, 'project_images');
                // Add the image path to the images array
                $images[] = $imagePath;

            }
            // Convert the images array to a JSON string
            $data['images'] = json_encode($images);
        }

        // Create the project
        $project = $this->getModel()->create($data);

        if ($request->has('technologies')) {

            foreach ($request->technologies as $tech) {
                ProjectTeacnolagy::create([
                    'project_id' => $project->id,
                    'technology' => $tech,
                ]);
            }
        }
        return $project;
    }


    public function show($id)
    {
        $project = $this->read($id);

        if ($project->projectTeacnologes) {
            $project_technologies = $project->projectTeacnologes->map(function ($item) {
                return [
                    'id' => $item->id,
                    'project_id' => $item->project_id,
                    'technology' => $item->technology,
                ];
            });
        } else {
            $project_technologies = [];
        }

        if ($project->images) {
            $images = json_decode($project->images, true);
            // Add the image URLs to the project's images array
            $project->images = collect($images)->map(function ($image) {
                return asset('public/storage/' . $image);
            })->toArray();
        }

        $project->project_teacnologes = $project_technologies;

        return response()->json($project);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $project = $this->update($id, $data);
        return response()->json($project);
    }

    public function destroy($id)
    {
        $this->delete($id);
        return response()->json(null, 204);
    }
}

//
