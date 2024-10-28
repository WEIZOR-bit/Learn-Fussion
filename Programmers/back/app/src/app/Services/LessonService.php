<?php
namespace App\Services;

use App\Models\Lesson;
use App\Repositories\LessonRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LessonService
{
public function __construct(private LessonRepository $lessonRepository)
{
//
}

public function all(?int $limit = null, array $columns = ['*']): Collection|LengthAwarePaginator
{
return $this->lessonRepository->paginate($limit, $columns);
}

public function create(array $data): Lesson
{
return $this->lessonRepository->create($data);
}

public function update(int $id, array $data): Lesson
{

$lessonData = $data['lesson'];
$questionsData = $data['questions'];

return $this->lessonRepository->updateLessonWithDependencies($id, $lessonData, $questionsData);
}

public function delete(int $id): bool
{
return $this->lessonRepository->delete($this->getById($id));
}

public function getById(int $id): ?Lesson
{
return $this->lessonRepository->findOrFail($id);
}
}
