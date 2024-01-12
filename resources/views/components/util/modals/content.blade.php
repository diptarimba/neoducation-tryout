@props(['title' => '', 'id' => '', 'center' => null, 'button' => null])
<div class="relative z-50 hidden modal" id="{{$id}}" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 transition-opacity bg-black bg-opacity-50"></div>
        <div class="flex items-end justify-center min-h-screen p-4 text-center animate-translate sm:items-center sm:p-0">
            <div
                class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl -top-10 sm:my-8 sm:w-full sm:max-w-lg dark:bg-zinc-700">
                <div class="p-5 text-center bg-white dark:bg-zinc-700">
                    <div class="mx-auto bg-green-100 rounded-full h-14 w-14">
                        <i class="mdi mdi-qrcode text-2xl text-green-600 leading-[2.4]"></i>
                    </div>
                    <h2 class="mt-5 text-xl text-gray-700 dark:text-gray-100">{{$title}}</h2>
                    @if (is_null($center))
                    <div class="justify-center flex">
                        {{$slot}}
                    </div>
                    @else
                    <div>
                        {{$slot}}
                    </div>
                    @endif
                    <div class="justify-center px-4 py-3 mt-5 border-gray-50 sm:flex sm:px-6">
                        <button type="button"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm btn dark:text-gray-100 hover:bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-gray-500/30 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-zinc-700 dark:border-zinc-600 dark:hover:bg-zinc-600 dark:focus:bg-zinc-600 dark:focus:ring-zinc-700 dark:focus:ring-gray-500/20"
                            data-tw-dismiss="modal">Cancel</button>
                        {{$button}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
