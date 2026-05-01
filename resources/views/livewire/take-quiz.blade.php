<div class="space-y-6">
    @if(!$isFinished)
        <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $quiz->title }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Soal {{ $currentQuestionIndex + 1 }} dari {{ count($questions) }}</p>
            </div>
            <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg font-mono font-bold dark:bg-indigo-900/30 dark:text-indigo-400">
                {{ $quiz->duration }} Menit
            </div>
        </div>

        <div class="relative overflow-hidden bg-white border border-gray-200 rounded-2xl shadow-lg dark:bg-gray-800 dark:border-gray-700">
            <div class="absolute top-0 left-0 w-full h-1 bg-gray-100 dark:bg-gray-700">
                <div class="h-full bg-indigo-600 transition-all duration-500" style="width: {{ (($currentQuestionIndex + 1) / count($questions)) * 100 }}%"></div>
            </div>

            <div class="p-8">
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white leading-relaxed">
                        {{ $questions[$currentQuestionIndex]->question_text }}
                    </h3>
                </div>

                <div class="grid gap-4">
                    @foreach(['A', 'B', 'C', 'D'] as $option)
                        @php $optionField = 'option_' . strtolower($option); @endphp
                        <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ $answers[$currentQuestionIndex] === $option ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 dark:border-indigo-500' : 'border-gray-100 dark:border-gray-700' }}">
                            <input type="radio" wire:model="answers.{{ $currentQuestionIndex }}" value="{{ $option }}" class="hidden">
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg text-lg font-bold mr-4 {{ $answers[$currentQuestionIndex] === $option ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                {{ $option }}
                            </span>
                            <span class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                {{ $questions[$currentQuestionIndex]->$optionField }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-between dark:bg-gray-800/50 dark:border-gray-700">
                <button 
                    wire:click="previousQuestion" 
                    @if($currentQuestionIndex === 0) disabled @endif
                    class="px-6 py-2.5 rounded-xl font-semibold text-gray-600 bg-white border border-gray-200 shadow-sm hover:bg-gray-50 disabled:opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700"
                >
                    Sebelumnya
                </button>

                @if($currentQuestionIndex === count($questions) - 1)
                    <button 
                        wire:click="submitQuiz"
                        class="px-8 py-2.5 rounded-xl font-bold text-white bg-green-600 hover:bg-green-700 shadow-lg shadow-green-200 dark:shadow-none transition-all active:scale-95"
                    >
                        Selesaikan Kuis
                    </button>
                @else
                    <button 
                        wire:click="nextQuestion"
                        class="px-8 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 dark:shadow-none transition-all active:scale-95"
                    >
                        Berikutnya
                    </button>
                @endif
            </div>
        </div>
    @else
        <div class="text-center p-12 bg-white border border-gray-200 rounded-3xl shadow-xl dark:bg-gray-800 dark:border-gray-700">
            <div class="inline-flex items-center justify-center w-24 h-24 mb-8 bg-green-100 rounded-full dark:bg-green-900/30">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Kuis Selesai!</h2>
            <p class="text-xl text-gray-500 dark:text-gray-400 mb-12">Terima kasih telah mengerjakan kuis <strong>{{ $quiz->title }}</strong>.</p>

            <div class="grid grid-cols-2 gap-8 max-w-md mx-auto mb-12">
                <div class="p-6 bg-gray-50 rounded-2xl dark:bg-gray-700/50">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-bold mb-1">Skor Akhir</p>
                    <p class="text-4xl font-black text-indigo-600">{{ round($score) }}</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-2xl dark:bg-gray-700/50">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-bold mb-1">Akurasi</p>
                    <p class="text-4xl font-black text-green-600">{{ round($accuracy) }}%</p>
                </div>
            </div>

            <a href="{{ \App\Filament\Siswa\Resources\QuizResource::getUrl('index') }}" class="inline-flex items-center px-8 py-4 text-lg font-bold text-white bg-indigo-600 rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 dark:shadow-none">
                Kembali ke Daftar Kuis
            </a>
        </div>
    @endif
</div>
