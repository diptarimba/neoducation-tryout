@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', $userTest->subject_test->name)
@section('sub-page-title', 'Test')


@section('content')
    <div class="col-span-12 lg:col-span-6">
        <div class="card dark:bg-zinc-800 dark:border-zinc-600">
            <div class="card-body pb-0">
                <h4 class="text-15 text-gray-700 dark:text-gray-100">Sisa Waktu : <span class="countdown"></span></h4>
            </div>
            <div>
                <div class="grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-6">
                        <div class="card-body">
                            <div>
                                <h5 class="text-sm text-gray-700 dark:text-gray-100"><span class="numbering"></span><i
                                        class="mdi mdi-arrow-right text-violet-500 mr-1"></i><span
                                        class="soal">Loading..</span></h5>
                                <form class="mt-5 radio-container">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid xl:grid-cols-4 p-2 gap-2">
                    <button type="button"
                        class="btn btn-previous hidden rounded-full text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600">Previous</button>
                    <button type="button"
                        class="btn btn-next hidden rounded-full text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600">Next</button>
                    <button type="button" onclick="submitTest()"
                        class="btn btn-submit rounded-full text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-footer')
    <script>
        function delay(time) {
            return new Promise(resolve => setTimeout(resolve, time));
        }
        let test_data = JSON.parse(@json($test_data));
        let savedAnswer = {};
        loadAnswerFromLocalstroage()

        function loadAnswerFromLocalstroage() {
            savedAnswer = localStorage.getItem(`savedAnswer[${test_data.test_id}]`);
            if (savedAnswer) {
                savedAnswer = JSON.parse(savedAnswer);
            } else {
                // Handle the case where there is no saved answer in localStorage
                savedAnswer = {}; // or set to a default value or structure as needed
            }
        }

        function submitApiAjax() {
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

        function submitTest() {
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
        function setAnswer(questionId, answerId) {
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
                success: function(response) {
                    console.log('Success:', response);
                    // Handle success response
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Handle error response
                }
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
            loadAnswerFromLocalstroage()
        }


        $(document).ready(async function() {


            function createRadioAnswer(state) {
                $('.numbering').text(state + 1 + '. ');
                $('.soal').text(question[state].question);
                let questionId = question[state].id;
                let keysAnswer = Object.keys(question[state].answer);
                const radioOptions = [];
                for (const key of keysAnswer) {
                    radioOptions.push({
                        id: key,
                        label: question[state].answer[key]
                    });
                }
                radioOptions.sort(() => Math.random() - 0.5);

                const radioContainer = document.querySelector('.radio-container');
                radioContainer.innerHTML = ''
                radioOptions.forEach((option, index) => {

                    const alphabet = 'abcdefghijklmnopqrstuvwxyz' [index % 26].toUpperCase();
                    const wrapperDiv = document.createElement('div');
                    wrapperDiv.className = 'flex items-center mb-4';

                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.name = 'default-radio';
                    input.className =
                        'ring-0 ring-offset-0 focus:bg-violet-500 dark:bg-zinc-700 dark:border-zinc-400 dark:checked:bg-violet-500';
                    input.id = option.id;
                    if (savedAnswer[questionId] == option.id) {
                        input.checked = true;
                    }

                    const label = document.createElement('label');
                    label.htmlFor = option.id;
                    label.className =
                        'ltr:ml-2 rtl:mr-2 text-sm font-medium text-gray-900 dark:text-gray-300';
                    label.textContent = `${alphabet}. ${option.label}`;
                    label.setAttribute('onClick',
                        `setAnswer(${questionId},${option.id})`
                    ); // Replace 'someFunction()' with the actual function to call on click

                    wrapperDiv.appendChild(input);
                    wrapperDiv.appendChild(label);

                    radioContainer.appendChild(wrapperDiv);
                });
            }

            let current_state_q = null;

            let endTime = moment(test_data.test_end_at);
            let currentTime = moment();
            let diffTime = endTime.diff(currentTime);
            let interval = 1000;

            setInterval(function() {
                diffTime = moment.duration(diffTime - interval, 'milliseconds');
                $('.countdown').text(
                    diffTime.hours().toString().padStart(2, '0') + ":" +
                    diffTime.minutes().toString().padStart(2, '0') + ":" +
                    diffTime.seconds().toString().padStart(2, '0')
                );
            }, interval);

            let question = test_data.test_question;


            current_state_q = 0;

            delay(1000).then(() => {
                createRadioAnswer(current_state_q)
            });

            if (question[current_state_q + 1] != undefined) {
                $('.btn-next').removeClass('hidden')
            }


            $('.btn-previous').on('click', function() {
                if (current_state_q > 0) {
                    current_state_q--;
                    createRadioAnswer(current_state_q)
                }
                if (current_state_q == 0) {
                    $('.btn-previous').addClass('hidden');
                }
                if (current_state_q == question.length - 2) {
                    $('.btn-next').removeClass('hidden');
                }
            });
            $('.btn-next').on('click', function() {
                if (current_state_q < question.length - 1) {
                    current_state_q++;
                    createRadioAnswer(current_state_q)
                }
                if (current_state_q > 0) {
                    $('.btn-previous').removeClass('hidden');
                }
                if (current_state_q == question.length - 1) {
                    $('.btn-next').addClass('hidden');
                }
            });


        })
    </script>
@endsection
