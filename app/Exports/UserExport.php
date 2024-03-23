<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UserExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct(
        public $search = null,
        public $start_date = null,
        public $end_date = null,
        public $counter = 0)
    {
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $search = $this->search;
        return User::role('user')->where(function($query) use ($search){
            $query->when($this->start_date !== null, function ($query) {
                return $query->where('created_at', '>=', $this->start_date);
            })->when($this->end_date !== null, function ($query) {
                return $query->where('created_at', '<=', $this->end_date);
            })->when($search !== null, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(school) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            });
        })->get();
    }

    public function map($user): array
    {
        $time = Carbon::parse($user->created_at);
        return [
            ++$this->counter,
            $user->name,
            $user->phone,
            $user->school,
            $time->format("d M Y H:i:s a") . " ({$time->diffForHumans()})",
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Phone',
            'School',
            'Registered At',
        ];
    }
}
