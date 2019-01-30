<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket</title>
</head>
<style>
    body{
        font-size: 8px;
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
</style>
<body>
    @php
        $last = $ticket->seats()->orderBy('seat_number', 'desc')->first()->seat_number
    @endphp
    @foreach ($ticket->seats()->orderBy('seat_number')->get() as $seat)
    <table width="100%">
        <tr>
            <td width="15%">
                <img src="https://seeklogo.com/images/K/kementerian-perhubungan-logo-DE7FA595E2-seeklogo.com.png" alt="Dinas Perhubungan" width="30pt" height="30pt">
            </td>
            <td width="50%" class="center">
                <p><strong>TRANSPORTASI</strong></p>
                <p><strong>ANGKUTAN PEMADU MODA</strong></p>
            </td>
            <td width="15%">
                <img src="https://pbs.twimg.com/profile_images/1173050689/pp_400x400.png" alt="Primajasa" width="30pt" height="30pt">
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <tr width="30%">
            <td>No Tiket</td>
            <td>: {{ $ticket->code }}</td>
        </tr>
        <tr width="30%">
            <td>Jam / Tanggal</td>
            <td>: {{ $ticket->created_at }}</td>
        </tr>
        <tr width="30%">
            <td>Tujuan</td>
            <td>: {{ $ticket->destination->to }}</td>
        </tr>
        <tr width="30%">
            <td>Nama</td>
            <td>: {{ $ticket->customer->name }}</td>
        </tr>
        <tr width="30%">
            <td>No. Tlp</td>
            <td>: {{ $ticket->customer->phone }}</td>
        </tr>
        <tr width="30%">
            <td>No Seat</td>
            <td>: {{ $seat->seat_number }}</td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
        <tr width="30%">
            <td>Harga Tiket</td>
            <td>: Rp. {{ number_format($ticket->destination->price) }}</td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>
                {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("1", "C39+") . '" alt="barcode"  width="70pt" heigh="50pt"/>' !!}
            </td>
            <td>
                <p class="justify">TERIMA KASIH</p>
                <p class="justify">INFORMASI</p>
                 <p class="justify">SOETA : 021-5591-5555</p>
                <p class="justify">BNI : 022-8752-6886</p>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="justify">Jagalah barang bawaan anda!! Periksa dan cocokkan saat turun,segala jeni kehilangan dan kerusakan atau tertukar bukan merupakan tanggung jawab manajemen Primajasa</p>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
    </table>
    @if ($seat->seat_number != $last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>