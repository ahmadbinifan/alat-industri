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
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if ($status == 'wait_dep' && session('id_position') == 'SECTHEAD')
                                <button type="button" wire:click="openApprove({{ $id }})"
                                    class="btn btn-primary">Approve</button>
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
