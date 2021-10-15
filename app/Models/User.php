<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The roles that belong to the user.
     */
    public function points()
    {
        return $this->belongsToMany(Point::class)->withPivot('period_id', 'created_at');
    }

    public function getCurrentPeriodPoints()
    {
        $currentPeriodId = Period::getCurrentPeriod()[0]->id;
        $points = $this->points()->where('period_id', $currentPeriodId)->get();
        $total = 0;
        foreach ($points as $point) {
            $total += $point->point;
        }

        return $total;
    }

    public function getChartPoints()
    {
        $currentPeriodId = Period::getCurrentPeriod()[0]->id;

        $progreso = DB::select('
            select sum(p.point) total, pu.created_at
            from point_user pu
            inner join points p on pu.point_id = p.id
            where user_id = ?
            and period_id = ?
            group by pu.created_at
        ', [
            $this->id,
            $currentPeriodId
        ]);

        return $progreso;
    }
}
