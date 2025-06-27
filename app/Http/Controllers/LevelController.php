<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLevel;

class LevelController extends Controller
{
    public function complete()
    {
        $userLevel = Auth::user()->levelInfo;

        if (!$userLevel) {
            $userLevel = new UserLevel([
                'level' => 1,
                'xp' => 0,
            ]);
            Auth::user()->levelInfo()->save($userLevel);
        }

        // Tambah 250 XP
        $userLevel->xp += 250;

        // Level up logic: setiap 100 XP naik level
        while ($userLevel->xp >= 100) {
            $userLevel->level += 1;
            $userLevel->xp -= 100;
        }

        $userLevel->save();

        return redirect()->route('dashboard')->with('success', 'Quiz selesai! XP & Level diperbarui.');
    }
}

