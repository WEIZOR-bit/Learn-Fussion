<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class CourseRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  Course  $course
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->model = $course;
    }

    public function getAllCourses() {
        return Course::with(['creator'])->get();
    }

    public function create(array $data): mixed
    {
        Log::debug('form create');
        if (isset($data['cover_url'])) {
            $coverPath = $data['cover_url']->store('covers', 'minio_public');
            $fullUrl = 'http://0.0.0.0/storage/public/' . $coverPath;
            $data['cover_url'] = $fullUrl;
        }
        Log::debug($data);
        return Course::create([

            'name' => $data['name'],
            'average_rating' => $data['average_rating'] ?? 0,
            'description' => $data['description'],
            'review_count' => $data['review_count'] ?? 0,
            'published' => $data['published'] ?? false,
            'cover_url' => $data['cover_url'] ?? '',
            'created_by' => $data['created_by'],
            'updated_by' => $data['updated_by'],
            'category_id' => $data['category_id'],
        ]);
    }

    public function update(Model $entity, array $data): bool
    {
        if (isset($data['cover_url'])) {
            $coverPath = $data['cover_url']->store('covers', 'minio_public');
            $fullUrl = 'http://0.0.0.0/storage/public/' . $coverPath;
            $data['cover_url'] = $fullUrl;
            if ($entity->cover_url) {
                $oldPath = str_replace('http://0.0.0.0/storage/public/', '', $entity->cover_url);
                Storage::disk('minio_public')->delete($oldPath);
            }
        }

        $entity->update($data);
        return  $entity->save();
    }


    public function search(string $query) {

        $keywords = explode(' ', $query);

        $courses = Course::with(['category', 'creator']);

        $courses->where('name', 'LIKE', '%' . $query . '%');
        foreach ($keywords as $word) {
            $courses->orWhere('description', 'LIKE', '%' . $word . '%');
        }

        $courses->orWhereHas('creator', function ($query) use ($keywords) {
            foreach ($keywords as $word) {
                $query->where('name', 'LIKE', '%' . $word . '%');
            }
        });
        return $courses->paginate(10);
    }
}
