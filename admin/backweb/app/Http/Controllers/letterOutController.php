<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LetterOutExport;
use App\Models\letterOut;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class letterOutController extends Controller
{
    public function storeContract(Request $request)
    {
        // Validasi data yang diterima dari frontend
        $validatedData = $request->validate([
            'nomor' => 'required',
            'tanggal' => 'required',
            'perihal' => 'required',
            'nomor_surat' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'file' => 'required|file|mimes:pdf,docx', // Contoh validasi untuk file PDF dan DOCX
        ]);

        // Simpan data ke dalam database menggunakan model Letter
        $surat = new letterout($validatedData);

        // Simpan file ke dalam storage jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Ganti ini
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets'), $filename); // Pindahkan file ke direktori 'public/assets'
            $surat->file = $filename;
        }

        $surat->document_type = 'Contract';

        // Simpan data ke dalam database
        $surat->save();

        // Response sukses
        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }

    public function storeJustification(Request $request)
    {
        // Validasi data yang diterima dari frontend
        $validatedData = $request->validate([
            'nomor' => 'required',
            'tanggal' => 'required',
            'perihal' => 'required',
            'nomor_surat' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
            'file' => 'required|file|mimes:pdf,docx', // Contoh validasi untuk file PDF dan DOCX
        ]);

        // Simpan data ke dalam database menggunakan model Letter
        $surat = new letterout($validatedData);

        // Simpan file ke dalam storage jika ada
        // Simpan file ke dalam storage jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Ganti ini
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets'), $filename); // Pindahkan file ke direktori 'public/assets'
            $surat->file = $filename;
        }

        $surat->document_type = 'Justification';

        // Simpan data ke dalam database
        $surat->save();

        // Response sukses
        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }

    public function storeAuthority(Request $request)
    {
        // Validasi data yang diterima dari frontend
        $validatedData = $request->validate([
            'nomor' => 'required',
            'tanggal' => 'required',
            'perihal' => 'required',
            'nomor_surat' => 'required',
            'keterangan' => 'required',
            'file' => 'required|file|mimes:pdf,docx', // Contoh validasi untuk file PDF dan DOCX
        ]);

        // Simpan data ke dalam database menggunakan model Letter
        $surat = new letterout($validatedData);

        // Simpan file ke dalam storage jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Ganti ini
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets'), $filename); // Pindahkan file ke direktori 'public/assets'
            $surat->file = $filename;
        }
        
        $surat->document_type = 'Authority';

        // Simpan data ke dalam database
        $surat->save();

        // Response sukses
        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }

    public function storeGeneral(Request $request)
    {
        // Validasi data yang diterima dari frontend
        $validatedData = $request->validate([
            'nomor' => 'required',
            'tanggal' => 'required',
            'perihal' => 'required',
            'nomor_surat' => 'required',
            'keterangan' => 'required',
            'file' => 'required|file|mimes:pdf,docx', // Contoh validasi untuk file PDF dan DOCX
        ]);

        // Simpan data ke dalam database menggunakan model Letter
        $surat = new letterout($validatedData);

        // Simpan file ke dalam storage jika ada
        // Simpan file ke dalam storage jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file'); // Ganti ini
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets'), $filename); // Pindahkan file ke direktori 'public/assets'
            $surat->file = $filename;
        }

        $surat->document_type = 'General';

        // Simpan data ke dalam database
        $surat->save();

        // Response sukses
        return response()->json(['message' => 'Data berhasil disimpan'], 201);
    }

    // Metode untuk menampilkan data dokumen
    public function index()
    {
        // Ambil semua data dokumen
        $surat = letterout::all();

        // Kembalikan data dalam format JSON sebagai respons
        return response()->json(['surat' => $surat]);
    }

    // Metode untuk melakukan pencarian dokumen
    public function search(Request $request)
    {
        // Validasi input dari frontend
        $request->validate([
            'searchQuery' => 'string|nullable',
            'documentType' => 'string|nullable',
            'startDate' => 'date|nullable',
            'endDate' => 'date|nullable',
        ]);

        // Query awal untuk data dokumen
        $query = Document::query();

        // Filter berdasarkan searchQuery jika ada
        if ($request->has('searchQuery')) {
            $query->where('perihal', 'like', '%' . $request->input('searchQuery') . '%');
        }

        // Filter berdasarkan documentType jika ada
        if ($request->has('documentType')) {
            $query->where('document_type', $request->input('documentType'));
        }

        if ($request->has('startDate') && $request->has('endDate')) {
            $query->whereDate('tanggal', '>=', $request->input('startDate'))
                ->whereDate('tanggal', '<=', $request->input('endDate'));
        }

        // Eksekusi query dan ambil data
        $documents = $query->get();

        // Kembalikan data dalam format JSON sebagai respons
        return response()->json(['documents' => $documents]);
    }

    public function export(Request $request)
    {
        // Ambil nilai filter dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $documentType = $request->input('document_type');

        // Buat query untuk mengambil data sesuai dengan filter
        $query = letterout::query();

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        if (!empty($documentType)) {
            $query->where('document_type', $documentType);
        }

        $data = $query->get();

        // Generate dan kirim file Excel dengan data yang difilter
        // ...

        // Kembalikan file Excel sebagai respons
        return Excel::download(new LetterOutExport($data), 'letterout.xlsx');
    }

}
