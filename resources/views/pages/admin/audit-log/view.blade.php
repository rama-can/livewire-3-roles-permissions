<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['url' => route('admin.audit-logs.index'), 'label' => 'Audit Logs'],
            ['label' => 'View']
        ]" />

        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Audit Log</h1>
            </div>

        </div>
        <!-- Content -->
        <div class="container mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <div class="space-y-4">
                    <!-- Description -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="text-gray-800 dark:text-gray-100">
                            <strong>Action Type:</strong>
                        </div>
                        <div class="text-gray-800 dark:text-gray-100">
                            @if ($data->description === 'created')
                                <x-ui-badge text="CREATED" color="emerald" light />
                            @elseif ($data->description === 'updated')
                                <x-ui-badge text="UPDATED" color="indigo" light />
                            @elseif ($data->description === 'deleted')
                                <x-ui-badge text="DELETED" color="rose" light />
                            @endif
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="text-gray-800 dark:text-gray-100">
                            <strong>Subject Type:</strong>
                        </div>
                        <div class="text-gray-800 dark:text-gray-100">
                            {{ $data->subject_type }}
                        </div>

                        <div class="text-gray-800 dark:text-gray-100">
                            <strong>Subject ID:</strong>
                        </div>
                        <div class="text-gray-800 dark:text-gray-100">
                            {{ $data->subject_id }}
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="text-gray-800 dark:text-gray-100">
                            <strong>User ID:</strong>
                        </div>
                        @if ($data->user)
                            <a href="{{ route('admin.users.edit', $data->user->id) }}" class="text-blue-800 dark:text-blue-400 underline underline-offset-4">
                                {{ $data->user->id }}
                            </a>
                        @else
                            <span class="text-gray-800 dark:text-gray-100">System</span>
                        @endif
                    </div>

                    <!-- Host and User Agent -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="text-gray-800 dark:text-gray-100">
                            <strong>IP Address:</strong>
                        </div>
                        <div class="text-gray-800 dark:text-gray-100">
                            {{ $data->host }}
                        </div>

                        <div class="text-gray-800 dark:text-gray-100">
                            <strong>User Agent:</strong>
                        </div>
                        <div class="text-gray-800 dark:text-gray-100 italic">
                            {{ $data->user_agent }}
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 text-right">
                    <a href="{{ route('admin.audit-logs.index') }}" class="text-blue-600 hover:text-blue-800">Back to Log List</a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-5">
                <div class="text-gray-800 dark:text-gray-100">
                    <strong>Properties:</strong>
                </div>
                <pre class="bg-gray-800 text-white p-2 rounded-lg overflow-auto font-mono text-sm mt-0.5 border">
                    <code id="json-display" class="block">{{ json_encode($properties, JSON_PRETTY_PRINT) }}</code>
                </pre>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function syntaxHighlight(json) {
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(
            /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?|\{|\}|\[|\])/g,
            function (match) {
                let cls = 'text-green-500'; // Default untuk string
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'text-blue-500'; // Warna untuk key
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'text-yellow-500'; // Warna untuk boolean
                } else if (/null/.test(match)) {
                    cls = 'text-red-500'; // Warna untuk null
                } else if (/^-?\d+/.test(match)) {
                    cls = 'text-purple-500'; // Warna untuk angka
                } else if (/[\{\}\[\]]/.test(match)) {
                    cls = 'text-gray-500 font-bold'; // Warna untuk kurung kurawal
                }
                return `<span class="${cls}">${match}</span>`;
            }
        );
    }

    document.addEventListener("DOMContentLoaded", function () {
        const jsonDisplay = document.getElementById("json-display");
        const jsonContent = jsonDisplay.textContent;
        jsonDisplay.innerHTML = syntaxHighlight(jsonContent);
    });
</script>
@endpush
