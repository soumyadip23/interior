<?php

namespace App\Imports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;


class VendorsImport implements ToModel,WithStartRow,WithValidation,SkipsOnError
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Vendor([
            'name'     => $row[1],
            'email'    => $row[2],
            'password' => '',
            'mobile'   => $row[3],
            'otp'   => 1234,
            'country'   => $row[4],
            'city'   => $row[5],
            'address'   => $row[6],
            'contact_person'   => $row[7],
            'contact_no'   => $row[8],
            'device_id'   => '',
            'device_token'   => '',
            'is_verified'   => 1,
            'status'   => 1,
            'is_deleted'   => 0,
 
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
    public function rules(): array
    {
        return ['*.mobile' => ['mobile','unique:vendors.mobile']];
    }
    public function onError(Throwable $error)
    {
        
    }

}
