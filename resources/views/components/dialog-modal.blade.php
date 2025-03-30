@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            {{ $title = "This" }}
        </div>

        <div class="mt-4 text-sm text-gray-600">
            {{ $content = "Is"}}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end">
        {{ $footer = "Sprata" }}
    </div>
</x-modal>
