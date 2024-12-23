<!-- Modal -->
<div class="modal fade rounded-3xl" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog rounded-3xl modal-dialog-centered" role="document">
        <div class="modal-content rounded-3xl p-12 pb-8">
            <form action="{{ route('user.delete') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" id="delete_id">
 
                <div class="modal-body text-3xl font-bold">
                    <center>
                        <h1 class="mb-2">Are You Sure?</h1>
                        <h6 class="text-xl mb-2">You want to Delete the user!</h6>
                    </center>
                </div>
                <div class="row" style="margin-bottom: 50px; text-align: center;">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-danger btn-modal" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success btn-modal">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>