<?php

namespace App\Services;

use App\Models\Project; // Import the ImageUploadTrait
use App\Traits\CrudTrait;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
class ProjectService
{
    use CrudTrait, ImageUploadTrait;
    protected function getModel()
    {
        return new Project();
    }

    public function index()
    {
        $projects = $this->getModel()->all();

        // Iterate through projects to add image URLs to each project
        foreach ($projects as $project) {
            if ($project->images) {
                $images = json_decode($project->images, true);
                // Add the image URLs to the project's images array
                $project->images = Arr::map($images, function ($image) {
                    return asset('public/.storage/' . $image);
                });
            }
        }

        return $projects;
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

        return $project;
    }



    public function show($id)
    {
        $project = $this->read($id);
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
