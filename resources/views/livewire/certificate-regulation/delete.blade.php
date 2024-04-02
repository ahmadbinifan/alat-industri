<div>
    <div class="modal fade" wire:ignore.self id="modalDelete" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Destroy Certificate Regulation </h5>
                    <button type="button" wire:click='close' class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="forms-sample">
                        <label>Are You Sure? for delete this Certificate Regulation?</label>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="delete" wire:loading.attr="disabled"
                        class="btn btn-danger">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('closeModal', event => {
        $('#modalDelete').modal('hide')
    })
</script>
