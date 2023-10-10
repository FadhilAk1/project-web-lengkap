<?php

namespace App\Exports;

use App\Models\letterOut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LetterOutExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return letterOut::select("nomor", "tanggal", "perihal", "nomor_surat", "jumlah", "keterangan", "document_type")->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Nomor", "Tanggal", "Perihal", "Nomor_Surat", "Jumlah", "Keterangan", "Document_Type"];
    }
}
