<?php

namespace App\Repositories;

use App\Models\Child;

class ChildRepository
{
    public function getChildren(int $userId): Collection
    {
        return Child::where('user_id', $userId)->get();
    }

    public function createChild(int $userId, string $name): Child
    {
        return Child::create([
            'user_id' => $userId,
            'name' => $request->name,
        ]);
    }

    public function getSelectedChildren(array $childIds): Collection
    {
        return Child::whereIn('child_id', $childIds)->get();
    }
}