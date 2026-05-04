<div class="w-full max-w-3xl mx-auto space-y-6">

    @if(!$isFinished)

        {{-- Header --}}
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $quiz->title }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Soal {{ $currentQuestionIndex + 1 }} dari {{ count($questions) }} &middot; {{ $quiz->duration }}
                        Menit
                    </p>
                </div>
                <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ round((($currentQuestionIndex + 1) / count($questions)) * 100) }}%
                </span>
            </div>
            {{-- Progress Bar --}}
            <div class="mt-4 h-2 w-full rounded-full bg-gray-100 dark:bg-gray-800">
                <div class="h-full rounded-full bg-indigo-500 transition-all duration-500"
                    style="width: {{ (($currentQuestionIndex + 1) / count($questions)) * 100 }}%"></div>
            </div>
        </div>

        {{-- Question Card --}}
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="p-6 md:p-8">

                {{-- Question Label --}}
                <span
                    class="inline-block px-3 py-1 mb-4 text-[11px] font-bold uppercase tracking-widest text-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 dark:text-indigo-400 rounded-full">
                    Pertanyaan {{ $currentQuestionIndex + 1 }}
                </span>

                {{-- Question Text --}}
                <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-snug mb-6">
                    {{ $questions[$currentQuestionIndex]->question_text }}
                </h3>

                {{-- Options --}}
                <div class="space-y-3">
                    @foreach(['A', 'B', 'C', 'D'] as $option)
                            @php $optionField = 'option_' . strtolower($option); @endphp
                            <label wire:key="q-{{ $currentQuestionIndex }}-{{ $option }}" class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all duration-200
                                                                                                                                            {{ $answers[$currentQuestionIndex] === $option
                        ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 dark:border-indigo-500'
                        : 'border-gray-100 dark:border-gray-800 hover:border-gray-300 dark:hover:border-gray-600' }}">
                                <input type="radio" wire:model.live="answers.{{ $currentQuestionIndex }}" value="{{ $option }}"
                                    class="hidden">

                                <div class="flex items-center justify-center w-9 h-9 rounded-lg text-sm font-bold flex-shrink-0 transition-all duration-200
                                                                                                                                            {{ $answers[$currentQuestionIndex] === $option
                        ? 'bg-indigo-600 text-white'
                        : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                    {{ $option }}
                                </div>

                                <span
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300
                                                                                                                                            {{ $answers[$currentQuestionIndex] === $option ? 'text-indigo-900 dark:text-indigo-200' : '' }}">
                                    {{ $questions[$currentQuestionIndex]->$optionField }}
                                </span>

                                @if($answers[$currentQuestionIndex] === $option)
                                    <div class="ml-auto text-indigo-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </label>
                    @endforeach
                </div>
            </div>

            {{-- Footer Actions --}}
            <div
                class="px-6 md:px-8 py-5 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center gap-4">

                <button wire:click="previousQuestion" type="button" @if($currentQuestionIndex === 0) disabled @endif
                    class="px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Sebelumnya
                </button>

                @if($currentQuestionIndex === count($questions) - 1)
                    <button wire:click="submitQuiz" wire:loading.attr="disabled" type="button"
                        style="background-color: rgb(5, 150, 105);"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white transition-all flex items-center gap-2 hover:opacity-90">
                        <span wire:loading.remove>Selesaikan Kuis</span>
                        <span wire:loading>Memproses...</span>
                        <svg wire:loading class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                @else
                    <button wire:click="nextQuestion" type="button" style="background-color: rgb(79, 70, 229);"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold text-white transition-all flex items-center gap-2 hover:opacity-90">
                        Berikutnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>

    @else

        {{-- Results --}}
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900 p-10 text-center mb-4">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-full mb-6">
                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Kuis Selesai!</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">
                Kamu telah menyelesaikan kuis <span
                    class="font-semibold text-gray-700 dark:text-gray-300">{{ $quiz->title }}</span>
            </p>

            <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto mb-8">
                <div class="rounded-xl bg-indigo-50 dark:bg-indigo-900/20 p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-500 mb-1">Skor Akhir</p>
                    <p class="text-4xl font-black text-indigo-700 dark:text-indigo-300">{{ round($score) }}</p>
                </div>
                <div class="rounded-xl bg-emerald-50 dark:bg-emerald-900/20 p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-500 mb-1">Akurasi</p>
                    <p class="text-4xl font-black text-emerald-700 dark:text-emerald-300">{{ round($accuracy) }}%</p>
                </div>
            </div>

            <a href="{{ \App\Filament\Siswa\Resources\QuizResource::getUrl('index') }}"
                style="background-color: rgb(79, 70, 229);"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg text-sm font-bold text-white transition-all hover:opacity-90 mb-4">
                Kembali ke Daftar Kuis
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

    @endif

</div>