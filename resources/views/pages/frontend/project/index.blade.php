<div>
    <section class="py-10">
        <div class="container px-6 mx-auto">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-slate-800 capitalize lg:text-3xl dark:text-slate-200">Projects</h1>
                <p class="max-w-xl mx-auto mt-4 text-slate-800 dark:text-slate-200">
                    {{ __('frontend.frontend_projects_section_description') }}
                </p>
            </div>
            <div class="grid lg:grid-cols-3 gap-6 mt-8">
                @foreach ($this->getProjectsProperty as $project)
                    <x-card-project
                        :thumbnail="$project->thumbnailUrl"
                        :name="$project->name"
                        :description="$project->description"
                        :tags="$project->tags"
                        url="#"
                    />
                @endforeach
            </div>
        </div>
    </section>
</div>
