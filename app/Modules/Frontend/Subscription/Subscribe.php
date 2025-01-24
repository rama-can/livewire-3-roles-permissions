<?php

namespace App\Modules\Frontend\Subscription;

use Livewire\Component;
use App\Models\Subscriber;
use Livewire\Attributes\Lazy;
use TallStackUi\Traits\Interactions;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

#[Lazy()]
class Subscribe extends Component
{
    use WithRateLimiting, Interactions;

    public $email;

    protected $rules = [
        'email' => 'required|email:rfc,filter|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|unique:subscribers,email',
    ];

    public function save()
    {
        $this->validate();
        try {
            $this->rateLimit(
                1,
                59
            );
            Subscriber::create(['email' => $this->email]);
        } catch (TooManyRequestsException $exception) {
            $this->toast()->warning("Slow down! Please wait another {$exception->minutesUntilAvailable} minutes to submit.")->send();
            throw ValidationException::withMessages([
                'email' => "Slow down! Please wait another {$exception->minutesUntilAvailable} minutes to submit",
            ]);
        }

        $this->reset();

        $this->toast()->success('Thanks for subscribing.')->send();
    }

    public function placeholder()
    {
        return view('components.skeleton.subscribe');
    }

    public function render()
    {
        return view('pages.frontend.subscription.subscribe');
    }
}
