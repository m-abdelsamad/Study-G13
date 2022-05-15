const csrf_token = document.querySelector('meta[name="csrf_token"]').content
const url = document.querySelector('meta[name="base_url"]').content



//let currentUser;


//register user
function registerUser(){
    var name = $('#registration_form .form-control.name').val();
    var email = $('#registration_form .form-control.email').val();
    var password = $('#registration_form .form-control.password').val();
    var uni_name = $('#registration_form .form-control.uni_name').val();
    var hrs_per_day = $('#registration_form .form-control.hrs_per_day').val();
    var hrs_per_week = $('#registration_form .form-control.hrs_per_week').val();


    const userData = {
        name: name,
        email: email,
        uni_name: uni_name,
        hrs_per_day: hrs_per_day,
        hrs_per_week: hrs_per_week,
        password: password,
    }

    $.ajax({
        type:"POST",
        url: `${url}/register`,
        dataType:"json",
        headers: {
            'X-CSRF-Token': csrf_token, 
        },
        data: userData,
        success: function(response){
            if(response.success && response.status == 200){
                //set current user
                let currentUser = response.user;
                console.log("user data", currentUser);

                usersCollection.doc(currentUser.key).set(currentUser);
                window.location.href = `${url}/dashboard`;

            } else if(!response.success && response.status == 406){
                console.log('PLease enter valid data')
                console.log(response.errors);
            } else {
                console.log('Something went wrong');
            }
        },
        error: function(xhr, textStatus, thrownError) {
            console.log(xhr);
            console.log(textStatus);
            console.log(thrownError);


            $("#exampleModal2 .modal-body").append(`
            <div class="alert alert-danger mt-2" role="alert">
                <p>${xhr.responseJSON.message}</p>
            </div>
            `)
            $('#exampleModal2').modal('show');
        },
    }) 
    

}
//end register user




//login user
function loginUser(){
    var email = $('#login_form .form-control.email').val();
    var password = $('#login_form .form-control.password').val();

    const userData = {
        email: email,
        password: password,
    }

    $.ajax({
        type:"POST",
        url: `${url}/login`,
        dataType:"json",
        headers: {
            'X-CSRF-Token': csrf_token, 
        },
        data: userData,
        success: function(response){
            if(response.success && response.status == 200){
                //set current user
                let currentUser = response.user;
                console.log("user data", currentUser);
                window.location = `${url}/discussionBoard`;

            } else if(!response.success && response.status == 401){
                console.log('Invalid credentials')
            } else {
                console.log('Invalid input');
            }
        }
    }) 
}
//end login user


//get Current User
const getCurrentUser = new Promise(function(resolve){
    $.ajax({
        type: 'GET',
        url: `${url}/getUser`,
        dataType:"json",
        headers: {
            'X-CSRF-Token': csrf_token, 
        },
        success: function(response){
            if(response.status == 200){
                resolve(response.user);
            }
        }
    });
    //return user;
})
//end get Current User


function validateRigesterForm(){
    $('#registration_form').validate({
        rules: {
            'name': {required: true},
            'email': {required: true, email: true,},
            'password': {required: true,},
            'uni_name': {required: true,},
            'hrs_per_day': {required: true, min: 1, max: 24,},
            'hrs_per_day': {required: true, min: 24, max: 68,}
        },
        messages: {
            'name': {required: "This feild is required",},
            'email': {
                required: "This feild is required",
                email: "Please enter a valid email address",
            },
            'password': {required: "This feild is required",},
            'uni_name': {required: "This feild is required",},
            'hrs_per_day': {
                required: "This feild is required",
                min: "Please enter a number between 1 and 24",
                max: "Please enter a number between 1 and 24"
            },
            'hrs_per_day': {
                required: "This feild is required",
                min: "Please enter a number between 24 and 168",
                max: "Please enter a number between 24 and 168",
            },
        }
    })
}

$(document).ready(function(){

    $('.login_user_btn').click(function(event){
        event.preventDefault();
        if($("#login_form").valid()){
            loginUser();
        }
    })


        
    $('.register_user_btn').click(function(){
        //event.preventDefault();
        //validateRigesterForm();
        if($("#registration_form").valid()){
            registerUser();
        }
    })

});




