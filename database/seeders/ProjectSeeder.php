<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseImagePath = public_path(Project::BASE_IMAGE_PATH);
        $imagePath = public_path(Project::IMAGE_PATH);

        if (!File::exists($imagePath)) {
            File::makeDirectory($imagePath, 0777, true);
        }

        $description = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s
            standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
            publishing software like Aldus PageMaker including versions of Lorem Ipsum.';

        $limits = [100, 250, 200];

        for ($i = 0; $i < 10; $i++) {
            $name = 'Project ' . $i + 1;

            $project = Project::updateOrCreate([
                'slug' => Str::slug($name),
            ], [
                'name' => $name,
                'url' => '#',
                'short_description' => Str::limit($description, $limits[$i % 3]),
                'description' => $description
            ]);

            $basename = $project->id . '.' . File::extension($baseImagePath);

            File::copy($baseImagePath, $imagePath . $basename);

            $project->update([
                'order' => $project->id,
                'image' => $basename
            ]);
        }
    }
}
