<div>

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Operation</a></li>
            <li class="breadcrumb-item active" aria-current="page">Old License Equipment </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="card-title">List</h6>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-success btn-icon-text" wire:click='exportExcel'>
                            <i class="btn-icon-prepend mdi mdi-file-excel"></i>
                            Export to Excel
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
                                    <th wire:click="doSort('doc_no')" class="flex items-center">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="doc_no" />
                                    </th>
                                    <th wire:click="doSort('filing_date')" class="flex items-center">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection"
                                            columnName="filing_date" />
                                    </th>
                                    <th wire:click="doSort('company')" class="flex items-center">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="company" />
                                    </th>
                                    <th wire:click="doSort('tag_number')" class="flex items-center">
                                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="tag_number" />
                                    </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $value)
                                    <tr>
                                        <td>{{ $value->doc_no }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->filing_date)) }}</td>
                                        <td>{{ $value->company }}</td>
                                        <td>{{ $value->tag_number }}</td>
                                        <td>
                                            @switch($value->status)
                                                @case('request_renewal')
                                                    <span class="badge badge-warning">REQUEST
                                                        RENEWAL<span>
                                                        @break

                                                        @case('closed')
                                                            <span class="badge badge-secondary">CLOSED
                                                                <span>
                                                                @break

                                                                @default
                                                                    <span class="badge badge-danger">NO
                                                                        STATUS<span>
                                                                    @endswitch
                                        </td>
                                        <td><button type="button" @click="$dispatch('detail',{id:{{ $value->id }}})"
                                                class="btn btn-success btn-xs" data-toggle="modal"
                                                data-target="#modalDetail">
                                                <i class="mdi mdi-eye" style="height: 15px;width:15px"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                        <td colspan="6" class="text-center">Not Found Data.</td>
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
                $('#modalCreate').on('hidden.bs.modal', function(e) {
                    $(this).find('form').trigger('reset');
                })
            })
        </script>
        @push('plugin-styles')
            <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
        @endpush
        @push('plugin-scripts')
            <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
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
        <livewire:oldequipment.detail />
    </div>
