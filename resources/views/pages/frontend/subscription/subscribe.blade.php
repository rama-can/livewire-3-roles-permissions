<div>
    <section class="flex flex-col max-w-4xl mx-auto py-6">
        <div class="col-span-full xl:col-span-4 xl:col-start-2 [background:linear-gradient(45deg,#172033,theme(colors.slate.800)_50%,#172033)_padding-box,conic-gradient(from_var(--border-angle),theme(colors.slate.600/.48)_80%,_theme(colors.indigo.500)_86%,_theme(colors.indigo.300)_90%,_theme(colors.indigo.500)_94%,_theme(colors.slate.600/.48))_border-box] rounded-2xl border border-transparent animate-border p-8">
          <div class="prose prose-custom text-lg font-serif dark:prose-invert mb-2">
            <p>You can sign up to get posts by <span class="text-slate-700 dark:text-white underline">Email</span> or <a href="{{ route('rss') }}" data-fathom="YKQ6ZLVM" target="_blank">RSS</a>.</p>
          </div>
          <div>
            <form>
                <div class="flex flex-col sm:flex-row">
                  <div class="grow">
                    <label id="email">
                      <input type="email" name="email" placeholder="Type your email..." autocomplete="email" autocapitalize="off" autocorrect="off" class="border-gray-300 dark:border-gray-500 w-full rounded-md px-4 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-teal-500 dark:bg-gray-900" required="">
                    </label>
                  </div>
                  <div class="mt-2 flex rounded-md shadow-sm sm:mt-0 sm:ml-3">
                    <x-ui-button class="w-full rounded-md">Subscribe</x-ui-button>
                  </div>
                </div>
              </form>
          </div>
        </div>
    </section>
</div>
