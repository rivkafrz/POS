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
    
    public function __construct($manifest, $assign)
    {
        $this->manifest = $manifest;
        $this->assign = $assign;
    }

    public function view() : View
    {
        $manifest = $this->manifest;
        $metadata = [];

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

        return view('report.excel.daily', compact('manifest', 'assign'));
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

                $thead1 = 'A7:C' . (6 + count($this->metadata));
                $table1 = 'A7:C10';
                $event->sheet->styleCells(
                    $thead1,
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );
                for ($i=6; $i <= (6 + count($this->metadata)); $i++) {
                    $cel = ['A', 'B', 'C'];
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
                            ]
                        );
                    }
                }
                $thead2 = 'A12:G13';
                $table2 = 'A12:G13';
                $tbody2 = "A14:G" . (12 + count($this->manifest));
                $tfoot2 = 'A' . (10 + count($this->manifest) + count($this->metadata)) . ':H' . (11 + count($this->metadata) + count($this->manifest));
                $event->sheet->styleCells(
                    $thead2,
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );
                $event->sheet->styleCells(
                    $tfoot2,
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]
                );
                for ($i=(8 + count($this->manifest) + count($this->manifest)); $i <= (9 + count($this->metadata) + count($this->manifest)); $i++) {
                    $cel = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
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
                            ]
                        );
                    }
                }
                for ($i=(10 + count($this->metadata) + count($this->manifest)); $i <= (11 + count($this->metadata) + count($this->manifest) ); $i++) {
                    $cel = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
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
                            ]
                        );
                    }
                }
                for ($i=(10 + count($this->manifest)); $i <= (11 + count($this->manifest)); $i++) {
                    $cel = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
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
            },
        ];
    }
}
