<div>
    <div class="modal fade" wire:ignore.self id="modalApproval" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approval Equipment License</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample">
                        @csrf
                        <div class="col-md-12 ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Leave a note</label>
                                        <textarea wire:model="note" class="form-control" rows="3"></textarea>
                                        @error('note')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    @if (session('id_section') == 'LEG' && session('id_position') == "ADMIN")
                                        <div class="form-group">
                                            <label>Estimated Cost</label>
                                            <input type="text" wire:model="estimatedCost" class="form-control">
                                        </div>
                                    @endif
                                    @if (session('id_section') == 'HSE' && session('id_position') == "ADMIN")
                                        <div class="form-group">
                                            <label>Attachment</label>
                                            <input type="file" wire:model="attachFromHSE" class="form-control">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="approved({{ $id }})" wire:loading.attr="disabled"
                        class="btn btn-primary">Approved</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('openApprove', event => {
            $("#modalApproval").modal('show');
        })
        window.addEventListener('closeModal', event => {
            $("#modalApproval").modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $("#modalDetail").modal('hide');
        })
    </script>
</div>
