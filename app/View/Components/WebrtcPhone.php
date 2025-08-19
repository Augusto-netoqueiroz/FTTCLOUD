<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Services\SipConfigService;

class WebrtcPhone extends Component
{
    public function __construct(private SipConfigService $sip) {}

    public function render(): View|Closure|string
    {
        $user = Auth::user();
        $config = $user ? $this->sip->forUser($user) : null;

        return view('components.webrtc-phone', compact('config'));
    }
}
