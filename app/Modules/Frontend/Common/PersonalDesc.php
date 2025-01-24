<?php

namespace App\Modules\Frontend\Common;

use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy()]
class PersonalDesc extends Component
{
    public function placeholder()
    {
        return view('components.skeleton.personal-desc');
    }

    public function render()
    {
        $title = __('frontend.frontend_personal_section_title');
        $description = __('frontend.frontend_personal_section_description');
        return view('pages.frontend.common.personal-desc', [
            'title' => $title,
            'description' => $description,
        ]);
    }
}
