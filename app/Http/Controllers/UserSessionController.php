<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSession;
use App\Models\UserBreak;
use App\Events\UserStatusChanged;

class UserSessionController extends Controller
{
    public function startPause(Request $request)
    {
        $request->validate(['type' => 'required|string']);

        $session = UserSession::findOrFail(session('user_session_id'));

        $break = $session->breaks()->create([
            'type'       => $request->type,
            'started_at' => now(),
        ]);

        $session->update(['status' => 'paused']);

        event(new UserStatusChanged($session));

        return response()->json(['break' => $break]);
    }

    public function endPause()
    {
        $session = UserSession::findOrFail(session('user_session_id'));

        $break = $session->breaks()->whereNull('ended_at')->latest()->first();
        if ($break) {
            $break->update(['ended_at' => now()]);
        }

        $session->update(['status' => 'available']);

        event(new UserStatusChanged($session));

        return response()->json(['break' => $break]);
    }
}
