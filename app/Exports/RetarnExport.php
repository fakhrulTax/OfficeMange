<?php
namespace App\Exports;

use App\Models\Retarn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class RetarnExport implements FromCollection, WithHeadings
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        $retarns = Retarn::where($this->query)->orderby('register', 'ASC')->orderby('register_serial', 'ASC')->get();

        // Modify the dates to the desired format
        $retarns->transform(function ($retarn) {
            $retarn->return_submission_date = Carbon::parse($retarn->return_submission_date)->format('d-m-Y');
            return $retarn;
        });

        return $retarns;
    }

    public function headings(): array
    {
        // Define your column headers
        return [
            'ID',
            'Rgister',
            'Date',
            'Register Serial',
            'TIN',
            'Name',
            'ASS. Year',
            'source_of_income',
            'income',
            'income_of_poultry_fisheries',
            'income_of_remittance',
            'tax_of_schedule_one',
            'special_tax',
            'special_invest',
            'source_tax',
            'advance_tax',
            'return_tax',
            'late_fee',
            'sercharge',
            'total_tax',
            'liabilities',
            'net_asset',
            'comments',
            'circle',
            'created_at',
            'updated_at',
        ];
    }
}
