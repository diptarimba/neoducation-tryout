@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', $userTest->subject_test->name)
@section('sub-page-title', 'Test')

@section('content')
    <div class="grid grid-cols-12 gap-4"  id="app">
        <div class="col-span-12 lg:col-span-9">
            <div class="card dark:bg-zinc-800 dark:border-zinc-600 mb-0">
                <div class="card-body">
                    <h4 class="text-15 text-gray-700 dark:text-gray-100 mb-6">Sisa Waktu : <span class="countdown"></span></h4>
                    <div v-for="(question, index) in test_data.test_question" :key="index">
                        <div v-show="isAnswer[index]">
                        <h5 class="mb-3">@{{ index + 1 }}. @{{ question.question }}</h5>
                        <img v-show="question.image" :src="question.image" class="mb-5 img-content w-full object-contain mx-auto rounded" style="max-height: 32rem; max-width: 45rem">
                        <form>
                            {{-- question answer --}}
                            <div v-for="(answer, index) in question.answer">
                                <label class="inline-flex items-center mb-3 ltr:ml-2 rtl:mr-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    <input :id="`${question.id}-${index}`" type="radio" class="ring-0 ring-offset-0 focus:bg-violet-500 dark:bg-zinc-700 dark:border-zinc-400 dark:checked:bg-violet-500" name="answer" :value="answer.id" @click="setAnswer(question.id, index)">
                                    <span class="ml-2">@{{ answer }}</span>
                                </label>
                            </div>
                            {{-- button action --}}
                            <div class="grid xl:grid-cols-4 p-2 gap-2 mt-5">
                                <button type="button"
                                    class="btn btn-previous  rounded-full text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600" @click="goToPrevious(index)" v-show="index > 0">Previous</button>
                                <button type="button"
                                    class="btn btn-next  rounded-full text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600" @click="goToNext(index)" v-show="index < test_data.test_question.length - 1">Next</button>
                                <button type="button" @click="submitTest()"
                                    class="btn btn-submit rounded-full text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-3">
        <div class="card max-h-56 overflow-y-scroll">
            <div class="card-body">
                <div class="grid grid-cols-5 gap-3">
                    <div v-for="(question, index) in test_data.test_question" :key="index">
                        <button class="border border-gray-600 text-gray-400 h-8 w-full rounded flex justify-center items-center" @click="goToQuestion(index)" :class="{ 'border-3 border-violet-500 font-bold text-violet-500': isAnswer[index], 'bg-violet-500 text-white border-violet-500': isSaved[index] }">
                            @{{ index + 1 }}
                        </button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('custom-footer')
