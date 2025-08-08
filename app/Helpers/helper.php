<?php

use App\Jobs\CreateQuestionJob;
use App\Models\Answer;
use App\Models\Game;
use App\Models\Lesson;
use App\Models\Log;
use App\Models\Sentence;
use App\Models\Step;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as FacadesLog;

function makeSlug(Model $model, $text = null, string $divider = '-')
{
    $text = $text ?? $model->name ?? $model->title ?? slugify(explode('\\', strtolower(get_class($model)))[2]);

    $slug = preg_replace('~[^\pL\d]+~u', $divider, $text);
    $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
    $slug = preg_replace('~[^-\w]+~', '', $slug);
    $slug = trim($slug, $divider);
    $slug = preg_replace('~-+~', $divider, $slug);
    $slug = strtolower($slug);

    if (empty($slug)) {
        $slug = uniqid();
    }

    if ($model::whereSlug($slug)->first()) {
        do {
            $slug =  $slug . rand(1, 1000);
            $slug = makeSlug($model, $slug);
        } while ($model::whereSlug($slug)->first());
    }

    return $slug;
}


function slugify($text = '', string $divider = '-')
{
    if ($text) {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);
    }

    return uniqid($text);
}


function generateNumericCode($size)
{
    $code = '';
    // Initialisation des caractères utilisables
    $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

    for ($i = 0; $i < $size; $i++) {
        $code .= $characters[array_rand($characters)];
    }

    return $code;
}


function generateAlphaNumericCode($size = 6)
{
    $code = strtoupper(\Illuminate\Support\Str::random($size));

    return $code;
}


// function saveLog($target, $target_id, $action, $data = [])
// {
//     FacadesLog::create([
//         'slug' => slugify('log'),
//         'user_id' => auth()->id(),
//         'target' => $target,
//         'target_id' => $target_id,
//         'action' => $action,
//         'data' => json_encode($data),
//     ]);
// }

function userLang($lang = null)
{
    if ($lang) return $lang;

    $lang = (Auth::check()) ? (Auth::user()->lang) ? Auth::user()->lang : 'fr ' : 'fr';
    return $lang;
}

// function fr()
// {
//     return \App\Models\Language::whereCode('fr')->first();
// }

// function en()
// {
//     return \App\Models\Language::whereCode('en')->first();
// }

// function generateFakeQuestion($lesson, $number = 1, $level = null)
// {

//     $level = $level ?? \App\Models\Level::whereVernacularId(1)->first();

//     foreach (\App\Models\Question::whereStatus('active')->whereLevelId($level->id)->inRandomOrder()->take($number)->get() as $key => $question) {
//         $newQuestion = \App\Models\Question::create([
//             'lesson_id' => $lesson->id,
//             'sentence_id' => $question->sentence_id,
//             'game_id' => $question->game_id,
//             'question' => $question->question,
//             'direction' => $question->direction,
//             'value' => $question->value,
//             'status' => $question->status
//         ]);
//         foreach ($question->answers as $key => $answer) {
//             Answer::create([
//                 'question_id' => $newQuestion->id,
//                 'sentence_id' => $answer->sentence_id,
//                 'value' => $answer->value
//             ]);
//         }

//         \App\Models\Step::create([
//             'lesson_id' => $lesson->id,
//             'target' => 'question',
//             'target_id' => $newQuestion->id,
//             'value' => $question->step->value,
//             'status' => $question->step->status,
//         ]);
//     }
// }


// function createFakeVernaculars($number = 1)
// {

//     for ($i = 0; $i < $number; $i++) {
//         $vernacular = \App\Models\Vernacular::factory()->create();

//         $ref = \App\Models\Vernacular::whereIn('id', [1, 8])->inRandomOrder()->first();
//         $translations = [];
//         foreach (\App\Models\Translation::whereVernacularId($ref->id)->get() as $key => $translation) {
//             $translations[] = [
//                 'vernacular_id' => $vernacular->id,
//                 'sentence_id' => $translation->sentence_id,
//                 'voice' => $translation->voice,
//                 'pronunciation' => $translation->pronunciation,
//                 'translation' => $translation->translation,
//                 'status' => $translation->status,
//             ];
//         }
//         \App\Models\Translation::insert($translations);

//         for ($u = 0; $u < rand(5, 10); $u++) {
//             $theme = \App\Models\Theme::factory()->create(['vernacular_id' => $vernacular->id]);

//             for ($v = 0; $v < rand(3, 6); $v++) {
//                 $level = \App\Models\Level::factory()->create(['theme_id' => $theme->id]);

//                 for ($v = 0; $v < rand(6, 15); $v++) {
//                     $lesson = \App\Models\Lesson::factory()->create(['level_id' => $level->id]);

//                     generateFakeQuestion($lesson, rand(8, 15));
//                 }
//             }
//         }
//     }
// }

