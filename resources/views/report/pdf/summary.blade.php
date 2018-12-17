<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Summary Report</title>
</head>
<style>
    body{
        font-size: 12px;
    }

    td.center {
        text-align: center;
    }
    .justify{
        font-style: inherit justify;
    }
    .page-break {
        page-break-after: always;
    }
    table.outline-table {
		border: 1px solid;
		border-spacing: 0;
        margin-top: 30px;
	}
	tr.border-bottom td, td.border-bottom {
		border-bottom: 1px solid;
	}
	tr.border-top td, td.border-top {
		border-top: 1px solid;
	}
	tr.border-right td, td.border-right {
		border-right: 1px solid;
	}
	tr.border-right td:last-child {
		border-right: 0px;
	}
	tr.center td, td.center {
		text-align: center;
	}
	td.pad-left {
		padding-left: 5px;
	}
	tr.right-center td, td.right-center {
		text-align: right;
		padding-right: 50px;
	}
	tr.right td, td.right {
		text-align: right;
	}
	.grey {
		background:grey;
	}
</style>
<body>
    <table width="100%">
        <tr>
            <td class="center"><span>LAPORAN JUMLAH BARANG DAN PENDAPATAN</span></td>
        </tr>
        <tr>
            <td class="center"><span style="color: red;">PRIMAJASA MODA (BANDARA SOEKARNO-HATTA)</span></td>
        </tr>
        <tr>
            <td class="center"><span style="color: red;">{{ strtoupper($month) . " " . date('Y') }}</span></td>
        </tr>
    </table>

    <table width="100%" class="outline-table">
        <thead>
            <tr class="center">
                <td class="border-right" rowspan="2">DATE</td>
                <td class="border-right" rowspan="2">DP</td>
                <td class="border-right border-bottom" colspan="{{ $als->count() }}">TOTAL PASSSENGER/ASSIGN LOC</td>
                <td class="border-right" rowspan="2">TOTAL INCOME</td>
                <td class="border-right border-bottom" colspan="{{ $als->count() }}">REFUND</td>
                <td class="border-right" rowspan="2">TOTAL REFUND</td>
                <td class="border-bottom" colspan="3">INCOME</td>
            </tr>
            <tr class="center">
                @foreach ($als as $al)
                    <td class="border-right">{{ $al->assign_location }}</td>
                @endforeach
                @foreach ($als as $al)
                    <td class="border-right">{{ $al->assign_location }}</td>
                @endforeach
                <td class="border-right">CASH</td>
                <td class="border-right">NON CASH</td>
                <td>REFUND</td>
            </tr>
        </thead>
        <tbody>
            @php
                use Carbon\Carbon;
                use App\Manifest;

                $l = Carbon::parse("last day of $month")->format('d');
                $c = Carbon::parse("first day of $month");
                $y = [
                    'income' => 0,
                    'cash' => 0,
                    'noncash' => 0,
                    'refund' => 0,
                    'dp' => 0
                ];
                $yy = [
                    'income' => 0,
                    'cash' => 0,
                    'noncash' => 0,
                    'refund' => 0,
                    'dp' => 0
                ];
                $yrefund = [
                    'all' => 0
                ];
                $yyrefund = [
                    'all' => 0
                ];
            @endphp
            @foreach ($als as $al)
                @php
                    $y = array_merge($y, [$al->code_location => 0]);
                    $yy = array_merge($y, [$al->code_location => 0]);
                    $yrefund = array_merge($yrefund, [$al->code_location => 0]);
                    $yyrefund = array_merge($yrefund, [$al->code_location => 0]);
                @endphp
            @endforeach
            @for ($i = 1; $i <= $l; $i++)
                @php
                    $dp = Manifest::where('created_at', 'like', date('Y-') . $c->format('m-d') . '%')->get()->groupBy(['departure_time_id', 'destination_id']);
                    $dps = 0;
                    if ($dp->count() != 0) {
                        foreach ($dp as $key) {
                            $dps += $key->count();
                        }
                    }
                @endphp
                <tr class="center border-top">
                    <td class="border-right">{{ $i }}</td>
                    <td class="border-right">{{ $dps == 0 ? '-' : $dps }}</td>
                    @php
                        if ($i <= 15) {
                            $y['dp'] += $dps;
                        } else {
                            $yy['dp'] += $dps;
                        }
                    @endphp
                    @foreach ($als as $al)
                        @php
                            $current_manifest = Manifest::where('created_at', 'like', date('Y-') . $c->format('m-d') . '%')->get();
                            $total = 0;
                            $current_row_passenger = 0;
                            if ($current_manifest->count() != 0) {
                                foreach ($current_manifest as $manifest) {
                                    $total += ($manifest->passenger(1) + $manifest->passenger(0));
                                }

                                $current_row_passenger += $total;
                                if ($i <= 15) {
                                    $y[$al->code_location] += $current_row_passenger;
                                } else {
                                    $yy[$al->code_location] += $current_row_passenger;
                                }
                            }
                        @endphp
                        @php
                            if ($i <= 15) {
                                $y['income'] += $total;
                            } else {
                                $yy['income'] += $total;
                            }
                        @endphp
                        <td class="border-right">{{ $total == 0 ? '-' : $total }}</td>
                    @endforeach
                    <td class="border-right">{{ $current_row_passenger == 0 ? '-' : $current_row_passenger }}</td>
                    @foreach ($als as $al)
                        @php
                            $current_manifest = Manifest::where('created_at', 'like', date('Y-') . $c->format('m-d') . '%')->get();
                            $total = 0;
                            $current_row_refund = 0;
                            if ($current_manifest->count() != 0) {
                                foreach ($current_manifest as $manifest) {
                                    $total += $manifest->refundSeat()->count();
                                    if ($i <= 15) {
                                        $yrefund[$al->code_location] += $total;
                                    } else {
                                        $yyrefund[$al->code_location] += $total;
                                    }
                                }

                                $current_row_refund += $total;
                                if ($i <= 15) {
                                    $yrefund['all'] += $total;
                                } else {
                                    $yyrefund['all'] += $total;
                                }
                            }
                        @endphp
                        <td class="border-right">{{ $total == 0 ? '-' : $total }}</td>
                    @endforeach
                    <td class="border-right">{{ $current_row_refund == 0 ? '-' : $current_row_refund }}</td>
                    @foreach ($als as $al)
                    @php
                            $current_manifest = Manifest::where('created_at', 'like', date('Y-') . $c->format('m-d') . '%')->get();
                            $cash = 0;
                            $noncash = 0;
                            $refund = 0;
                            if ($current_manifest->count() != 0) {
                                foreach ($current_manifest as $manifest) {
                                    $cash += $manifest->cash();
                                    $noncash += $manifest->nonCash();
                                    $refund += $manifest->refundPrice();
                                }
                            }
                            $c->addDay();
                            @endphp
                    @endforeach
                    <td class="border-right">{{ $cash == 0 ? '-' : 'Rp. '. number_format($cash) }}</td>
                    <td class="border-right">{{ $noncash == 0 ? '-' : 'Rp. '. number_format($noncash) }}</td>
                    <td>{{ $refund == 0 ? '-' : 'Rp. '. number_format($refund) }}</td>
                    @php
                    if ($i <= 15) {
                        $y['cash'] += $cash;
                        $y['noncash'] += $noncash;
                        $y['refund'] += $refund;
                    } else {
                        $yy['cash'] += $cash;
                        $yy['noncash'] += $noncash;
                        $yy['refund'] += $refund;
                    }
                    @endphp
                </tr>
                @if ($i == 15)
                    <tr class="center" style="background-color : yellow;">
                        <td class="border-top border-right border-left">&nbsp;</td>
                        <td class="border-top border-right">{{ $y['dp'] == 0 ? '-' : $y['dp'] }}</td>
                        @foreach ($als as $al)
                            <td class="border-top border-right">{{ $y[$al->code_location] == 0 ? '-' : $y[$al->code_location] }}</td>
                        @endforeach
                        <td class="border-top border-right">{{ $y['income'] == 0 ? '-' : $y['income'] }}</td>
                        @foreach ($als as $al)
                            <td class="border-top border-right">{{ $yrefund[$al->code_location] == 0 ? '-' : $yrefund[$al->code_location] }}</td>
                        @endforeach
                        <td class="border-top border-right">{{ $yrefund['all'] == 0 ? '-' : $yrefund['all'] }}</td>
                        <td class="border-top border-right">{{ $y['cash'] == 0 ? '-' : 'Rp. '.number_format($y['cash']) }}</td>
                        <td class="border-top border-right">{{ $y['noncash'] == 0 ? '-' : 'Rp. '.number_format($y['noncash']) }}</td>
                        <td class="border-top border-right">{{ $y['refund'] == 0 ? '-' : 'Rp. '.number_format($y['refund']) }}</td>
                    </tr>
                    <tr class="center border-top" style="background-color : yellow;">
                        <td colspan="{{ 4 + ($als->count() * 2) }}" class="border-right">Total Income {{ $i == 15 ? '1/15' : "16/$l" }}</td>
                        <td colspan="3">Rp . {{ number_format($y['cash'] + $y['noncash'] + $y['refund']) }}</td>
                    </tr>
                @endif
                @if ($i == $l)
                    <tr class="center" style="background-color : yellow;">
                        <td class="border-top border-right border-left">&nbsp;</td>
                        <td class="border-top border-right">{{ $yy['dp'] == 0 ? '-' : $yy['dp'] }}</td>
                        @foreach ($als as $al)
                            <td class="border-top border-right">{{ $yy[$al->code_location] == 0 ? '-' : $yy[$al->code_location] }}</td>
                        @endforeach
                        <td class="border-top border-right">{{ $yy['income'] == 0 ? '-' : $yy['income'] }}</td>
                        @foreach ($als as $al)
                            <td class="border-top border-right">{{ $yyrefund[$al->code_location] == 0 ? '-' : $yyrefund[$al->code_location] }}</td>
                        @endforeach
                        <td class="border-top border-right">{{ $yyrefund['all'] == 0 ? '-' : $yyrefund['all'] }}</td>
                        <td class="border-top border-right">{{ $yy['cash'] == 0 ? '-' : 'Rp. '.number_format($yy['cash']) }}</td>
                        <td class="border-top border-right">{{ $yy['noncash'] == 0 ? '-' : 'Rp. '.number_format($yy['noncash']) }}</td>
                        <td class="border-top border-right">{{ $yy['refund'] == 0 ? '-' : 'Rp. '.number_format($yy['refund']) }}</td>
                    </tr>
                    <tr class="center border-top" style="background-color : yellow;">
                        <td colspan="{{ 4 + ($als->count() * 2) }}" class="border-right">Total Income {{ $i == 15 ? '1/15' : "16/$l" }}</td>
                        <td colspan="3">Rp . {{ number_format($yy['cash'] + $yy['noncash'] + $yy['refund']) }}</td>
                    </tr>
                @endif
                @if ($i == $l)
                    <tr class="center" style="background-color : orange;">
                        <td class="border-top border-right border-left">TOTAL</td>
                        <td class="border-top border-right">{{ $y['dp'] + $yy['dp'] }}</td>
                        @foreach ($als as $al)
                            <td class="border-top border-right">{{ $y[$al->code_location] + $yy[$al->code_location] }}</td>
                        @endforeach
                        <td class="border-top border-right">{{ $y['income'] + $yy['income'] }}</td>
                        @foreach ($als as $al)
                            <td class="border-top border-right">{{ $yrefund[$al->code_location] + $yyrefund[$al->code_location] }}</td>
                        @endforeach
                        <td class="border-top border-right">Rp. {{ number_format($yrefund['all'] + $yyrefund['all']) }}</td>
                        <td class="border-top border-right">Rp. {{ number_format($y['cash'] + $yy['cash']) }}</td>
                        <td class="border-top border-right">Rp. {{ number_format($y['noncash'] + $yy['noncash']) }}</td>
                        <td class="border-top border-right">Rp. {{ number_format($y['refund'] + $yy['refund']) }}</td>
                    </tr>
                    <tr class="center border-top" style="background-color : orange;">
                        <td colspan="{{ 4 + ($als->count() * 2) }}" class="border-right">Total Income {{  "1/$l" }}</td>
                        <td colspan="3">Rp . {{ number_format($yy['cash'] + $yy['noncash'] + $yy['refund'] + $y['cash'] + $y['noncash'] + $y['refund']) }}</td>
                    </tr>
                @endif
            @endfor
        </tbody>
    </table>
</body>
</html>