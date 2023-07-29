<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <form id="insertData" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="name">
                                <label class="form-label">Category *</label>
                                <select class="form-control" name="cat_id" id="cat_id">
                                    <option value="">Select Category</option>
                                </select>
                                <label class="form-label">Unit</label>
                                <select class="form-control" name="unit_id" id="unit_id">
                                    <option value="">Select Unit</option>
                                </select>
                                <label class="form-label">Price *</label>
                                <input type="text" class="form-control" id="price">
                                <label class="form-label">Category</label>
                                <label class="form-label">Image *</label>
                                <input type="file" class="form-control" id="img_url">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>

        getUnit();
        getCategory();

    async function getUnit() {

        showLoader();
        let res = await axios.get("/product-unit");
        hideLoader();

        let unit_id = $('#unit_id');

        res.data.forEach(function (item, index) {
            let row = `<option value="${item['id']}">${item['unit_name']}</option>`;
            unit_id.append(row);
        });

    }

    async function getCategory() {

        showLoader();
        let res = await axios.get("/product-category");
        hideLoader();

        let cat_id = $('#cat_id');

        res.data.forEach(function (item, index) {
            let row = `<option value="${item['id']}">${item['cat_name']}</option>`;
            cat_id.append(row);
        });

    }

    $("#insertData").on('submit',async function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let price = $('#price').val();
        let cat_id = $('#cat_id').val();
        let unit_id = $('#cat_id').val();
        let img_url = $('#img_url').val();

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
            $('#create-modal').modal('hide');
            let formData={name:name,price:price,cat_id:cat_id,unit_id:unit_id,img_url:img_url}
            showLoader();
            let res = await axios.post("/create-product",formData);
            hideLoader();
            if(res.status===201){
                successToast('Product Created Successfully!');
                $("#insertData").trigger("reset");
                await getList();
            }
            else{
                errorToast("Request fail !");
            }

        }

    });


</script>
