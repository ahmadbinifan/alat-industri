<div>
    <div class="modal fade" wire:ignore.self id="modalUpdate" tabindex="-1" role="dialog"
        aria-labelledby="modalUpdateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Certifiate Regulation</h5>
                    <button type="button" wire:click='close' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="regulation_no">Regulation No</label>
                            <input type="text" wire:model="regulationNo" class="form-control"
                                placeholder="Regulation No.">
                            @error('regulationNo')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="regulation_desc">Regulation Description</label>
                            <textarea wire:model="regulationDesc" placeholder="Regulation Description" rows="3" class="form-control"></textarea>
                            @error('regulationDesc')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" wire:model="category" name="category" class="form-control"
                                placeholder="Category">
                            @error('category')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="document_k3">Document K3</label>
                            <input type="file" wire:model="documentK3" class="form-control">
                            @error('documentK3')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="check_frequency">Check Frequency</label>
                            <select class="form-select" wire:model="check_frequency">
                                <option value="sekali 6 bulan" selected>sekali 6 bulan</option>
                                <option value="sekali 1 tahun">sekali 1 tahun</option>
                                <option value="sekali 2 tahun">sekali 2 tahun</option>
                                <option value="sekali 3 tahun">sekali 3 tahun</option>
                                <option value="sekali 4 tahun">sekali 4 tahun</option>
                                <option value="sekali 5 tahun">sekali 5 tahun</option>
                            </select>
                            {{-- <input type="text" wire:model="check_frequency" name="check_frequency"
                                class="form-control" id="check_frequency" placeholder="Check Frequency"> --}}
                            @error('check_frequency')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="update" wire:loading.attr="disabled"
                        class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('closeModal', event => {
        $('#modalUpdate').modal('hide')
    })
</script>
