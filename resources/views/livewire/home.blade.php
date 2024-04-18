<div>

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Dashboard - Welcome back {{ session('fullname') }} &#128075;</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                <div class="col-md-4 grid-margin ">
                    <div class="container">
                        <div class="col-md-12 grid-margin ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">Total License</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-12 col-xl-5">
                                            <h3 class="mb-2 text-success">{{ $countDoc }}</h3>
                                            <div class="d-flex align-items-baseline">
                                                {{-- <p class="text-success">
                                            <span>+3.3%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p> --}}
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-12 col-xl-7 text-right">
                                            <i class="text-success" data-feather="arrow-up"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 grid-margin ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">License Running</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-12 col-xl-5">
                                            <h3 class="mb-2 text-danger-muted">{{ $countRunning }}</h3>
                                            <div class="d-flex align-items-baseline">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-12 col-xl-7 text-right">
                                            <i class="text-danger-muted" data-feather="check"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 grid-margin ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">License In Progress</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-12 col-xl-5">
                                            <h3 class="mb-2 text-warning">{{ $countProgress }}</h3>
                                            <div class="d-flex align-items-baseline">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-12 col-xl-7 text-right">
                                            <i class="text-warning" data-feather="activity"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-4">Reminders Expire's License</h6>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="pt-0">#</th>
                                                <th class="pt-0">Doc No</th>
                                                <th class="pt-0">Last License Date</th>
                                                <th class="pt-0">Reminder Checking Date </th>
                                                <th class="pt-0">Duration License</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($doc as $index => $value)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $value->doc_no }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->last_license_date)) }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($value->reminder_checking_date)) }}
                                                    </td>
                                                    <td><span class="badge badge-danger">
                                                            <?php
                                                            
                                                            // Mengubah tanggal menjadi format timestamp
                                                            $timestamp_tujuan = strtotime($value->last_license_date);
                                                            $timestamp_sekarang = time(); // Timestamp untuk tanggal sekarang
                                                            
                                                            // Menghitung selisih hari antara tanggal sekarang dan tanggal yang ditentukan
                                                            $selisih = $timestamp_tujuan - $timestamp_sekarang;
                                                            $selisih_hari = floor($selisih / (60 * 60 * 24)); // Mengkonversi selisih waktu menjadi hari
                                                            
                                                            echo "$selisih_hari day left";
                                                            ?>
                                                        </span></td>
                                                </tr>
                                            @empty
                                                <td colspan="5" class="text-center">Not Found Reminder Data.</td>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
