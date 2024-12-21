<?php

namespace App\Modules\Frontend\Subscription;

use Livewire\Component;
use App\Models\Subscriber;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;

class Subscribe extends Component
{
    use WithRateLimiting;

    public $email;

    protected $rules = [
        'email' => 'required|email|unique:subscribers,email',
    ];

    public function save()
    {
        $this->validate();

        Subscriber::create(['email' => $this->email]);

        $this->reset();
    }

    public function render()
    {
        return view('pages.frontend.subscription.subscribe');
    }
}
