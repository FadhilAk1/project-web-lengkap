<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\letterOut;

class FileController extends Controller
{
//     public function getFile($fileName)
//     {
//         $filePath = storage_path('app/public/files/' . $fileName);

//         if (file_exists($filePath)) {
//             return response()->file($filePath);
//         } else {
//             abort(404, 'File not found');
//         }
//     }

//     public function view($id)
//     {
//         // Cari data surat berdasarkan ID atau cara lain yang sesuai
//         $surat = letterout::find($id);

//         // Periksa apakah surat ditemukan
//         if (!$surat) {
//             return response()->json(['message' => 'Surat tidak ditemukan'], 404);
//         }

//         // Mendapatkan path file yang akan ditampilkan
//         $filePath = storage_path('app/public/assets/' . $surat->file);

//         // Periksa apakah file ada
//         if (!file_exists($filePath)) {
//             return response()->json(['message' => 'File tidak ditemukan'], 404);
//         }

//         // Membaca konten file
//         $fileContents = file_get_contents($filePath);

//         // Menentukan tipe respons sesuai dengan jenis file
//         $response = response($fileContents, 200);

//         // Mengatur tipe konten respons sebagai PDF
//         $response->header('Content-Type', 'application/pdf');

//         // Memberikan nama file yang sesuai ketika diunduh
//         $response->header('Content-Disposition', 'inline; filename="' . $surat->file . '"');

//         return $response;
//     }

//     public function show($file_id)
// {
//     // Cari file berdasarkan ID atau identifikasi yang sesuai dengan logika aplikasi Anda
//     $file = letterout::find($file_id);

//     if (!$file) {
//         // Atur respons jika file tidak ditemukan
//         abort(404, 'File not found');
//     }

//     // Ambil path file dari model atau lokasi file Anda
//     $filePath = storage_path('app/public/assets/' . $file->file);

//     if (!file_exists($filePath)) {
//         // Atur respons jika file tidak ada di lokasi yang diharapkan
//         abort(404, 'File not found');
//     }

//     // Tampilkan file dalam halaman baru
//     return response()->file($filePath);
// }

    // public function view($id)
    // {
    //     // Fetch the document URL based on the $id (you need to implement this logic)
    //     $documentUrl = $this->fetchDocumentUrl($id); // Implement this function

    //     if ($documentUrl) {
    //         return view('documents.view', ['documentUrl' => $documentUrl]);
    //     } else {
    //         // Handle the case where the document URL is not available
    //         abort(404, 'Document not found');
    //     }
    // }

    // public function view($id)
    // {
    //     // Lakukan query untuk mendapatkan data berdasarkan ID atau nama file dari database
    //     $data = letterout::find($id); // Gantilah YourModel dengan model Anda yang sesuai

    //     // Pastikan data ditemukan, jika tidak, tangani kasus ini sesuai kebutuhan Anda
    //     if (!$data) {
    //         abort(404, 'Data not found');
    //     }

    //     // Tampilkan template Blade dengan data yang sesuai
    //     return view('view', ['data' => $data]);
    // }

    public function view($id)
    {
        // Lakukan query untuk mendapatkan data berdasarkan ID atau nama file dari database
        $data = letterout::find($id); // Gantilah YourModel dengan model Anda yang sesuai

        // Pastikan data ditemukan, jika tidak, tangani kasus ini sesuai kebutuhan Anda
        if (!$data) {
            abort(404, 'Data not found');
        }

        // Dapatkan path ke file PDF
        $pdfFilePath = public_path('assets\\' . $data->file); // Gantilah dengan kolom yang sesuai di model Anda

        // Periksa apakah file PDF ada
        if (!file_exists($pdfFilePath)) {
            abort(404, 'PDF file not found');
        }

        // Atur tipe konten respons sebagai PDF
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        // Unduh file PDF sebagai respons
        return response()->file($pdfFilePath, $headers);
    }



}
