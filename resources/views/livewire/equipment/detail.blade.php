<div>
    <div class="modal fade" wire:ignore.self id="modalDetail" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Information Document Equipment License</h5>
                    <button type="button" wire:click='close' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Document No</label>
                                        <input type="text" wire:model="documentNo" class="form-control" readonly>
                                        @error('documentNo')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <input type="text" class="form-control" wire:model="company" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Filling Date</label>
                                        <input type="date" wire:model="fillingDate" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" wire:ignore>
                                    <div class="form-group">
                                        <label>Tag Number Asset</label>
                                        <input type="text" class="form-control" wire:model="tagnumber" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Description Asset</label>
                                        <input type="text" wire:model="descriptionAsset" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Owner Asset</label>
                                        <input type="text" wire:model="ownerAsset" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location Asset</label>
                                        <input type="text" wire:model="locationAsset" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" wire:ignore>
                                    <div class="form-group">
                                        <label>Regulation No.</label>
                                        <input type="text" class="form-control" wire:model="idRegulation" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Inpection</label>
                                        <input type="text" wire:model="lastInspection" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Frequency Check</label>
                                        <input type="text" class="form-control" wire:model="frequencyCheck" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estimated Cost</label>
                                        <input type="text" class="form-control" wire:model="estimatedCost" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Document Requirements</label>
                                        @if ($documentRequirements)
                                            <a wire:click="downloadFile"
                                                class="btn btn-success form-control mdi mdi-download">Download
                                                Attachment</a>
                                        @else
                                            <a class="btn btn-danger form-control mdi mdi-server-remove" disabled>Empty
                                                Attachment.</a>
                                        @endif
                                    </div>
                                </div>
                                @if ($attachFromHSE)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Document From HSE</label>
                                            <a wire:click="downloadFileHSE"
                                                class="btn btn-secondary form-control mdi mdi-download">Download
                                                Attachment</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if ($status == 'in_progress_prpo' || $status == 'license_running' || $status == 'need_re_license')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>License No</label>
                                            <input type="text" wire:model='licenseNo' class="form-control"
                                                {{ $statusDetail == 'open' ? '' : 'readonly' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>License From</label>
                                            <input type="text" wire:model='licenseFrom' class="form-control"
                                                {{ $statusDetail == 'open' ? '' : 'readonly' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Issued Date Document</label>
                                            <input type="date" wire:model='issuedDateDocument'
                                                wire:change='issuedDate($event.target.value)' class="form-control"
                                                {{ $statusDetail == 'open' ? '' : 'readonly' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Expired License Date</label>
                                            <input type="date" wire:model='lastLicenseDate' class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Checking Date Frequency</label>
                                            <select wire:model="reminder_frequency"
                                                wire:change="refre($event.target.value)" class="form-select"
                                                {{ $statusDetail == 'open' ? '' : 'disabled' }}>
                                                <option value="">Choose Reminder Frequency</option>
                                                <option value="Kurang dari 1 Bulan">Kurang dari 1 Bulan</option>
                                                <option value="Kurang dari 2 Bulan">Kurang dari 2 Bulan</option>
                                                <option value="Kurang dari 3 Bulan">Kurang dari 3 Bulan</option>
                                                <option value="Kurang dari 4 Bulan">Kurang dari 4 Bulan</option>
                                                <option value="Kurang dari 5 Bulan">Kurang dari 5 Bulan</option>
                                                <option value="Kurang dari 6 Bulan">Kurang dari 6 Bulan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Reminder Checking Date</label>
                                            <input type="date" wire:model='reminderCheckingDate'
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Frequency Testing</label>
                                            <select class="form-select" wire:model='frequencyTesting'
                                                {{ $statusDetail == 'open' ? '' : 'disabled' }}>>
                                                <option value="sekali 6 bulan">sekali 6 bulan</option>
                                                <option value="sekali 1 tahun">sekali 1 tahun</option>
                                                <option value="sekali 2 tahun">sekali 2 tahun</option>
                                                <option value="sekali 3 tahun">sekali 3 tahun</option>
                                                <option value="sekali 4 tahun">sekali 4 tahun</option>
                                                <option value="sekali 5 tahun">sekali 5 tahun</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Reminder Testing Date</label>
                                            <input type="date" wire:model='reminderTestingDate'
                                                class="form-control" {{ $statusDetail == 'open' ? '' : 'readonly' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Reminder Schedule</label>
                                            <select wire:model='reminderSchedule' wire:change='reminderScheduleUpdate'
                                                class="form-control" {{ $statusDetail == 'open' ? '' : 'disabled' }}>
                                                <option value="-">-</option>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    </form>
                    <div class="example">
                        <h6>List Approval</h6>
                        <div class="row">
                            <div class="col-5 col-md-3">
                                <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist"
                                    aria-orientation="vertical">
                                    @foreach ($list_approval as $approval)
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                            id="v-{{ $approval->id }}-tab" data-toggle="pill"
                                            href="#v-{{ $approval->id }}" role="tab"
                                            aria-controls="v-{{ $approval->id }}"
                                            aria-selected="true">{{ $approval->fullname }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-7 col-md-9">
                                <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                                    @foreach ($list_approval as $approval)
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                            id="v-{{ $approval->id }}" role="tabpanel"
                                            aria-labelledby="v-{{ $approval->id }}-tab">
                                            <h6 class="mb-1">Approved Date :
                                                {{ date('d M Y', strtotime($approval->approved_at)) }}
                                            </h6>
                                            <p>{{ $approval->note }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    @if ($status == 'wait_dep' && session('id_position') == 'SECTHEAD')
                        <button type="button" wire:click="openApprove({{ $id }})"
                            class="btn btn-primary">Approve</button>
                        <button type="button" wire:click="reject" wire:loading.attr="disabled"
                            class="btn btn-danger">Reject</button>
                    @endif
                    @if ($status == 'wait_adm_legal' && session('id_position') == 'ADMIN' && session('id_section') == 'LEG')
                        <button type="button" wire:click="openApprove({{ $id }})"
                            class="btn btn-primary">Approve</button>
                        <button type="button" wire:click="reject" wire:loading.attr="disabled"
                            class="btn btn-danger">Reject</button>
                    @endif
                    @if ($status == 'wait_dep_hrd' && session('id_position') == 'SECTHEAD' && session('id_section') == 'HRD')
                        <button type="button" wire:click="openApprove({{ $id }})"
                            class="btn btn-primary">Approve</button>
                        <button type="button" wire:click="reject" wire:loading.attr="disabled"
                            class="btn btn-danger">Reject</button>
                    @endif
                    @if ($status == 'wait_adm_hse' && session('id_position') == 'ADMIN' && session('id_section') == 'HSE')
                        <button type="button" wire:click="openApprove({{ $id }})"
                            class="btn btn-primary">Approve</button>
                        <button type="button" wire:click="reject" wire:loading.attr="disabled"
                            class="btn btn-danger">Reject</button>
                    @endif
                    @if ($status == 'wait_dep_hse' && session('id_position') == 'SECTHEAD' && session('id_section') == 'HSE')
                        <button type="button" wire:click="openApprove({{ $id }})"
                            class="btn btn-primary">Approve</button>
                        <button type="button" wire:click="reject" wire:loading.attr="disabled"
                            class="btn btn-danger">Reject</button>
                    @endif
                    @if ($status == 'wait_budgetcontrol' && session('id_position') == 'BUSINESS_CONTROL')
                        <button type="button" wire:click="openApprove({{ $id }})"
                            class="btn btn-primary">Approve</button>
                        <button type="button" wire:click="reject" wire:loading.attr="disabled"
                            class="btn btn-danger">Reject</button>
                    @endif
                    @if ($status == 'in_progress_prpo' && session('id_position') == 'ADMIN' && session('id_section') == 'LEG')
                        <button type="button" wire:click="updatePRPO" wire:loading.attr="disabled"
                            class="btn btn-primary">Update License</button>
                        <button type="button" wire:click="reject" wire:loading.attr="disabled"
                            class="btn btn-danger">Reject</button>
                    @endif
                    @if ($status == 'need_re_license' && session('id_position') == 'ADMIN' && $id_section == session('id_section'))
                        <button type="button" wire:click="reqRenewal" wire:loading.attr="disabled"
                            class="btn btn-primary">Renewal License
                            License </button>
                    @endif
                    <button type="button" wire:click="exportpdf({{ $id }})" wire:loading.attr="disabled"
                        class="btn btn-info-muted">Print</button>
                </div>

            </div>
        </div>
    </div>
    @script
        <script>
            window.addEventListener('closeModal', event => {
                $('#modalDetail').modal('hide')
            })
        </script>
    @endscript
    <livewire:equipment.approval />
</div>
</div>
