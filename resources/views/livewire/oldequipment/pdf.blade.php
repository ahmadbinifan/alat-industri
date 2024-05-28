<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment License</title>
</head>
<style type="text/css">
    @page {

        margin-top: 1cm;
        margin-bottom: 1cm;
        margin-left: 1cm;
        margin-right: 1cm;
    }

    /* body {
            margin: 3px;
        } */

    p {
        font-size: 12px;
    }

    p.custom {
        font-size: 12px;
    }

    p.form {
        font-size: 8px;
        text-align: start;
        float: right;
    }

    img {
        float: left;
    }

    table,
    th {
        border: 1px solid black;
    }

    td {
        border: 1px solid black;
        font-size: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        text-align: center;
        font-weight: bold;
        /* text-transform: uppercase; */
        page-break-inside: auto
    }

    .header-approval {
        text-align: left;
    }

    div.bold {
        font-size: 10px;
        tab-size: 8;
    }

    div.f-right {
        font-size: 10px;
        text-align: start;
        float: right;
    }

    .border-top {
        border-top-style: solid;
        border-bottom-style: solid;
    }

    .center {
        margin-left: auto;
        margin-right: auto;
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto;

    }

    table.noborder {
        width: 100%;
    }

    thead {
        display: table-header-group
    }

    tfoot {
        display: table-footer-group
    }

    #box1 {
        width: 80px;
        font-size: 8px;
        font-family: 'Times New Roman', Times, serif;
        height: 40px;
        background: white;
        border: solid 1px black;
        float: right;
    }

    hr {
        border-top: 0.5px solid;
    }

    .tab {
        display: inline-block;
        margin-left: 40px;
    }

    .row {
        margin: 50px;
    }

    .box {
        vertical-align: top;
        text-align: left;
        width: 680px;
        border: 1px solid;
        padding: 20px;

    }

    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto auto;
        gap: 1px;
        padding: 1px;
    }

    .grid-container>div {
        text-align: left;
        font-size: 12px;
    }
</style>
</head>
<p class="form"> Sheet No : NA<br>
    Form No. : -<br>
    Rev. No : - <br>
    Issued :-
</p>

<body>
    <img src="{{ $logo }}" style="width:75px;height:65px;margin-right:15px;">
    <div class="">
        <p style="font-size: 13px;"><b>{{ $head->company }}</b>
            <br>
            <i style="font-size: 10px; font-weight:bold">Equipment License</i>
        </p>
    </div>
    <br>
    <hr>
    <h4>Head Document</h4>
    <table class="header">
        <thead>
            <tr>
                <th>Document No.</th>
                <th>Filling Date</th>
                <th>Tag Number Asset</th>
                <th>Owner Asset</th>
                <th>Location Asset</th>
                <th>Regulation No.</th>
                <th>Last Inspection</th>
                <th>Frequency Check</th>
                <th>Estimated Cost</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $head->doc_no }}</td>
                <td>{{ date('d-m-Y', strtotime($head->filing_date)) }}</td>
                <td>{{ $head->tag_number . '  ' . $mastereq->description }}</td>
                <td>{{ $head->owner_asset }}</td>
                <td>{{ $head->location_asset }}</td>
                <td>{{ $reg->regulation_no . ' ' . $reg->regulation_desc }}</td>
                <td>{{ $head->last_inspection }}</td>
                <td>{{ $reg->check_frequency }}</td>
                <td>Rp. {{ number_format($head->estimated_cost, 2) }}</td>
                <td>{{ $head->status }}</td>
            </tr>
        </tbody>
    </table>

    <h4>List Item License</h4>

    <table class="header" style="margin-top: 10px">
        <thead>
            <tr>
                <th>License No.</th>
                <th>License From</th>
                <th>Issued Date Document</th>
                <th>Last License Date</th>
                <th>Reminder Checking Date</th>
                <th>Reminder Testing Date</th>
                <th>Repeat License</th>
                <th>Frequency Testing</th>
                <th>Repeat License Testing</th>
                <th>Reminder Schedule</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $detail->license_no }}</td>
                <td>{{ $detail->license_from }}</td>
                <td>{{ date('d-m-Y', strtotime($detail->issued_date_document)) }}</td>
                <td>{{ date('d-m-Y', strtotime($detail->last_license_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($detail->reminder_checking_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($detail->reminder_testing_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($detail->re_license)) }}</td>
                <td>{{ $detail->frequency_testing }}</td>
                <td>{{ date('d-m-Y', strtotime($detail->re_license_testing)) }}</td>
                <td>{{ $detail->reminderSchedule }}</td>
            </tr>
        </tbody>
    </table>

    <h4>History Approval</h4>
    <table class="header-approval" style="margin-top: 10px">
        <tbody>
            @foreach ($approval as $approve)
                <tr>
                    <td style="width: 10%">{{ $approve->fullname }}</td>
                    <td>{{ date('d M Y', strtotime($approve->approved_at)) }}<br>{{ $approve->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
