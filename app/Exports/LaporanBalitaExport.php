<?php

namespace App\Exports;

use App\Models\PemeriksaanAwalBalita;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class LaporanBalitaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
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
        $query = PemeriksaanAwalBalita::with(['balita', 'kader', 'pemeriksaanLanjutan'])
            ->whereMonth('tanggal_periksa', $this->bulan)
            ->whereYear('tanggal_periksa', $this->tahun);

        if ($this->search) {
            $query->whereHas('balita', function ($q) {
                $q->where('nama_balita', 'like', '%' . $this->search . '%');
            });
        }

        return $query->latest('tanggal_periksa')->get();
    }

    public function headings(): array
    {
        return [
            ['POSYANDU MELATI 2'],
            ['Laporan Pemeriksaan Balita - ' . Carbon::createFromDate($this->tahun, $this->bulan, 1)->locale('id')->translatedFormat('F Y')],
            [],
            [
                'No',
                'Nama Balita',
                'Jenis Kelamin',
                'Nama Ibu / Orang Tua',
                'Usia (bulan)',
                'Tanggal Periksa',
                'Berat Badan (kg)',
                'Tinggi Badan (cm)',
                'Lingkar Kepala (cm)',
                'Status Gizi',
                'Kader Pemeriksa',
                'Tindak Lanjut Bidan',
            ],
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $balita   = $row->balita;
        $lanjutan = $row->pemeriksaanLanjutan;

        $usia = $balita
            ? (int) Carbon::parse($balita->tanggal_lahir)->diffInMonths(now())
            : '-';

        $jenisKelamin = match ($balita->jenis_kelamin ?? '') {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };

        $namaIbu = $balita
            ? ($balita->ibuHamil->nama_ibu ?? $balita->nama_ibu ?? '-')
            : '-';

        $statusGizi = match ($row->status_gizi ?? '') {
            'normal'  => 'Normal',
            'kurang'  => 'Gizi Kurang',
            'buruk'   => 'Gizi Buruk',
            'lebih'   => 'Gizi Lebih',
            default   => $row->status_gizi ?? '-',
        };

        $tindakLanjut = '-';
        if ($lanjutan) {
            $tindakLanjut = match ($lanjutan->tindak_lanjut ?? '') {
                'kontrol'   => 'Kontrol Rutin',
                'rujukan'   => 'Rujukan',
                default     => $lanjutan->tindak_lanjut ?? '-',
            };
        }

        return [
            $no,
            $balita->nama_balita ?? '-',
            $jenisKelamin,
            $namaIbu,
            $usia,
            Carbon::parse($row->tanggal_periksa)->format('d/m/Y'),
            $row->berat_badan ?? '-',
            $row->tinggi_badan ?? '-',
            $row->lingkar_kepala ?? '-',
            $statusGizi,
            $row->kader->nama ?? '-',
            $tindakLanjut,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');

        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Heading kolom row 4 - warna pink/rose untuk balita
        $sheet->getStyle('A4:L4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'BE123C'], // rose
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $lastRow = $sheet->getHighestRow();
        if ($lastRow >= 4) {
            $sheet->getStyle('A4:L' . $lastRow)->applyFromArray([
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
        return 'Laporan Balita';
    }
}