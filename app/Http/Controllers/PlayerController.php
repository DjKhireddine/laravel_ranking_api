<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $name = trim($request->input('name'));

        if (Player::where('name', $name)->exists()) {
            return response()->json([
                'message' => 'Ce pseudo est déjà utilisé.',
            ], 409);
        }

        $player = Player::create(['name' => $name]);

        return response()->json([
            'id'   => $player->id,
            'name' => $player->name,
        ], 201);
    }
}
