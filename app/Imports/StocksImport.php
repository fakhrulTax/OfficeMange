<?php

namespace App\Imports;

use App\Models\Stock;
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

        foreach ($rows as $key => $row) {

            if (isset($processedRows[$key])) {
                continue; // Skip already processed rows
            }

            $rules = [
                '0' => 'required|string',
                '1' => 'required|numeric|digits:12',
                '2' => 'required|in:individual,firm,company',
                '3' => 'required|numeric|min:1|max:22',
            ];

            // Create Validator Instance
            $validator = Validator::make($row->toArray(), $rules);

            // Check if validation fails
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    echo "<p>Row $key - $error</p>";
                }

                // Mark row as processed
                $processedRows[$key] = true;

                // Continue to the next row if validation fails
                continue;
            }

            // Create or update the record in the database
            $tin = $row[1];

            $stock = Stock::updateOrCreate(
                ['tin' => $tin],
                [
                    'name' => $row[0],
                    'sort_name' => MyHelper::sortName($row[0]), 
                    'type' => $row[2],
                    'circle' => $row[3],
                ]
            );

            // Log a message for the row that was updated
            echo "<p>Row $key - TIN: $tin updated or created successfully</p>";

            // Mark row as processed
            $processedRows[$key] = true;
        }
    }
}