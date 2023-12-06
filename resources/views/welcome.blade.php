<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Neoducation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta content="Tailwind Admin & Dashboard Template" name="description" />
    <meta content="" name="Themesbrand" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />


    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}" />



</head>

<body data-mode="light" data-sidebar-size="lg">



    <div class="container-fluid">
        <div class="h-screen md:overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-12 ">
                <div class="col-span-12 md:col-span-5 lg:col-span-4 xl:col-span-3 relative z-50">
                    <div class="w-full bg-white xl:p-12 p-10 dark:bg-zinc-800">
                        <div class="flex h-[90vh] flex-col">
                            <div class="mx-auto">
                                <a href="/" class="">
                                    <span
                                        class="text-xl align-middle font-medium ltr:ml-2 rtl:mr-2 dark:text-white">Neoducation</span>
                                </a>
                            </div>

                            <div class="my-auto">
                                <div class="text-center">
                                    <h5 class="text-gray-600 dark:text-gray-100">Register Participant</h5>
                                    <p class="text-gray-500 mt-1 dark:text-zinc-100/60">Get your try out account now.
                                    </p>
                                </div>

                                <form class="mt-4 pt-2" action="{{ route('users.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label
                                            class="text-gray-600 font-medium mb-2 block dark:text-gray-100">Nama</label>
                                        <input type="text"
                                            class="w-full border-gray-100 rounded placeholder:text-sm py-2 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60"
                                            id="name" name="name" placeholder="Enter Name">
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-gray-600 font-medium mb-2 block dark:text-gray-100">Nomor
                                            Hp</label>
                                        <input type="text"
                                            class="w-full border-gray-100 rounded placeholder:text-sm py-2 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60"
                                            id="phone" name="phone" placeholder="Enter Phone Number">
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-gray-600 font-medium mb-2 block dark:text-gray-100">Tanggal
                                            lahir</label>
                                        <input type="date"
                                            class="w-full border-gray-100 rounded placeholder:text-sm py-2 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60"
                                            id="dob" name="dob" placeholder="Enter Date Of Birth">
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-gray-600 font-medium mb-2 block dark:text-gray-100">Asal
                                            Sekolah</label>
                                        <input type="text"
                                            class="w-full border-gray-100 rounded placeholder:text-sm py-2 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60"
                                            id="school" name="school" placeholder="Enter username">
                                    </div>
                                    <div class="mb-4">
                                        <label
                                            class="text-gray-600 font-medium mb-2 block dark:text-gray-100">Username</label>
                                        <input type="text"
                                            class="w-full border-gray-100 rounded placeholder:text-sm py-2 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60"
                                            id="username" name="username" placeholder="Enter Username baru ">
                                    </div>
                                    <div class="mb-3">
                                        <div>
                                            <div class="flex-grow-1">
                                                <label
                                                    class="text-gray-600 font-medium mb-2 block dark:text-gray-100">Password</label>
                                            </div>
                                        </div>

                                        <div class="flex">
                                            <input type="password"
                                                class="w-full border-gray-100 rounded ltr:rounded-r-none rtl:rounded-l-none placeholder:text-sm py-2 dark:bg-zinc-700/50 dark:border-zinc-600 dark:text-gray-100 dark:placeholder:text-zinc-100/60"
                                                placeholder="Enter password" aria-label="Password" name="password"
                                                aria-describedby="password-addon">
                                            <button
                                                class="bg-gray-50 px-4 rounded ltr:rounded-l-none rtl:rounded-r-none border border-gray-100 ltr:border-l-0 rtl:border-r-0 dark:bg-zinc-700 dark:border-zinc-600 dark:text-gray-100"
                                                type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-6">
                                        <div class="col">
                                            <div>
                                                <p class="text-gray-600 dark:text-zinc-100/60">By registering you agree
                                                    to the Neoducation <a href="#" class="text-violet-500">Terms of
                                                        Use</a></p>
                                            </div>
                                        </div>

                                    </div> --}}
                                    <div class="mb-3">
                                        <button
                                            class="btn border-transparent bg-violet-500 w-full py-2.5 text-white w-100 waves-effect waves-light shadow-md shadow-violet-200 dark:shadow-zinc-600"
                                            type="submit">Register</button>
                                    </div>
                                </form>

                                {{-- <div class="mt-4 pt-2 text-center">
                                    <div>
                                        <h6 class="text-14 mb-3 text-gray-500 font-medium dark:text-zinc-100/60">- Sign
                                            in with -</h6>
                                    </div>

                                    <div class="flex justify-center gap-3">
                                        <a href="" class="h-9 w-9 bg-violet-500 leading-[2.9] rounded-full">
                                            <i class="mdi mdi-facebook text-lg text-white"></i>
                                        </a>
                                        <a href="" class="h-9 w-9 bg-sky-500 leading-[2.9] rounded-full">
                                            <i class="mdi mdi-twitter text-lg text-white"></i>
                                        </a>
                                        <a href="" class="h-9 w-9 bg-red-400 leading-[2.9] rounded-full">
                                            <i class="mdi mdi-google text-lg text-white"></i>
                                        </a>
                                    </div>
                                </div> --}}

                                {{-- <div class="mt-12 text-center">
                                    <p class="text-gray-500 dark:text-zinc-100/60">You have an account ? <a
                                            href="login.html" class="text-violet-500 font-semibold"> Login </a> </p>
                                </div> --}}
                            </div>


                            <div class=" text-center">
                                <p class="text-gray-500 relative mb-5 dark:text-gray-100">©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> Neoducation . Crafted with <i
                                        class="mdi mdi-heart text-red-400"></i> by Dipta
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-7 lg:col-span-8 xl:col-span-9">
                    <div class="h-screen bg-cover relative p-5 bg-[url('../images/auth-bg.jpg')]">
                        <div class="absolute inset-0 bg-violet-500/90"></div>

                        <ul class="bg-bubbles absolute top-0 left-0 w-full h-full overflow-hidden animate-square">
                            <li class="h-10 w-10 rounded-3xl bg-white/10 absolute left-[10%] "></li>
                            <li class="h-28 w-28 rounded-3xl bg-white/10 absolute left-[20%]"></li>
                            <li class="h-10 w-10 rounded-3xl bg-white/10 absolute left-[25%]"></li>
                            <li class="h-20 w-20 rounded-3xl bg-white/10 absolute left-[40%]"></li>
                            <li class="h-24 w-24 rounded-3xl bg-white/10 absolute left-[70%]"></li>
                            <li class="h-32 w-32 rounded-3xl bg-white/10 absolute left-[70%]"></li>
                            <li class="h-36 w-36 rounded-3xl bg-white/10 absolute left-[32%]"></li>
                            <li class="h-20 w-20 rounded-3xl bg-white/10 absolute left-[55%]"></li>
                            <li class="h-12 w-12 rounded-3xl bg-white/10 absolute left-[25%]"></li>
                            <li class="h-36 w-36 rounded-3xl bg-white/10 absolute left-[90%]"></li>
                        </ul>

                        <div class="grid grid-cols-12 content-center h-screen">
                            <div class="col-span-8 col-start-3">
                                <div class="swiper login-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <i class="bx bxs-quote-alt-left text-green-600 text-5xl"></i>
                                            <h3 class="mt-4 text-white text-22">“Saya datang, saya lihat, saya menang”</h3>
                                            <div class="flex mt-6 mb-10 pt-4">
                                                <img src="{{ asset('assets/images/julius-caesar-20220304-162003.jpg') }}"
                                                    class="h-12 w-12 rounded-full" alt="...">
                                                <div class="flex-1 ltr:ml-3 rtl:mr-3 mb-4">
                                                    <h5 class="font-size-18 text-white">Julius Caesar</h5>
                                                    <p class="mb-0 text-white/50">-
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <i class="bx bxs-quote-alt-left text-green-600 text-5xl"></i>
                                            <h3 class="mt-4 text-white text-22">“Jangan menunggu peluang, buatlah sendiri.”</h3>
                                            <div class="flex mt-6 mb-10 pt-4">
                                                <img src="{{ asset('assets/images/bradley-whitford-e43bc8bc777f4facb229597eaefd038d.jpg') }}"
                                                    class="h-12 w-12 rounded-full" alt="...">
                                                <div class="flex-1 ltr:ml-3 rtl:mr-3 mb-4">
                                                    <h5 class="font-size-18 text-white">Bradley Whitford</h5>
                                                    <p class="mb-0 text-white/50">-
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <i class="bx bxs-quote-alt-left text-green-600 text-5xl"></i>
                                            <h3 class="mt-4 text-white text-22">“Hidup ini seperti bersepeda, untuk menjaga keseimbangan, Anda harus terus bergerak.”</h3>
                                            <div class="flex mt-6 mb-10 pt-4">
                                                <img src="{{ asset('assets/images/albert.jpg') }}"
                                                    class="h-12 w-12 rounded-full" alt="...">
                                                <div class="flex-1 ltr:ml-3 rtl:mr-3 mb-4">
                                                    <h5 class="font-size-18 text-white">Albert Einstein</h5>
                                                    <p class="mb-0 text-white/50">-
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="fixed ltr:right-5 rtl:left-5 bottom-10 flex flex-col gap-3 z-40 animate-bounce">
        <!-- light-dark mode button -->
        <a href="javascript: void(0);" id="ltr-rtl"
            class="px-3.5 py-4 z-40 text-14 transition-all duration-300 ease-linear text-white bg-violet-500 hover:bg-violet-600 rounded-full font-medium"
            onclick="changeMode(event)">
            <span class="ltr:hidden">LTR</span>
            <span class="rtl:hidden">RTL</span>
        </a>
    </div> --}}

    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/login.init.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }
            $('form').submit(function(event) {
                event.preventDefault();

                // Send a POST request to the server
                $.ajax({
                    url: "{{ route('users.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        // Show SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful',
                            text: 'Thank you for registering!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(function() {
                            window.location.href = "https://temubakat.com/id/";
                        }, 2000);
                    },
                    error: function(error) {
                        var err = JSON.parse(error.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed : ' + err.message,
                            text: 'An error occurred while registering. Please try again.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
