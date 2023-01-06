<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vendor::select('id','name','mobile','email','country','city','address','contact_person','contact_no')->get();
    }
    public function headings(): array
    {
        return ["ID", "Name", "Phone", "Email","country","city","address","contact_person","contact_no"];
    }
}
