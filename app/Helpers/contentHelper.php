<?php

function saveQuestions($questions){

    foreach ($questions as $question) {

        $newQuestion = \App\Models\Question::updateOrCreate(
            [
                'lesson_id' => $question['lesson_id'],
                'game_id' => \App\Models\Game::whereSlug($question['game'])->first()->id,
                'sentence_id' => $question['sentence_id'],
            ]
        );

        \App\Models\Step::updateOrCreate(
            [
                'lesson_id' => $newQuestion->lesson_id,
                'target' => 'question',
                'target_id' => $newQuestion->id,
            ],
            [
                'rank' => $newQuestion->rank,
            ]
        );

        \App\Jobs\GenerateAnswers::dispatch($newQuestion);
    }
}


function generateAnswers($question){
    $question->answers()->delete();

    $answers = [];
    if ($question->game->slug == "what_do_you_hear") {
        $sentences = \App\Models\Sentence::where('id', '!=', $question->sentence_id)->whereHas('translations', function ($query) use ($question) {
            $query->whereVernacularId($question->vernacular_id)->whereRaw('LENGTH(translation) < 15');
        })->get()->shuffle()->take(rand(4, 8));

        $answers[] = [
            'vernacular_id' => $question->vernacular_id,
            'question_id' => $question->id,
            'sentence_id' => $question->sentence_id,
            'value' => 1,
        ];
        foreach ($sentences as $key => $sentence) {
            $answers[] = [
                'vernacular_id' => $question->vernacular_id,
                'question_id' => $question->id,
                'sentence_id' => $sentence->id,
                'value' => 0,
            ];
        }
    } elseif ($question->game->slug == 'what_do_you_see') {
        global $answers;
        $answers[] = [
            'vernacular_id' => $question->vernacular_id,
            'question_id' => $question->id,
            'sentence_id' => $question->sentence_id,
            'value' => 1,
        ];
    } elseif ($question->game->slug == 'word_to_word') {
        $sentences = \App\Models\Sentence::where('id', '!=', $question->sentence_id)->whereHas('translations', function ($query) use ($question) {
            $query->whereVernacularId($question->vernacular_id)->whereRaw('LENGTH(translation) < 15');
        })->get()->shuffle()->take(rand(4, 8));

        $answers[] = [
            'vernacular_id' => $question->vernacular_id,
            'question_id' => $question->id,
            'sentence_id' => $question->sentence_id,
            'value' => 1,
        ];
        foreach ($sentences as $key => $sentence) {
            $answers[] = [
                'vernacular_id' => $question->vernacular_id,
                'question_id' => $question->id,
                'sentence_id' => $sentence->id,
                'value' => 0,
            ];
        }
    } elseif ($question->game->slug == 'word_image_representation') {
        $sentences = \App\Models\Sentence::where('id', '!=', $question->sentence_id)->whereHas('translations', function ($query) use($question) {
            $query->whereVernacularId($question->vernacular_id)->whereRaw('LENGTH(translation) < 30');
        })->get()->shuffle()->take(6);

        $answers[] = [
            'vernacular_id' => $question->vernacular_id,
            'question_id' => $question->id,
            'sentence_id' => $question->sentence_id,
            'value' => 1,
        ];
        foreach ($sentences as $key => $sentence) {
            $answers[] = [
                'vernacular_id' => $question->vernacular_id,
                'question_id' => $question->id,
                'sentence_id' => $sentence->id,
                'value' => 0,
            ];
        }
    } elseif ($question->game->slug == 'translate_sentence') {
        $answers[] = [
            'vernacular_id' => $question->vernacular_id,
            'question_id' => $question->id,
            'sentence_id' => $question->sentence_id,
            'value' => 1,
        ];
    } else {
        return [
            'error' => 'game_error',
            'game' => $question->game,
            'question' => $question,
        ];
    }


    \Illuminate\Support\Facades\DB::table('answers')->insert($answers);

    return $question->answers;
}