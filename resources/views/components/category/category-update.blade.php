<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="updateForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categryName">
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
        let res=await axios.post("/edit-category",{id:id})
        hideLoader();
        $('#categryName').val(res.data['cat_name']);
    }

    $("#updateForm").on('submit',async function (e) {
        e.preventDefault();

        let categryName = $('#categryName').val();
        let updateID = $('#updateID').val();

        if (categryName.length === 0) {
            errorToast("Category Name Required !");
        }
        else {
            $('#update-modal').modal('hide');
            showLoader();
            let res = await axios.post("/update-category",{cat_name:categryName,id:updateID})
            hideLoader();

            if(res.status===200 && res.data===1){
                successToast('Category Updated Successfully!');
                $("#updateForm").trigger("reset");
                await getList();
            }
            else{
                errorToast("Request fail !");
            }
        }

    });

</script>
