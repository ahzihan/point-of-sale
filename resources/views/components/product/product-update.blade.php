<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="updateForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="productNameUpdate">
                                <label class="form-label">Category *</label>
                                <select class="form-control" name="cat_id" id="categoryUpdate">
                                    <option value="">Select Category</option>
                                </select>
                                <label class="form-label">Unit</label>
                                <select class="form-control" name="unit_id" id="unitUpdate">
                                    <option value="">Select Unit</option>
                                </select>
                                <label class="form-label">Price *</label>
                                <input type="text" class="form-control" id="productPriceUpdate">
                                <label class="form-label">Category</label>
                                <label class="form-label">Image *</label>
                                <input type="file" class="form-control" id="productImgUpdate">
                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button class="btn btn-sm  btn-success" >Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>



    async function getUnit(){
        let res = await axios.get("/list-unit")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['unit_name']}</option>`
            $("#unitUpdate").append(option);
        })
    }

    async function getCategory(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['cat_name']}</option>`
            $("#categoryUpdate").append(option);
        })
    }

    async function FillUpUpdateForm(id){
        $('#updateID').val(id);
        showLoader();
        await getUnit();
        await getCategory();
        let res=await axios.post("/edit-product",{id:id})
        hideLoader();
        $('#productNameUpdate').val(res.data['name']);
        $('#productPriceUpdate').val(res.data['price']);
        $('#categoryUpdate').val(res.data['cat_id']);
        $('#unitUpdate').val(res.data['unit_id']);
    }


    $("#updateForm").on('submit',async function (e) {
        e.preventDefault();

        let name = $('#productNameUpdate').val();
        let price = $('#productPriceUpdate').val();
        let cat_id = $('#categoryUpdate').val();
        let unit_id = $('#unitUpdate').val();
        let img_url = document.getElementById('productImgUpdate').files[0];

        if (name.length === 0) {
            errorToast("Product Name Required !");
        }
        else if(price.length===0){
            errorToast("Product Price Required !");
        }
        else if(cat_id.length===0){
            errorToast("Product Category Required !");
        }
        else if(unit_id.length===0){
            errorToast("Product Unit Required !");
        } else {
            $('#update-modal').modal('hide');
            let updateFormData=new FormData();
            updateFormData.append('img_url',img_url)
            updateFormData.append('name',name)
            updateFormData.append('price',price)
            updateFormData.append('cat_id',cat_id)
            updateFormData.append('unit_id',unit_id)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            showLoader();
            let res = await axios.post("/update-product",updateFormData,config);
            hideLoader();
            if(res.status===200 && res.data===1){
                successToast('Product Updated Successfully!');
                $("#updateForm").trigger("reset");
                await getList();
            }
            else{
                errorToast("Request fail !");
            }

        }

    });


</script>