<script src="https://unpkg.com/vue@3"></script>
<script>
    const { createApp, ref, onMounted } = Vue;

    createApp({
        setup() {
            const test_data = JSON.parse(@json($test_data));
            const isAnswer = ref(Array(test_data.test_question.length).fill(false));
            const isSaved = ref(Array(test_data.test_question.length).fill(false));
            isAnswer.value[0] = true;
            let savedAnswer = {};
            let question = test_data.test_question;  
            const answerData = ref([]);

            // button previous
            const goToPrevious = (index) => {
                isAnswer.value = isAnswer.value.map((value, idx) => idx === index - 1);
            }

            // button next
            const goToNext = (index) => {
                isAnswer.value = isAnswer.value.map((value, idx) => idx === index + 1);
            }

            const goToQuestion = (index) => {
                // Set semua nilai isAnswer ke false
                isAnswer.value = isAnswer.value.map((value, idx) => idx === index);
            };

            // load answer from local storage
            const loadAnswerFromLocalstroage = () => {
                savedAnswer = localStorage.getItem(`savedAnswer[${test_data.test_id}]`);
                if (savedAnswer) {
                    savedAnswer = JSON.parse(savedAnswer);

                    // mengecek apakah ada jawaban yang di save
                    const indexAnswer = Object.keys(savedAnswer);
                    isSaved.value = isSaved.value.map((value, idx) => {
                        if (indexAnswer.includes(question[idx].id)) {
                            return true;
                        } else {
                            return false;
                        }
                    });
                    
                    // set answer from local storage
                    test_data.test_question.forEach((question, index) => {
                        const answerId = savedAnswer[question.id];
                        if (answerId !== undefined) {
                            const input = document.getElementById(`${question.id}-${answerId}`);
                            if (input) {
                                input.checked = true;
                            }
                        }
                    });
                    
                } else {
                    savedAnswer = {}; // or set to a default value or structure as needed
                }
                
            }

            // Update countdown dan cek waktu habis
            const updateCountdown = () => {
                let endTime = moment(test_data.test_end_at);
                let currentTime = moment();
                let diffTime = endTime.diff(currentTime);
                let interval = 1000;

                const updateTimer = () => {
                    diffTime = moment.duration(diffTime - interval, 'milliseconds');
                    const hours = diffTime.hours().toString().padStart(2, '0');
                    const minutes = diffTime.minutes().toString().padStart(2, '0');
                    const seconds = diffTime.seconds().toString().padStart(2, '0');
                    document.querySelector('.countdown').textContent = `${hours}:${minutes}:${seconds}`;
                };

                // Memperbarui countdown setiap interval
                const timerInterval = setInterval(updateTimer, interval);

                // Menjalankan submitTest() jika waktu habis
                setTimeout(() => {
                    clearInterval(timerInterval);
                    submitTest();
                }, diffTime);
            };


            // submit test
            const submitTest = () => {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu tidak akan bisa kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: 'Yes, Submit!',
                    // confirmButtonClass: 'btn bg-green-500 border-green-500 text-white mt-2',
                    cancelButtonText: 'No, Cancel!',
                    // cancelButtonClass: 'btn bg-red-500 border-red-500 text-white ml-2 mt-2',
                    buttonsStyling: true
                }).then(function(result) {
                    if (result.value) {
                        Swal.fire({
                            title: 'Submited!',
                            text: 'Your test has been submited.',
                            icon: 'success',
                            confirmButtonColor: '#5156be',
                        })
                        delay(3000)
                        localStorage.removeItem(`savedAnswer[${test_data.test_id}]`)
                        submitApiAjax()
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire({
                            title: 'Kembali',
                            text: 'Silahkan melanjutkan! :)',
                            icon: 'error',
                            confirmButtonColor: '#5156be',
                        })
                    }
                });
            }

            // memilih jawaban dan di save di local storage
            const setAnswer = (questionId, answerId) => {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.test.end.store', $userTest->id) }}', // Replace with your server endpoint
                    data: JSON.stringify({
                        question_id: questionId,
                        answer_id: answerId
                    }),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    // success: function(response) {
                    //     console.log('Success:', response);
                    //     // Handle success response
                    // },
                    // error: function(xhr, status, error) {
                    //     console.error('Error:', error);
                    //     // Handle error response
                    // }
                });
                // menggabungkan jawaban
                savedAnswer = {
                    ...savedAnswer,
                    [questionId]: answerId
                };
                // merubahnya ke json
                let encodeAnswer = JSON.stringify(savedAnswer);
                // simpan ke local storage
                localStorage.setItem(`savedAnswer[${test_data.test_id}]`, encodeAnswer);
                loadAnswerFromLocalstroage();

                // mengecek apakah ada jawaban yang di save
                const indexAnswer = Object.keys(savedAnswer);
                isSaved.value = isSaved.value.map((value, idx) => {
                    if (indexAnswer.includes(question[idx].id)) {
                        return true;
                    } else {
                        return false;
                    }
                });
            }

            // submit api ajax
            const submitApiAjax = () => {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.test.end.store', $userTest->id) }}', // Replace with your server endpoint
                    data: JSON.stringify({
                        ended: true
                    }),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response)
                        window.location.href = "{{ route('user.test.index', $userTest->id) }}";
                    },
                    error: function(xhr, status, error) {
                        // console.log(error)
                        window.location.href = "{{ route('user.test.index', $userTest->id) }}";
                    }
                });
            }

            // delay
            const delay = (time) => {
                return new Promise(resolve => setTimeout(resolve, time));
            }

            onMounted(() => {
                updateCountdown();
                loadAnswerFromLocalstroage();
            });
            
            return {
                test_data,
                goToQuestion,
                isAnswer,
                isSaved,
                submitTest,
                setAnswer,
                loadAnswerFromLocalstroage,
                submitApiAjax,
                goToPrevious,
                goToNext,
                savedAnswer
            };
        }
    }).mount('#app');
</script>
@endsection
