<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Top 3 Cards --}}
        @if($topStudents->isNotEmpty())
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach($topStudents as $index => $student)
                    @php
                        $rank = $index + 1;
                        $bgCard = match ($rank) {
                            1 => 'bg-amber-50 border-amber-200 dark:bg-amber-900/20 dark:border-amber-700',
                            2 => 'bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700',
                            3 => 'bg-sky-50 border-sky-200 dark:bg-sky-900/20 dark:border-sky-700',
                        };
                        $icon = match ($rank) {
                            1 => '🏆',
                            2 => '🥈',
                            3 => '🥉',
                        };
                        $rankLabel = match ($rank) {
                            1 => 'text-amber-600 dark:text-amber-400',
                            2 => 'text-gray-500 dark:text-gray-400',
                            3 => 'text-sky-600 dark:text-sky-400',
                        };
                        $pointColor = match ($rank) {
                            1 => 'text-amber-700 dark:text-amber-300',
                            2 => 'text-gray-800 dark:text-gray-200',
                            3 => 'text-sky-700 dark:text-sky-300',
                        };
                    @endphp
                    <div class="rounded-xl border {{ $bgCard }} p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold uppercase tracking-widest {{ $rankLabel }}">
                                Peringkat #{{ $rank }}
                            </span>
                            <span class="text-xl">{{ $icon }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $student->name }}</h3>
                        <div class="mt-3 flex items-baseline gap-1">
                            <span
                                class="text-4xl font-black {{ $pointColor }}">{{ number_format($student->total_points) }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">poin</span>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            {{ $student->total_quizzes }} kuis · {{ round($student->avg_accuracy) }}% akurasi
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Full Leaderboard Table --}}
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Peringkat Lengkap</h2>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Peringkat</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Kuis</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Akurasi</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider text-right">Poin
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @php $allStudents = $topStudents->merge($otherStudents); @endphp
                    @forelse($allStudents as $index => $student)
                        @php
                            $rank = $index + 1;
                            $rankBg = match (true) {
                                $rank <= 3 => 'bg-gray-100 dark:bg-gray-700 font-bold text-gray-700 dark:text-gray-200',
                                default => 'bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex h-7 w-7 items-center justify-center rounded-full text-xs {{ $rankBg }}">
                                    {{ $rank }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $student->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $student->total_quizzes }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ round($student->avg_accuracy) }}%
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-900 dark:text-white">
                                {{ number_format($student->total_points) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <x-heroicon-o-trophy class="mx-auto h-8 w-8 text-gray-300" />
                                <p class="mt-3 text-sm font-medium text-gray-900 dark:text-white">Belum Ada Data</p>
                                <p class="mt-1 text-xs text-gray-500">Mulai kerjakan kuis untuk melihat namamu di sini!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-filament-panels::page>