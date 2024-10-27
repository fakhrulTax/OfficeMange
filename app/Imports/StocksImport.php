<?php



namespace App\Imports;


use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Retarn;

use App\Models\Arrear;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Validator;

use App\Helpers\MyHelper;

use Carbon\Carbon;


class StocksImport implements ToCollection

{

    // public function collection(Collection $rows)

    // {

    //     ini_set('max_execution_time', 999999999999);

    //     ini_set('memory_limit', 9999999999);



    //     foreach ($rows as $key => $row) {

            

    //         $stock = Stock::where('tin', $row[0])->first();

    //         if(!$stock)

    //         {

    //             continue;

    //         }



    //       $arrear = Arrear::where('tin', $row[0])->where('assessment_year', $row[1])->first();

           

    //       if( $arrear )

    //       {

    //             continue;

    //       }

           

         

           

    //       $arrear = new Arrear();

    //       $arrear->tin = $row[0];

    //       $arrear->arrear_type = 'undisputed';

    //       $arrear->demand_create_date = '2023-07-01';

    //       $arrear->assessment_year = $row[1];

    //       $arrear->arrear = $row[2];

    //       $arrear->fine = $row[3];

    //       $arrear->circle = 14;

    //       $arrear->save();

           

           

           

            

    //     }

    // }

    

    

    // public function collection(Collection $rows)

    // {

    //     ini_set('max_execution_time', 999999999999);

    //     ini_set('memory_limit', 9999999999);



    //     $processedRows = []; // Keep track of processed rows



    //     foreach ($rows as $key => $row) {



    //         if (isset($processedRows[$key])) {

    //             continue; // Skip already processed rows

    //         }



    //         $rules = [

    //             '0' => 'required|string',

    //             '1' => 'required|numeric|digits:12',

    //             '2' => 'required|in:individual,firm,company',

    //             '3' => 'required|numeric|min:1|max:22',

    //         ];



    //         // Create Validator Instance

    //         $validator = Validator::make($row->toArray(), $rules);



    //         // Check if validation fails

    //         if ($validator->fails()) {

    //             foreach ($validator->errors()->all() as $error) {

    //                 echo "<p>Row $key - $error</p>";

    //             }



    //             // Mark row as processed

    //             $processedRows[$key] = true;



    //             // Continue to the next row if validation fails

    //             continue;

    //         }



    //         // Create or update the record in the database

    //         $tin = $row[1];



    //         $stock = Stock::updateOrCreate(

    //             ['tin' => $tin],

    //             [

    //                 'name' => $row[0],

    //                 'sort_name' => MyHelper::sortName($row[0]), 

    //                 'type' => $row[2],

    //                 'circle' => $row[3],    

    //                 'file_in_stock' => $row[4],

    //                 'file_rack' => $row[5],                                    

    //                 'bangla_name' => $row[6],

    //                 'address' => $row[7],

    //                 'last_return' => $row[8],

    //             ]

    //         );



    //         // Log a message for the row that was updated

    //         echo "<p>Row $key - TIN: $tin updated or created successfully</p>";



    //         // Mark row as processed

    //         $processedRows[$key] = true;

    //     }

    // }



    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                // Skip the header row
                continue;
            }
    
            $stock = Stock::where('tin', $row[2])->first();
    
            if (!$stock) {
                echo 'TIN not found for row ' . $key . '<br>';
                continue;
            }
    
            $data = [
                'register' => 'a',
                'return_submission_date' => $row[0],
                'register_serial' =>  $row[1] ?? null,
                'tin' => $row[2] ?? null,
                'name' => $stock->name,
                'assessment_year' => $row[3] ?? null,
                'source_of_income' => $row[4] ?? null,
                'income' => $row[5] ?? null,
                'income_of_poultry_fisheries' => null,
                'income_of_remittance' => $row[6] ?? null,
                'source_tax' => $row[8] ?? null,
                'advance_tax' => $row[9] ?? null,
                'retarn_tax' => $row[10] ?? null,
                'late_fee' => $row[11] ?? null,
                'sercharge' => $row[12] ?? null,
                'total_tax' => $row[13] ?? null,
                'liabilities' => $row[14] ?? null,
                'net_asset' => $row[15] ?? null,
                'tax_of_schedule_one' => null,
                'special_tax' => $row[7] ?? null,
                'special_invest' => null,
                'comments' => null,
                'circle' => 14,
            ];
    
            $data['return_submission_date'] = Carbon::createFromFormat('Y-m-d', $data['return_submission_date'])->format('Y-m-d');
            
            $validator = Validator::make($data, [
                'assessment_year' => 'required|integer|digits:8',
                'register' => 'required|string',
                'return_submission_date' => 'required|date',
                'register_serial' => 'required|integer',
                'tin' => 'required|integer|digits:12',
                'source_of_income' => 'nullable|string',
                'income' => 'required|integer',
                'income_of_poultry_fisheries' => 'nullable|integer',
                'income_of_remittance' => 'nullable|integer',
                'source_tax' => 'nullable|integer',
                'advance_tax' => 'nullable|integer',
                'retarn_tax' => 'nullable|integer',
                'late_fee' => 'nullable|integer',
                'sercharge' => 'nullable|integer',
                'total_tax' => 'nullable|integer',
                'liabilities' => 'nullable|integer',
                'net_asset' => 'required|integer',
                'comments' => 'nullable|string',
                'tax_of_schedule_one' => 'nullable|integer',
                'special_tax' => 'nullable|integer',
                'special_invest' => 'nullable|integer',
            ]);
    
            if ($validator->fails()) {
                echo 'Validation failed for row ' . $key . ': ' . implode(', ', $validator->errors()->all()) . '<br>';
                continue;
            }
    
            try {
                $retarn = new Retarn($data);
                $retarn->save();
                echo 'Saved row ' . $key . '<br>';
            } catch (\Exception $e) {
                echo 'Error saving row ' . $key . ': ' . $e->getMessage() . '<br>';
            }
        }
    
        echo 'Process completed';
    }
    



    

}