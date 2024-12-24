<?php

namespace App\Modules\Frontend\Contact;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Index extends Component
{
    use WithRateLimiting;
    public $name;
    public $email;
    public $message;

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email:rfc,filter|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'message' => 'required|string',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submitForm()
    {
        try {
            $this->validate();
            $this->rateLimit(1);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'email' => "Slow down! Please wait another {$exception->secondsUntilAvailable} seconds to log in.",
            ]);
        }
        // $this->validate();

        // rate limit the form submission
        sleep(1);


        // Process the form submission
        // Send email, save to database, etc.
        // Redirect to a new page


        // $this->reset();
    }

    #[Layout('layouts.frontend')]
    public function render()
    {
        return view('pages.frontend.contact.index');
    }
}
