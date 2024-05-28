<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification Email</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        thead th {
            background-color: #f2f2f2;
            color: #333;
            padding: 10px;
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            color: #999;
        }
    </style>
</head>

<body>
    <p>Dear Sdr.{{ $fullname }},<br>
        Berikut...<br>
        Daftar license equipment yang membutuhkan re sertifikat : </p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>DocumentNo</th>
                <th>Tag Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->doc_no }}</td>
                    <td>{{ $item->tag_number }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No data available</td>
                </tr>
            @endforelse
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
