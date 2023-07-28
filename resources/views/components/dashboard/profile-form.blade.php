<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email" readonly/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdateProfile()" class="btn mt-3 w-100  btn-primary">Save Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    ProfileDetails();
    async function ProfileDetails() {

        showLoader();
        let res=await axios.get('/user-details');
        hideLoader();

        if(res.status===200 && res.data['status']==='success'){
            let data=res.data['data'];
            $('#email').val(data['email']);
            $('#firstName').val(data['firstName']);
            $('#lastName').val(data['lastName']);
            $('#mobile').val(data['mobile']);
            $('#password').val(data['password']);
        }else{
            errorToast(res.data['message']);
        }
    }

  async function onUpdateProfile() {


        let firstName = $('#firstName').val();
        let lastName = $('#lastName').val();
        let mobile = $('#mobile').val();
        let password = $('#password').val();


        if(firstName.length===0){
            errorToast('First Name is required')
        }
        else if(lastName.length===0){
            errorToast('Last Name is required')
        }
        else if(mobile.length===0){
            errorToast('Mobile is required')
        }else if(mobile.length < 11){
            errorToast("Mobile should be at least 11 character");
        }
        else if(password.length===0){
            errorToast("Password is required");
        }
        else if(password.length < 5){
            errorToast("Password should be at least 5 character");
        }
        else{
            showLoader();
            let res=await axios.post("/user-update",{
                firstName:firstName,
                lastName:lastName,
                mobile:mobile,
                password:password
            })
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                setTimeout(function (){
                   ProfileDetails();
                },2000)
            }
            else{
                errorToast(res.data['message'])
            }
        }
    }
</script>
