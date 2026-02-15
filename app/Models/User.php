<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\InnoEduSysVerifyEmail;
use App\Models\OraliqSubmission;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function oraliqSubmissions()
    {
        return $this->hasMany(OraliqSubmission::class);
    }

    public function oraliqTotalScore()
    {
        return $this->oraliqSubmissions()->sum('score');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all submissions made by this user (student).
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Check if user is a teacher.
     */
    public function isTeacher(): bool
    {
        return $this->email === 'ccnodirbekcc@gmail.com';
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->email === 'ccnodirbekcc@gmail.com';
    }

    /**
     * Get all question answers made by this user.
     */
    public function questionAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }

    /**
     * Get all video completions by this user.
     */
    public function videoCompletions()
    {
        return $this->hasMany(VideoCompletion::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new InnoEduSysVerifyEmail);
    }
}
