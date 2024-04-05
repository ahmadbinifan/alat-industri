<div>
    <livewire:certificate-regulation.create />
    <livewire:certificate-regulation.update />
    <livewire:certificate-regulation.delete />
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
                            <i class="btn-icon-prepend mdi mdi-plus-circle-multiple-outline"></i>
                            Create Regulation
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Per Page</label>
                            <select class="form-select" wire:model.live='perPage'>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Search</label>
                            <input type="text" wire:model.live.debounce.10ms="search" class="form-control"
                                placeholder="Search..." wire:model='search'>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th wire:click="doSort('regulation_no')" class="flex items-center">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                            columnName="regulation_no" />
                                    </th>
                                    <th wire:click="doSort('regulation_desc')">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                            columnName="regulation_desc" />
                                    </th>
                                    <th wire:click="doSort('category')">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="category" />
                                    </th>
                                    <th wire:click="doSort('check_frequency')">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                            columnName="check_frequency" />
                                    </th>
                                    <th>Document K3</th>
                                    <th>Action</th>
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
                                            <button class="btn btn-primary btn-xs"
                                                wire:click='downloadFile({{ $value->id }})'>
                                                Download
                                            </button>
                                            <?php } else { ?>
                                            -
                                            <?php }
                                        ?>
                                        </td>
                                        <td><button type="button"
                                                @click="$dispatch('edit-mode',{id:{{ $value->id }}})"
                                                class="btn btn-warning btn-xs" data-toggle="modal"
                                                data-target="#modalUpdate">
                                                <i class="mdi mdi-lead-pencil" style="height: 15px;width:15px"></i>
                                            </button>
                                            <button type="button"
                                                @click="$dispatch('delete-mode',{id:{{ $value->id }}})"
                                                data-toggle="modal" data-target="#modalDelete"
                                                class="btn btn-danger btn-xs">
                                                <i class="mdi mdi-delete-sweep" style="height: 15px;width:15px"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="6">Not Found Data.</td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</div>
