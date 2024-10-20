<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\MagicLoginLink;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            $user->sendLoginLink();
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_seen' => 'datetime',
        ];
    }

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class)->orderBy('area')->orderBy('district');
    }

    public function loginTokens()
    {
        return $this->hasMany(LoginToken::class);
    }

    public function sendLoginLink()
    {
        $plaintext = Str::random(32);

        // consume all previous tokens
        $this->loginTokens()->update(['consumed_at' => now()]);

        $token = $this->loginTokens()->create([
            'token' => hash('sha256', $plaintext),
            'expires_at' => now()->addYears(2),
        ]);
        Mail::to($this->email)->send(new MagicLoginLink($plaintext, $token->expires_at));
    }


}
