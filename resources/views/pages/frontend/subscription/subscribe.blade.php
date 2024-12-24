<div>
    <section class="flex flex-col max-w-4xl mx-auto py-6">
        <div class="col-span-full xl:col-span-4 xl:col-start-2 [background:linear-gradient(45deg,#90a4ae,theme(colors.slate.200)_50%,#90a4ae)_padding-box,conic-gradient(from_var(--border-angle),theme(colors.slate.300/.48)_80%,theme(colors.indigo.600)_86%,theme(colors.indigo.500)_90%,theme(colors.indigo.600)_100%,theme(colors.slate.300/.48))_border-box] dark:[background:linear-gradient(45deg,#172033,theme(colors.slate.800)_50%,#172033)_padding-box,conic-gradient(from_var(--border-angle),theme(colors.slate.600/.48)_80%,_theme(colors.indigo.500)_86%,_theme(colors.indigo.300)_90%,_theme(colors.indigo.500)_94%,_theme(colors.slate.600/.48))_border-box] rounded-2xl border border-transparent animate-border p-8">
          <div class="prose prose-custom text-lg font-serif dark:prose-invert mb-2">
            <p>You can sign up to get posts by <span class="text-slate-700 dark:text-white underline">Email</span> or <a href="{{ route('rss') }}" target="_blank">RSS</a>.</p>
          </div>
          <div>
            <form wire:submit.prevent="save">
                <div class="flex flex-col sm:flex-row">
                  <div class="grow">
                    <label id="email">
                      <input type="email" name="email" placeholder="Type your email..." autocomplete="email" autocapitalize="off" autocorrect="off" class="border-gray-300 dark:border-gray-500 w-full rounded-md px-4 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900" wire:model="email">
                    </label>
                  </div>
                  <div class="mt-2 flex rounded-md shadow-sm sm:mt-0 sm:ml-3">
                    <button
                        class="w-full inline-flex justify-center whitespace-nowrap rounded-lg px-3.5 py-2.5 text-sm font-semibold text-slate-200 dark:text-slate-800 bg-gradient-to-r from-slate-800 to-slate-700 dark:from-slate-200 dark:to-slate-100 dark:hover:bg-slate-100 shadow focus:outline-none focus:ring focus:ring-slate-500/50 focus-visible:outline-none focus-visible:ring focus-visible:ring-slate-500/50 relative before:absolute before:inset-0 before:rounded-[inherit] before:bg-[linear-gradient(45deg,transparent_25%,theme(colors.white/.5)_50%,transparent_75%,transparent_100%)] dark:before:bg-[linear-gradient(45deg,transparent_25%,theme(colors.white)_50%,transparent_75%,transparent_100%)] before:bg-[length:250%_250%,100%_100%] before:bg-[position:200%_0,0_0] before:bg-no-repeat before:[transition:background-position_0s_ease] hover:before:bg-[position:-100%_0,0_0] hover:before:duration-[1500ms]"
                    >
                        Subscribe
                    </button>
                  </div>
                </div>
                <div class="inline-flex">
                  <x-input-error for="email" class="mt-2" />
                </div>
              </form>
          </div>
        </div>
    </section>
</div>
