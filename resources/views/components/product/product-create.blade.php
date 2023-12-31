<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="insertData">
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
                                <select class="form-control" name="cat_id" id="categoryID">
                                    <option value="">Select Category</option>
                                </select>
                                <label class="form-label">Unit</label>
                                <select class="form-control" name="unit_id" id="unitID">
                                    <option value="">Select Unit</option>
                                </select>
                                <label class="form-label">Price *</label>
                                <input type="text" class="form-control" id="price">

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image *</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">
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

    async function getUnit(){
        let res = await axios.get("/list-unit")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['unit_name']}</option>`
            $("#unitID").append(option);
        })
    }

    async function getCategory(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['cat_name']}</option>`
            $("#categoryID").append(option);
        })
    }


    $("#insertData").on('submit', async function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let price = $('#price').val();
        let cat_id = $('#categoryID').val();
        let unit_id = $('#unitID').val();
        let img_url = document.getElementById('productImg').files[0];

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
        }else if(!img_url){
            errorToast("Image Field Required !");
        } else {

            $('#create-modal').modal('hide');

            let formData=new FormData();
            formData.append('img_url',img_url)
            formData.append('name',name)
            formData.append('price',price)
            formData.append('cat_id',cat_id)
            formData.append('unit_id',unit_id)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/create-product",formData,config);
            hideLoader();

            if(res.status===201){
                successToast('Product Created Successfully!');
                $("#insertData").trigger("reset");
                getList();
            }
            else{
                errorToast("Request fail !");
            }

        }

    });


</script>
