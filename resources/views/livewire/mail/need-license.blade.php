<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification Email</title>
</head>

<body>
    <p>Dear Sdr.{{ $fullname }},<br>
        Berikut...<br>
        Daftar license equipment yang membutuhkan re license : </p>
    <table>
        <thead>
            <tr>
                {{-- <th>No</th> --}}
                <th>DocumentNo</th>
                <th>Tag Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    {{-- <td>{{ $no }}</td> --}}
                    <td>{{ $item->doc_no }}</td>
                    <td>{{ $item->tag_number }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        Silahkan untuk melakukan Renewal melalui link berikut ini.<br>
        *Jika anda berada diluar jaringan lokal aktifkan VPN terlebih dahulu.</p>
    <p>Klik Disini</p>
    <p><i>Best Regards, <br>
            Automated Mail Service Notification <br>
            Bakrie Renewable Chemicals
        </i></p>

</body>

</html>
