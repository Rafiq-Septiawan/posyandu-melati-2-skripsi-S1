<?php

namespace App\Exports;

use App\Models\PemeriksaanAwalIbuHamil;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class LaporanIbuHamilExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnFormatting,
    ShouldAutoSize
{
    protected $bulan;
    protected $tahun;
    protected $search;

    public function __construct($bulan, $tahun, $search = null)
    {
        $this->bulan  = $bulan;
        $this->tahun  = $tahun;
        $this->search = $search;
    }

    public function collection()
    {
        $query = PemeriksaanAwalIbuHamil::with(['ibuHamil', 'kader', 'pemeriksaanLanjutan'])
            ->whereMonth('tanggal_periksa', $this->bulan)
            ->whereYear('tanggal_periksa', $this->tahun);

        if ($this->search) {
            $query->whereHas('ibuHamil', function ($q) {
                $q->where('nama_ibu', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest('tanggal_periksa')->get();
    }

    public function headings(): array
    {
        return [
            ['POSYANDU MELATI 2'],
            ['Laporan Pemeriksaan Ibu Hamil - ' . Carbon::createFromDate($this->tahun, $this->bulan, 1)->locale('id')->translatedFormat('F Y')],
            [],
            [
                'No',
                'Nama Ibu',
                'NIK',
                'Status Kehamilan (G/P/A)',
                'Usia Kehamilan (minggu)',
                'Tanggal Periksa',
                'Berat Badan (kg)',
                'Tekanan Darah',
                'Kader Pemeriksa',
                'Catatan Bidan',
            ],
        ];
    }

    // ✅ Fix NIK: format kolom C sebagai teks biar tidak jadi scientific notation
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $ibu      = $row->ibuHamil;

        // ✅ Coba semua kemungkinan nama relasi lanjutan
        $lanjutan = $row->pemeriksaanLanjutan
                 ?? $row->lanjutan
                 ?? null;

        $statusKehamilan = $ibu
            ? 'G' . $ibu->gravida . 'P' . $ibu->partus . 'A' . $ibu->abortus
            : '-';

        $usiaKehamilan = ($ibu && $ibu->hpht)
            ? (int) Carbon::parse($ibu->hpht)->diffInWeeks(now())
            : '-';

        // ✅ NIK diawali tanda kutip satu agar Excel baca sebagai teks
        $nik = $ibu->nik ?? '-';

        $catatanBidan = '-';
        if ($lanjutan) {
            $catatanBidan = $lanjutan->catatan_bidan ?? $lanjutan->catatan ?? '-';
        }

        return [
            $no,
            $ibu->nama_ibu ?? '-',
            "\t" . $nik,   // ✅ prefix tab trick agar NIK tidak jadi scientific notation
            $statusKehamilan,
            $usiaKehamilan,
            Carbon::parse($row->tanggal_periksa)->format('d/m/Y'),
            $row->berat_badan ?? '-',
            $row->tekanan_darah ?? '-',
            $row->kader->nama ?? '-',
            $catatanBidan,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');

        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Heading kolom row 4
        $sheet->getStyle('A4:J4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0D9488'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Format kolom NIK (C) sebagai teks
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('C5:C' . $lastRow)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_TEXT);

        if ($lastRow >= 4) {
            $sheet->getStyle('A4:J' . $lastRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color'       => ['rgb' => 'D1D5DB'],
                    ],
                ],
            ]);
        }

        $sheet->freezePane('A5');

        return [];
    }

    public function title(): string
    {
        return 'Laporan Ibu Hamil';
    }
}