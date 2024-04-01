<div>
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Operation</a></li>
            <li class="breadcrumb-item active" aria-current="page">Certificate Regulations</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="card-title">List Regulations
                        </h6>
                        <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                            Create Regulation
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Regulation No.</th>
                                    <th>Regulation Description</th>
                                    <th>Category</th>
                                    <th>Check Frequency</th>
                                    <th>Document K3</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $value)
                                    <tr>
                                        <td>{{ $value->regulation_no }}</td>
                                        <td>{{ $value->regulation_desc }}</td>
                                        <td>{{ $value->category }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->check_frequency)) }}</td>
                                        <td><?php
                                        if ($value->document_k3){ ?>
                                            <button class="btn btn-sm btn-primary"
                                                wire:click='downloadFile({{ $value->id }})'>Download
                                                File</button>
                                            <?php } else { ?>
                                            -
                                            <?php }
                                        ?>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:certificate-regulation.create />
    <script>
        $(function() {
            $('#exampleModal').on('hidden.bs.modal', function(e) {
                $(this).find('form').trigger('reset');
            })
        })
    </script>
    @push('plugin-styles')
        <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    @endpush
    @push('plugin-scripts')
        <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
    @endpush
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('swal', (event) => {
                const data = event
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: data[0]['icon'],
                    title: data[0]['text']
                });
            })

        })
    </script>
