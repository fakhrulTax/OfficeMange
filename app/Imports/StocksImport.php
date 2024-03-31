<?php

namespace App\Imports;

use App\Models\Stock;
use App\Models\Arrear;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use App\Helpers\MyHelper;


class StocksImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        ini_set('max_execution_time', 999999999999);

        $processedRows = []; // Keep track of processed rows

        foreach ($rows as $key => $row) 
        {

            $tin = $row[0];

            // Check if a record with the specified tin already exists
            $existingArrear = Arrear::where('tin', $tin)->first();
            
            if ($existingArrear) {
                // Log or dump the existing record for inspection
                \Log::info('Arrear record with TIN ' . $tin . ' already exists: ', $existingArrear->toArray());
            }
            
            // Attempt to update or create the Arrear record
            $arrear = Arrear::updateOrCreate(
                ['tin' => $tin],
                [
                    'arrear_type' => 'undisputed',
                    'demand_create_date' =>  date('Y-m-d', strtotime('01-07-2023')),
                    'assessment_year' => $row[1],
                    'arrear' => $row[2],
                    'fine' => $row[3],
                    'circle' => 14,
                    'comments' => null
                ]
            );
            
            if (!$arrear) {
                // Log the error
                \Log::error('Failed to create or update Arrear record for TIN: ' . $tin);
            }
            
            // Check if the record was created or updated
            if ($arrear->wasRecentlyCreated) {
                // Log or dump the created record for inspection
                \Log::info('Arrear record with TIN ' . $tin . ' was created: ', $arrear->toArray());
            } else {
                // Log or dump the updated record for inspection
                \Log::info('Arrear record with TIN ' . $tin . ' was updated: ', $arrear->toArray());
            }
            

        }

        dd('go');

        

        // foreach ($rows as $key => $row) {

        //     if (isset($processedRows[$key])) {
        //         continue; // Skip already processed rows
        //     }

        //     $rules = [
        //         '0' => 'required|string',
        //         '1' => 'required|numeric|digits:12',
        //         '2' => 'required|in:individual,firm,company',
        //         '3' => 'required|numeric|min:1|max:22',
        //     ];

        //     // Create Validator Instance
        //     $validator = Validator::make($row->toArray(), $rules);

        //     // Check if validation fails
        //     if ($validator->fails()) {
        //         foreach ($validator->errors()->all() as $error) {
        //             echo "<p>Row $key - $error</p>";
        //         }

        //         // Mark row as processed
        //         $processedRows[$key] = true;

        //         // Continue to the next row if validation fails
        //         continue;
        //     }

        //     // Create or update the record in the database
        //     $tin = $row[1];

        //     $stock = Stock::updateOrCreate(
        //         ['tin' => $tin],
        //         [
        //             'name' => $row[0],
        //             'sort_name' => MyHelper::sortName($row[0]), 
        //             'type' => $row[2],
        //             'circle' => $row[3],    
        //             'file_in_stock' => $row[4],
        //             'file_rack' => $row[5],                                    
        //             'bangla_name' => $row[6],
        //             'address' => $row[7],
        //             'last_return' => $row[8],
        //         ]
        //     );

        //     // Log a message for the row that was updated
        //     echo "<p>Row $key - TIN: $tin updated or created successfully</p>";

        //     // Mark row as processed
        //     $processedRows[$key] = true;
        // }
    }
}