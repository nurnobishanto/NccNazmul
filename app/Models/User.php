<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'phone_number',
        'password',
        'image',
        'college',
        'batch',
        'division_id',
        'district_id',
        'upazila',
        'postOffice',
        'postCode',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public static function generateUniqueUserId()
    {
        $currentYear = now()->year % 100;
        $currentMonth = now()->month;
        // Format the user ID with a prefix (e.g., 231100001)
        return sprintf('%02d%02d%04d', $currentYear, $currentMonth, self::generateNextUserId());
    }

    private static function generateNextUserId()
    {
        return static::max('id') + 1;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->user_id = self::generateUniqueUserId();
        });
    }

//    public function results(): \Illuminate\Database\Eloquent\Relations\HasMany
//    {
//        return $this->hasMany(Result::class);
//    }
    public function getFilamentAvatarUrl(): ?string
    {
        if($this->image){
            return asset('uploads/'.$this->image);
        }else{
            return asset('website/assets/images/'.$this->gender.'.png');
        }

    }
    public function canAccessPanel(Panel $panel): bool
    {
        //return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
        return true;
    }
}
