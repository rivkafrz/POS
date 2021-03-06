<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Sheet;
use App\AssignLocation;
use Auth;

class DailyManifestExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $manifest;
    protected $assign;
    protected $metadata;
    protected $manifest_metadata;
    protected $exceptions;
    
    public function __construct($manifest, $assign)
    {
        $this->exceptions = [];
        $this->manifest = $manifest;
        $this->assign = $assign;
        if ($assign != 0) {
            foreach (AssignLocation::all() as $al) {
                if ($assign != $al->id) {
                    $this->exceptions = array_merge($this->exceptions, [$al->id]);
                }
            }
        }
        $manifest_metadata = [];
        foreach ($manifest as $single) {
            $needle = $single->departureTime->id . "-" . $single->destination->id;
            if (!in_array($needle, $manifest_metadata)) {
                array_push($manifest_metadata, $needle);
            }
        }
        $this->manifest_metadata = $manifest_metadata;
    }

    public function view() : View
    {
        $manifest = $this->manifest;
        $metadata = [];
        $exceptions = $this->exceptions;
        foreach ($manifest as $man) {
            foreach ($man->ticketings() as $ticketing) {
                !in_array($ticketing->id, $metadata) ? array_push($metadata, $ticketing->id) : null ;
            }
        }

        $this->metadata = $metadata;

        if ($this->assign == 0) {
            $assign = 'All Counter';
        } else {
            $assign = AssignLocation::find($this->assign);
        }
        return view('report.excel.daily', compact('manifest', 'assign', 'exceptions'));
    }

    public function registerEvents(): array
    {
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $title = 'A1:F1';
                $event->sheet->styleCells(
                    $title,
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );

                for ($i=6; $i <= (6 + count($this->metadata)); $i++) {
                    $cel = ['A', 'B', 'C', 'D'];
                    for ($j=0; $j < count($cel); $j++) {
                        $event->sheet->styleCells(
                            "$cel[$j]$i",
                            [
                                'borders' => [
                                    'outline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                'inline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                ],
                            ]
                        );
                    }
                }
                $thead2 = 'A12:G13';
                $table2 = 'A12:G13';
                $tbody2 = "A14:G" . (12 + (count($this->manifest) * 2));
                $tfoot2 = 'A' . (10 + count($this->manifest) + count($this->metadata)) . ':H' . (11 + count($this->metadata) + count($this->manifest));

                // Table 2 head
                for ($i=(8 + count($this->metadata)); $i <= (9 + count($this->metadata)); $i++) {
                    $cel = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
                            'Q', 'S', 'T'];
                    for ($j=0; $j < ((AssignLocation::all()->count() * 2) + 9); $j++) {
                        $event->sheet->styleCells(
                            "$cel[$j]$i",
                            [
                                'borders' => [
                                    'outline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                'inline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                ],
                            ]
                        );
                    }
                }

                // Table 2 footer
                for ($i=(10 + count($this->metadata) + count($this->manifest_metadata)); $i <= (11 + count($this->metadata) + count($this->manifest_metadata) ); $i++) {
                    $cel = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
                            'Q', 'S', 'T'];
                    for ($j=0; $j < ((AssignLocation::all()->count() * 2) + 10); $j++) {
                        $event->sheet->styleCells(
                            "$cel[$j]$i",
                            [
                                'borders' => [
                                    'outline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                'inline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                ],
                            ]
                        );
                    }
                }

                // Table 2 body
                for ($i=(10 + count($this->metadata)); $i <= (9 + count($this->metadata) + count($this->manifest_metadata)); $i++) {
                    $cel = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
                            'Q', 'S', 'T'];
                    for ($j=0; $j < ((AssignLocation::all()->count() * 2) + 9); $j++) {
                        $event->sheet->styleCells(
                            "$cel[$j]$i",
                            [
                                'borders' => [
                                    'outline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                'inline' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '00000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                ],
                            ]
                        );
                    }
                }
            },
        ];
    }
}
