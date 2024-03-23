@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', $data['title'])
@section('sub-page-title', 'Index')


@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <table class="text-sm text-left text-gray-500 ">
                <thead class="text-sm text-gray-700 dark:text-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Parameter
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nilai
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b border-gray-50 dark:bg-zinc-700 dark:border-zinc-600">
                        <th scope="row"
                            class="px-6 py-3.5 font-medium text-gray-900 whitespace-nowrap dark:text-zinc-100">
                            Nama Test
                        </th>
                        <td class="px-6 py-3.5 dark:text-zinc-100">
                            {{ $userTest->subject_test->name }}
                        </td>
                    </tr>
                    <tr class="bg-white border-b border-gray-50 dark:bg-zinc-700 dark:border-zinc-600">
                        <th scope="row"
                            class="px-6 py-3.5 font-medium text-gray-900 whitespace-nowrap dark:text-zinc-100">
                            Waktu Pengerjaan
                        </th>
                        <td class="px-6 py-3.5 dark:text-zinc-100">
                            {{ $waktu }}
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-zinc-700 dark:border-zinc-600">
                        <th scope="row"
                            class="px-6 py-3.5 font-medium text-gray-900 whitespace-nowrap dark:text-zinc-100">
                            Jumlah Soal
                        </th>
                        <td class="px-6 py-3.5 dark:text-zinc-100">
                            {{ $countSoal }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <x-util.card title="Syarat dan Ketentuan Sebelum Mulai">
                <ul class="list-disc pl-0">
                    <li class="mb-2"><strong class="font-semibold">Siapkan Perangkat:</strong> Pastikan koneksi internet stabil dan perangkat siap pakai.</li>
                    <li class="mb-2"><strong class="font-semibold">Cek Browser:</strong> Gunakan browser terbaru yang direkomendasikan.</li>
                    <li class="mb-2"><strong class="font-semibold">Login Tepat Waktu:</strong> Masuk sesuai jadwal yang ditentukan.</li>
                    <li class="mb-2"><strong class="font-semibold">Baca Petunjuk:</strong> Perhatikan petunjuk pengerjaan dan waktu pengerjaan.</li>
                    <li class="mb-2"><strong class="font-semibold">Jangan Buka Tab Lain:</strong> Fokus pada try out, hindari membuka aplikasi atau tab lain.</li>
                    <li class="mb-2"><strong class="font-semibold">Siapkan Kertas Kerja:</strong> Gunakan untuk perhitungan atau catatan.</li>
                    <li class="mb-2"><strong class="font-semibold">Kerjakan Mandiri:</strong> Hindari bantuan orang lain atau sumber tidak diizinkan.</li>
                    <li class="mb-2"><strong class="font-semibold">Jaga Waktu:</strong> Bagi waktu dengan bijak untuk setiap soal.</li>
                    <li class="mb-2"><strong class="font-semibold">Simpan Jawaban Berkala:</strong> Pastikan jawaban tersimpan untuk menghindari kehilangan data.</li>
                </ul>
            </x-util.card>
            <x-button.submit label="Mulai Test" />
        </x-form.base>
    </x-util.card>
@endsection
