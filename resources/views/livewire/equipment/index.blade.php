<div>

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Operation</a></li>
            <li class="breadcrumb-item active" aria-current="page">Equipment License</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="card-title">List existing License</h6>
                        <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal"
                            data-backdrop="static" data-target="#modalCreate">
                            <i class="btn-icon-prepend mdi mdi-plus-circle-multiple-outline"></i>
                            Create License
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
                                        {{-- <td><button wire:click="detailRow" class="btn btn-xs btn-success">+</button>
                                        </td> --}}
                                        <td>{{ $value->doc_no }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->filing_date)) }}</td>
                                        <td>{{ $value->company }}</td>
                                        <td>{{ $value->tag_number }}</td>
                                        <td>
                                            @switch($value->status)
                                                @case('wait_dep')
                                                    <span class="badge badge-primary">WAIT DEP<span>
                                                        @break

                                                        @case('wait_adm_legal')
                                                            <span class="badge badge-primary">WAIT ADMIN LEGAL<span>
                                                                @break

                                                                @case('wait_dep_hrd')
                                                                    <span class="badge badge-primary">WAIT DEP HRD<span>
                                                                        @break

                                                                        @case('wait_adm_hse')
                                                                            <span class="badge badge-primary">WAIT ADMIN
                                                                                HSE<span>
                                                                                @break

                                                                                @case('wait_dep_hse')
                                                                                    <span class="badge badge-primary">WAIT DEP
                                                                                        HSE<span>
                                                                                        @break

                                                                                        @case('wait_budgetcontrol')
                                                                                            <span
                                                                                                class="badge badge-primary">WAIT
                                                                                                BUDGET CONTROL<span>
                                                                                                @break

                                                                                                @case('in_progress_prpo')
                                                                                                    <span
                                                                                                        class="badge badge-primary">IN
                                                                                                        PROGRESS PR-PO<span>
                                                                                                        @break

                                                                                                        @case('license_running')
                                                                                                            <span
                                                                                                                class="badge badge-success">LICENSE
                                                                                                                RUNNING<span>
                                                                                                                @break

                                                                                                                @default
                                                                                                                    <span
                                                                                                                        class="badge badge-danger">NO
                                                                                                                        STATUS<span>
                                                                                                                    @endswitch
                                        </td>
                                        <td><button type="button"
                                                @click="$dispatch('detail-mode',{id:{{ $value->id }}})"
                                                class="btn btn-success btn-xs" data-toggle="modal"
                                                data-target="#modalDetail">
                                                <i class="mdi mdi-eye" style="height: 15px;width:15px"></i>
                                            </button>
                                            <button type="button"
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
        <livewire:equipment.create />
        <livewire:equipment.detail />
        <livewire:equipment.update />
        <livewire:equipment.delete />
    </div>
