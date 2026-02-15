<?php

namespace App\Http\Controllers;

use App\Models\YakuniySetting;
use App\Models\YakuniyQuestion;
use App\Models\YakuniyOption;
use App\Models\YakuniyResult;
use Illuminate\Http\Request;
use Carbon\Carbon;

class YakuniyNazoratController extends Controller
{
    private function isAdmin()
    {
        return auth()->check() && auth()->user()->email === 'ccnodirbekcc@gmail.com';
    }

    public function index()
    {
        $settings = YakuniySetting::first();
        $oraliqScore = auth()->user()->oraliqTotalScore();
        $isEligible = $oraliqScore >= 30;

        $myResult = YakuniyResult::where('user_id', auth()->id())->first();

        $status = 'not_set';
        if ($settings) {
            $now = Carbon::now();
            $start = Carbon::parse($settings->start_time);
            $end = Carbon::parse($settings->end_time);

            if ($now->lt($start)) {
                $status = 'not_started';
            } elseif ($now->gt($end)) {
                $status = 'ended';
            } else {
                $status = 'active';
            }
        }

        return view('yakuniy.index', compact('settings', 'oraliqScore', 'isEligible', 'myResult', 'status'));
    }

    // USER: Take test
    public function take()
    {
        if ($this->isAdmin())
            abort(403);

        $oraliqScore = auth()->user()->oraliqTotalScore();
        if ($oraliqScore < 30) {
            return redirect()->route('yakuniy.index')->with('error', 'Yakuniy topshirish uchun yetarli ball to‘planmadi (kamida 30 ball kerak)');
        }

        $settings = YakuniySetting::first();
        if (!$settings) {
            return redirect()->route('yakuniy.index')->with('error', 'Yakuniy nazorat hali belgilanmagan');
        }

        $now = Carbon::now();
        $start = Carbon::parse($settings->start_time);
        $end = Carbon::parse($settings->end_time);

        if ($now->lt($start)) {
            return redirect()->route('yakuniy.index')->with('error', 'Yakuniy nazorat hali boshlanmagan');
        }

        if ($now->gt($end)) {
            return redirect()->route('yakuniy.index')->with('error', 'Yakuniy nazorat vaqti tugagan');
        }

        if (YakuniyResult::where('user_id', auth()->id())->exists()) {
            return redirect()->route('yakuniy.index')->with('error', 'Siz allaqachon topshiriq yuborgansiz.');
        }

        $questions = YakuniyQuestion::with('options')->get();
        return view('yakuniy.take', compact('questions', 'settings'));
    }

    // USER: Submit test
    public function submit(Request $request)
    {
        if ($this->isAdmin())
            abort(403);

        $settings = YakuniySetting::first();
        if (!$settings) {
            return redirect()->route('yakuniy.index')->with('error', 'Yakuniy nazorat hali belgilanmagan');
        }

        $oraliqScore = auth()->user()->oraliqTotalScore();
        if ($oraliqScore < 30) {
            return redirect()->route('yakuniy.index')->with('error', 'Yakuniy topshirish uchun yetarli ball to‘planmadi (kamida 30 ball kerak)');
        }

        $now = Carbon::now();
        $start = \Carbon\Carbon::parse($settings->start_time);
        $end = \Carbon\Carbon::parse($settings->end_time);

        if ($now->lt($start) || $now->gt($end)) {
            $msg = $now->lt($start) ? 'Yakuniy nazorat hali boshlanmagan' : 'Yakuniy nazorat vaqti tugagan';
            return redirect()->route('yakuniy.index')->with('error', $msg);
        }

        if (YakuniyResult::where('user_id', auth()->id())->exists()) {
            return redirect()->route('yakuniy.index')->with('error', 'Siz allaqachon topshiriq yuborgansiz.');
        }

        $questions = YakuniyQuestion::with('options')->get();
        $totalScore = 0;

        foreach ($questions as $q) {
            $answerOptionId = $request->input('q_' . $q->id);
            if ($answerOptionId) {
                $option = $q->options->where('id', $answerOptionId)->first();
                if ($option && $option->is_correct) {
                    $totalScore += $q->score;
                }
            }
        }

        YakuniyResult::create([
            'user_id' => auth()->id(),
            'total_score' => $totalScore,
            'submitted_at' => now(),
        ]);

        return redirect()->route('yakuniy.index')->with('success', 'Yakuniy nazorat muvaffaqiyatli topshirildi. Yakuniy natija: ' . $totalScore . ' ball');
    }

    // ADMIN: Settings
    public function settings()
    {
        if (!$this->isAdmin())
            abort(403);
        $settings = YakuniySetting::first();
        return view('yakuniy.admin.settings', compact('settings'));
    }

    public function storeSettings(Request $request)
    {
        if (!$this->isAdmin())
            abort(403);
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        YakuniySetting::updateOrCreate(['id' => 1], $request->only('start_time', 'end_time'));
        return back()->with('success', 'Vaqt muvaffaqiyatli saqlandi.');
    }

    // ADMIN: Questions
    public function questions()
    {
        if (!$this->isAdmin())
            abort(403);
        $questions = YakuniyQuestion::with('options')->get();
        return view('yakuniy.admin.questions', compact('questions'));
    }

    public function storeQuestion(Request $request)
    {
        if (!$this->isAdmin())
            abort(403);
        $request->validate([
            'question_text' => 'required|string',
            'score' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $q = YakuniyQuestion::create([
            'question_text' => $request->question_text,
            'score' => $request->score,
        ]);

        foreach ($request->options as $index => $text) {
            YakuniyOption::create([
                'question_id' => $q->id,
                'option_text' => $text,
                'is_correct' => ($index == $request->correct_option),
            ]);
        }

        return back()->with('success', 'Savol qo‘shildi.');
    }

    public function deleteQuestion(YakuniyQuestion $question)
    {
        if (!$this->isAdmin())
            abort(403);
        $question->delete();
        return back()->with('success', 'Savol o‘chirildi.');
    }

    // ADMIN: Results
    public function results()
    {
        if (!$this->isAdmin())
            abort(403);
        $results = YakuniyResult::with('user')->orderBy('total_score', 'desc')->get();
        return view('yakuniy.admin.results', compact('results'));
    }
}
