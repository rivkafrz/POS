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
</style>
<body>
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
            <td>: 123123123</td>
        </tr>
        <tr width="30%">
            <td>Jam / Tanggal</td>
            <td>: {{ now()->toDateTimeString() }}</td>
        </tr>
        <tr width="30%">
            <td>Tujuan</td>
            <td>: Terminal 2 D</td>
        </tr>
        <tr width="30%">
            <td>Nama</td>
            <td>: Hanis</td>
        </tr>
        <tr width="30%">
            <td>No. Tlp</td>
            <td>: 0821312321312</td>
        </tr>
        <tr width="30%">
            <td>No Seat</td>
            <td>: 12</td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
        <tr width="30%">
            <td>Harga Tiket</td>
            <td>: Rp. 120.000</td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td><img src="https://upload.wikimedia.org/wikipedia/commons/3/3e/Codabar-example.svg" alt="Barcode" width="80pt" height="50pt"></td>
            <td>
                <p class="justify">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio nisi quidem eum molestias fugit earum ea quis tempore.</p>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
        <tr>
            <td colspan="2">
                <p class="justify">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sed quibusdam ab voluptatem, dolore consequuntur explicabo cum in, nam repudiandae alias magnam sunt accusantium reprehenderit, eaque ratione! Asperiores vel placeat doloremque!</p>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
    </table>
</body>
</html>