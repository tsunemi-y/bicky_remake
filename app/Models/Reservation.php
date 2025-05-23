<?php

namespace App\Models;

use App\Models\User;
use App\Models\Child;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reservation_date',
        'reservation_time',
        'end_time',
    ];

    /**
     * ユーザテーブルとのリレーション
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 利用児（子供）との多対多リレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_reservation');
    }
    
    public function scopeJoinUsers($query)
    {
        return $query->join('users', 'users.id', '=', 'reservations.user_id');
    }

    public function scopeEqualDate($query, $date)
    {
        if ($date != '') {
            return $query->where('reservation_date', '=', $date);
        }
    }

    public function scopeFuzzyName($query, $name)
    {
        if ($name != '') {
            return $query->where('name', 'like', "%$name%");
        }
    }

    public function scopeEqualId($query, $id)
    {
        if ($id != '') {
            return $query->where('reservations.id', '=', $id);
        }
    }
}
