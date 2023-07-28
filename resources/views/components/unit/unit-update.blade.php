<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="updateForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Unit</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Unit Name *</label>
                                <input type="text" class="form-control" id="updateUnitName">
                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a  class="btn  btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</a>
                    <button type="submit" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    async function FillUpUpdateForm(id){
        $('#updateID').val(id);
        showLoader();
        let res=await axios.post("/edit-unit",{id:id});
        // console.log(res.data['unit_name']);
        hideLoader();
        $('#updateUnitName').val(res.data['unit_name']);
    }

    $("#updateForm").on('submit',async function (e) {
        e.preventDefault();

        let updateUnitName = $('#updateUnitName').val();
        let updateID = $('#updateID').val();

        if (updateUnitName.length === 0) {
            errorToast("Unit Name Required !");
        }
        else {
            $('#update-modal').modal('hide');
            showLoader();
            let res = await axios.post("/update-unit",{unit_name:updateUnitName,id:updateID})
            hideLoader();

            if(res.status===200 && res.data===1){
                successToast('Unit Updated Successfully!');
                $("#updateForm").trigger("reset");
                await getList();
            }
            else{
                errorToast("Request fail !");
            }
        }

    });

</script>
