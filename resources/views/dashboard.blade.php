<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ============================= --}}
            {{-- MASTER DATA HEALTH INDICATOR --}}
            {{-- ============================= --}}
            @if(
                collect($health['inactive_used'])->sum() > 0 ||
                collect($health['orphan_refs'])->sum() > 0 ||
                collect($health['duplicate_actives'])->sum() > 0
            )
                <div class="border border-red-300 bg-red-50 text-red-800 rounded-lg p-4">
                    <strong class="block mb-2">
                        ⚠ Master Data Health Issue Detected
                    </strong>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($health['inactive_used'] as $k => $v)
                            @if ($v > 0)
                                <li>
                                    {{ ucfirst($k) }} inactive masih dipakai ({{ $v }})
                                </li>
                            @endif
                        @endforeach

                        @foreach ($health['orphan_refs'] as $k => $v)
                            @if ($v > 0)
                                <li>
                                    {{ ucfirst($k) }} orphan reference ({{ $v }})
                                </li>
                            @endif
                        @endforeach

                        @foreach ($health['duplicate_actives'] as $k => $v)
                            @if ($v > 0)
                                <li>
                                    {{ ucfirst($k) }} duplicate active ({{ $v }})
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ============================= --}}
            {{-- DEFAULT DASHBOARD CONTENT --}}
            {{-- ============================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
