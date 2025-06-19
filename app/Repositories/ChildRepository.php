<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Child;

use App\Repositories\Repository;

class ChildRepository extends Repository
{
    public function getChildrenByUserId(int $userId): Collection
    {
        return Child::where('user_id', $userId)->get();
    }

    public function createChild(int $userId, string $name): Child
    {
        return Child::create([
            'user_id' => $userId,
            'name' => $name,
        ]);
    }

    public function getSelectedChildren(array $childIds): Collection
    {
        return Child::whereIn('id', $childIds)->get();
    }

    public function getChildrenByReservationId($reservationId): Collection
    {
        return DB::table('child_reservation')
            ->where('reservation_id', $reservationId)
            ->get();
    }
}