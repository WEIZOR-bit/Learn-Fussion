<?php

namespace App\Repositories;

use App\Models\Lesson;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class LessonRepository extends BaseRepository
{
    public function __construct(Lesson $lesson)
    {
        $this->model = $lesson;
    }

    public function updateLessonWithDependencies(int $lessonId, array $lessonData, array $questionsData): Lesson
    {
        return DB::transaction(function () use ($lessonId, $lessonData, $questionsData) {
            $lesson = $this->model->findOrFail($lessonId);
            $lesson->update($lessonData);

            // Получаем существующие вопросы
            $existingQuestions = $lesson->questions()->get()->keyBy('id');
            $processedQuestionIds = [];

            foreach ($questionsData as $questionData) {
                $question = isset($questionData['id']) && $existingQuestions->has($questionData['id'])
                    ? $existingQuestions->get($questionData['id'])
                    : new Question(['lesson_id' => $lesson->id]);

                $question->name = $questionData['name'];
                $question->matter = $questionData['matter'] ?? 0;
                $question->save();

                $processedQuestionIds[] = $question->id;

                // Получаем существующие ответы для текущего вопроса
                $existingAnswers = $question->questions_answers()->get()->keyBy('id');
                $processedAnswerIds = [];

                foreach ($questionData['answers'] as $answerData) {
                    // Создаем или обновляем ответ
                    $answer = isset($answerData['id']) && $existingAnswers->has($answerData['id'])
                        ? $existingAnswers->get($answerData['id'])
                        : new Answer();

                    $answer->text = $answerData['text'];
                    $answer->correct = $answerData['correct'] ?? false;
                    $answer->save();

                    $processedAnswerIds[] = $answer->id;

                    // Обновляем связь через промежуточную таблицу `questions_answers`
                    if (!$question->questions_answers()->wherePivot('answer_id', $answer->id)->exists()) {
                        $question->questions_answers()->attach($answer->id, ['question_id' => $question->id]);
                    }
                }

                // Удаляем ответы, которых нет в запросе, из промежуточной таблицы
                $question->questions_answers()->wherePivotNotIn('answer_id', $processedAnswerIds)->detach();
            }

            // Удаляем вопросы, которых нет в запросе
            $lesson->questions()->whereNotIn('id', $processedQuestionIds)->delete();

            return $lesson->refresh();
        });
    }
}


