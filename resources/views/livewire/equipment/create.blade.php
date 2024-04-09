<div>
    @push('plugin-styles')
        <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
        <style>
            .bigdrop {
                width: 600px !important;
            }
        </style>
    @endpush
    <div class="modal fade" wire:ignore.self id="modalCreate" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Equipment License</h5>
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
                                        <select wire:model="company" class="form-control">
                                            <option value="-">Select Company</option>
                                            @foreach ($companies as $value)
                                                <option value="{{ $value->name }}">
                                                    {{ $value->alias . ' - ' . $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Filling Date</label>
                                        <input type="date" wire:model="fillingDate" class="form-control">
                                        @error('fillingDate')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" wire:ignore>
                                    <div class="form-group">
                                        <label>Tag Number Asset</label>
                                        <select class="form-select" id="tagnumbers" style="width: 100%"
                                            wire:model="tagnumber" id="tagnumber" name="tagNumber">
                                            @foreach ($tag_number as $value)
                                                <option value="{{ $value->tag_number }}">{{ $value->tag_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tagNumber')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
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
                                        <select class="form-control" id="idRegulation" wire:model="idRegulation"
                                            style="width: 100%">
                                            <option value="-">NA.</option>
                                            @foreach ($regulation as $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->regulation_no . ' - ' . $value->regulation_desc }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('idRegulation')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Inpection</label>
                                        <input type="date" wire:model="lastInspection" class="form-control">
                                        @error('lastInspection')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label>Document Requirements</label>
                                    <input type="file" wire:model="documentRequirements" class="form-control">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="draft" wire:loading.attr="disabled"
                        class="btn btn-warning">Draft</button>
                    <button type="button" wire:click="add" wire:loading.attr="disabled"
                        class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('closeModal', event => {
        $('#modalCreate').modal('hide')
    })
</script>

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush
@push('custom-scripts')
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush
