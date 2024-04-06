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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Owner Asset</label>
                                        <input type="text" wire:model="ownerAsset" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                        <input type="date" wire:model="lastInspection" class="form-control" readonly>
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
                            @if($status == 'in_progress_prpo' || $status == 'license_running' || $status == 'wait_dep_hrd')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>License No</label>
                                        <input type="text" wire:model='licenseNo' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>License From</label>
                                        <input type="text" wire:model='licenseFrom' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Issued Date Document</label>
                                        <input type="date" wire:model='issuedDateDocument' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Last License Date</label>
                                        <input type="date" wire:model='lastLicenseDate' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Reminder Checking Date</label>
                                        <input type="date" wire:model='reminderCheckingDate' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Reminder Testing Date</label>
                                        <input type="date" wire:model='reminderTestingDate' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Frequency Check</label>
                                        <input type="text" wire:model='frequencyCheck' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Repeat license</label>
                                        <input type="date" wire:model='reLicense' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Frequency Testing</label>
                                        <input type="text" wire:model='frequencyTesting' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Repeat License Testing</label>
                                        <input type="date" wire:model='reLicenseTesting' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Reminder Schedule</label>
                                    <select wire:model='reminderSchedule' wire:change='reminderScheduleUpdate' class="form-control" {{$statusDetail=='close'?'readonly':''}}>
                                        <option value="-">-</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            @if ($status == 'wait_dep' && session('id_position') == 'SECTHEAD')
                                <button type="button" wire:click="openApprove({{ $id }})"
                                    class="btn btn-primary">Approve</button>
                                <button type="button" wire:click="reject" wire:loading.attr="disabled"
                                    class="btn btn-danger">Reject</button>
                            @endif
                            @if ($status == 'wait_adm_legal' && session('id_position') == 'ADMIN' && session('id_section') == "LEG")
                                <button type="button" wire:click="openApprove({{ $id }})"
                                    class="btn btn-primary">Approve</button>
                                <button type="button" wire:click="reject" wire:loading.attr="disabled"
                                    class="btn btn-danger">Reject</button>
                            @endif
                            @if ($status == 'wait_dep_hrd' && session('id_position') == 'SECTHEAD' && session('id_section') == "HRD")
                                <button type="button" wire:click="openApprove({{ $id }})"
                                    class="btn btn-primary">Approve</button>
                                <button type="button" wire:click="reject" wire:loading.attr="disabled"
                                    class="btn btn-danger">Reject</button>
                            @endif
                            @if ($status == 'wait_adm_hse' && session('id_position') == 'ADMIN' && session('id_section') == "HSE")
                                <button type="button" wire:click="openApprove({{ $id }})"
                                    class="btn btn-primary">Approve</button>
                                <button type="button" wire:click="reject" wire:loading.attr="disabled"
                                    class="btn btn-danger">Reject</button>
                            @endif
                            @if ($status == 'wait_dep_hse' && session('id_position') == 'SECTHEAD' && session('id_section') == "HSE")
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
                            @if ($status == 'in_progress_prpo' && session('id_position') == 'ADMIN' && session('id_section') == 'LEG' )
                            <button type="button" wire:click="updatePRPO"
                                class="btn btn-primary">Update License</button>
                            <button type="button" wire:click="reject" wire:loading.attr="disabled"
                                class="btn btn-danger">Reject</button>
                             @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <livewire:equipment.approval />
    </div>
