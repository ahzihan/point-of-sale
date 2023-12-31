<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h5>Sale List</h5>
                </div>
                <div class="align-items-center col">
                    <a href="{{url("/salePage")}}" class="float-end btn m-0 bg-gradient-primary">Create Sale</a>
                </div>
            </div>
            <hr class="bg-dark"/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Vat</th>
                    <th>SD</th>
                    <th>Discount</th>
                    <th>Payable</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>

getList();


async function getList() {


    showLoader();
    let res=await axios.get("/sale-select");
    hideLoader();

    let tableList=$("#tableList");
    let tableData=$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.forEach(function (item,index) {

        let row=`<tr>
                    <td>${index+1}</td>
                    <td>${item['cus_name']}</td>
                    <td>${item['mobile']}</td>
                    <td>${item['total']}</td>
                    <td>${item['vat']}</td>
                    <td>${item['sd']}</td>
                    <td>${item['discount']}</td>
                    <td>${item['payable']}</td>
                    <td>
                        <button data-id="${item['id']}" data-cus="${item['cus_id']}" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm fa-eye"></i></button>
                        <button data-id="${item['id']}" data-cus="${item['cus_id']}" class="deleteBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm  fa-trash-alt"></i></button>
                    </td>
                 </tr>`
        tableList.append(row)
    })

    $('.viewBtn').on('click', async function () {
        let id= $(this).data('id');
        let cus= $(this).data('cus');
        await InvoiceDetails(cus,id);
    })

    $('.deleteBtn').on('click',function () {
        let id= $(this).data('id');
        $('#deleteID').val(id);
        $("#delete-modal").modal('show');
    })

    tableData.DataTable({
          order: [[0, 'desc']],
          lengthMenu: [10,15,20,25,30,35,40,45,50],
          language:{
            paginate:{
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←'
            }}
      });

}


</script>

