<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Imports\UserImport;
use App\Exports\UserExport;
use League\Csv\Reader;
use League\Csv\Writer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserImportExportController extends Controller
{
    public function importForm()
    {
        return view('user.import');
    }

    public function mahasiswaImportForm()
    {
        return view('user.import-mahasiswa');
    }

    public function dosenImportForm()
    {
        return view('user.import-dosen');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls']
        ]);

        $path = $request->file('file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $records = iterator_to_array($csv->getRecords());

        $importer = new UserImport();
        $result = $importer->import($records);

        return back()->with(["import_result" => $result]);
    }

    public function mahasiswaImport(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls']
        ]);

        $path = $request->file('file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $records = iterator_to_array($csv->getRecords());

        $importer = new UserImport();
        $result = $importer->importMahasiswa($records);

        return back()->with(["import_result" => $result, "type" => "mahasiswa"]);
    }

    public function dosenImport(
        Request $request,
        UserImport $userImport
    ) {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv'
            ]
        ]);

        $spreadsheet = IOFactory::load(
            $request->file('file')->getPathname()
        );

        $sheet = $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray();

        $headers = array_shift($rows);

        $records = [];

        foreach ($rows as $row) {

            if (count(array_filter($row)) === 0) {
                continue;
            }

            $records[] = array_combine(
                $headers,
                $row
            );
        }

        $result = $userImport->importDosen($records);

        return redirect()
            ->route('user.dosen.index')
            ->with('success', "{$result['success']} data dosen berhasil diimport.")
            ->with('import_result', $result);
    }

    public function export()
    {
        $exporter = new UserExport();
        $rows = $exporter->export();

        $csv = Writer::createFromString('');
        if (count($rows) > 0) {
            $csv->insertOne(array_keys($rows[0]));
            foreach ($rows as $row) {
                $csv->insertOne($row);
            }
        }

        $filename = 'users-export-' . date('Ymd_His') . '.csv';

        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function mahasiswaExport()
    {
        $exporter = new UserExport();
        $rows = $exporter->exportMahasiswa();

        $csv = Writer::createFromString('');
        if (count($rows) > 0) {
            $csv->insertOne(array_keys($rows[0]));
            foreach ($rows as $row) {
                $csv->insertOne($row);
            }
        }

        $filename = 'mahasiswa-export-' . date('Ymd_His') . '.csv';

        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function dosenExport()
    {
        $exporter = new UserExport();
        $rows = $exporter->exportDosen();

        $csv = Writer::createFromString('');
        if (count($rows) > 0) {
            $csv->insertOne(array_keys($rows[0]));
            foreach ($rows as $row) {
                $csv->insertOne($row);
            }
        }

        $filename = 'dosen-export-' . date('Ymd_His') . '.csv';

        return response((string) $csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
