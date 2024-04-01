<div>
    <div class="modal fade" wire:ignore.self id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Certifiate Regulation</h5>
                    <button type="button" wire:click='close' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form class="forms-sample" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="regulation_no">Regulation No</label>
                            <input type="text" wire:model="regulation_no" name="regulation_no" class="form-control"
                                id="regulation_no" placeholder="Regulation No.">
                            @error('regulation_no')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="regulation_desc">Regulation Description</label>
                            <textarea name="regulation_desc" wire:model="regulation_desc" name="regulation_desc"
                                placeholder="Regulation Description" id="regulation_desc" rows="3" class="form-control"></textarea>
                            @error('regulation_desc')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" wire:model="category" name="category" class="form-control"
                                id="category" placeholder="Category">
                            @error('category')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="document_k3">Document K3</label>
                            <input type="file" wire:model="document_k3" name="document_k3" class="form-control"
                                id="document_k3">
                            @error('document_k3')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="check_frequency">Check Frequency</label>
                            <input type="date" wire:model="check_frequency" name="check_frequency"
                                class="form-control" id="check_frequency" placeholder="Check Frequency">
                            @error('check_frequency')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
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
        $('#exampleModal').modal('hide')
    })
</script>

</div>