// function createQuestion(Lesson $lesson, Game $game, Sentence $sentence, string $direction, int $rank, $fakeAnswers = null, string $title_fr = null, string $title_en = null, string $status = 'published')
// {
//     if ($sentence) {
//         CreateQuestionJob::dispatch($lesson,$game,$sentence,$direction,$rank, $fakeAnswers,$title_fr,$title_en,$status);
//         return true;
//     }

//     return false;

    // $question = \App\Models\Question::updateOrCreate(
    //     [
    //         'lesson_id' => $lesson->id,
    //         'sentence_id' => $sentence->id,
    //     ],
    //     [
    //         'game_id' => $game->id,
    //         'direction' => $direction,
    //     ]
    // );

    // \App\Models\Step::updateOrCreate(
    //     [
    //         'lesson_id' => $question->lesson_id,
    //         'target' => 'question',
    //         'target_id' => $question->id,
    //     ],
    //     [
    //         'rank' => $question->rank,
    //     ]
    // );
    // $question->answers()->delete();

    // $answers = [];
    // if ($question->game->slug == "what_do_you_hear") {
    //     $sentences = \App\Models\Sentence::where('id', '!=', $question->sentence_id)->whereHas('translations', function ($query) use ($lesson) {
    //         $query->whereVernacularId($lesson->vernacular_id)->whereRaw('LENGTH(translation) < 15');
    //     })
    //         ->inRandomOrder()
    //         ->take(rand(4, 6))
    //         ->get();

    //     $answers[] = [
    //         'vernacular_id' => $lesson->vernacular_id,
    //         'question_id' => $question->id,
    //         'sentence_id' => $question->sentence_id,
    //         'value' => 1,
    //     ];
    //     foreach ($sentences as $key => $sentence) {
    //         $answers[] = [
    //             'vernacular_id' => $lesson->vernacular_id,
    //             'question_id' => $question->id,
    //             'sentence_id' => $sentence->id,
    //             'value' => 0,
    //         ];
    //     }
    // } elseif ($question->game->slug == 'what_do_you_see') {
    //     global $answers;
    //     $answers[] = [
    //         'vernacular_id' => $lesson->vernacular_id,
    //         'question_id' => $question->id,
    //         'sentence_id' => $question->sentence_id,
    //         'value' => 1,
    //     ];
    // } elseif ($question->game->slug == 'word_to_word') {
    //     $sentences = \App\Models\Sentence::where('id', '!=', $question->sentence_id)->whereHas('translations', function ($query) use ($lesson) {
    //         $query->whereVernacularId($lesson->vernacular_id)->whereRaw('LENGTH(translation) < 15');
    //     })
    //         ->inRandomOrder()
    //         ->take(rand(4, 6))
    //         ->get();

    //     $answers[] = [
    //         'vernacular_id' => $lesson->vernacular_id,
    //         'question_id' => $question->id,
    //         'sentence_id' => $question->sentence_id,
    //         'value' => 1,
    //     ];
    //     foreach ($sentences as $key => $sentence) {
    //         $answers[] = [
    //             'vernacular_id' => $lesson->vernacular_id,
    //             'question_id' => $question->id,
    //             'sentence_id' => $sentence->id,
    //             'value' => 0,
    //         ];
    //     }
    // } elseif ($question->game->slug == 'word_image_representation') {
    //     $sentences = \App\Models\Sentence::where('id', '!=', $question->sentence_id)->whereHas('translations', function ($query) use ($lesson) {
    //         $query->whereVernacularId($lesson->vernacular_id)->whereRaw('LENGTH(translation) < 30');
    //     })
    //         ->inRandomOrder()
    //         ->take(4)
    //         ->get();

    //     $answers[] = [
    //         'vernacular_id' => $lesson->vernacular_id,
    //         'question_id' => $question->id,
    //         'sentence_id' => $question->sentence_id,
    //         'value' => 1,
    //     ];
    //     foreach ($sentences as $key => $sentence) {
    //         $answers[] = [
    //             'vernacular_id' => $lesson->vernacular_id,
    //             'question_id' => $question->id,
    //             'sentence_id' => $sentence->id,
    //             'value' => 0,
    //         ];
    //     }
    // } elseif ($question->game->slug == 'translate_sentence') {
    //     $answers[] = [
    //         'vernacular_id' => $lesson->vernacular_id,
    //         'question_id' => $question->id,
    //         'sentence_id' => $question->sentence_id,
    //         'value' => 1,
    //     ];
    // } else {
    //     return [
    //         'error' => 'game_error',
    //         'game' => $question->game,
    //         'question' => $question,
    //     ];
    // }
    // \Illuminate\Support\Facades\DB::table('answers')->insert($answers);
    // return $question->fresh()->load('answers');
// }
