<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h2>Signup</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-3">
                            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm password" name="confirm_password">
                        </div>
                        <button type="submit" class="btn btn-primary" id="signupbtn">Signup</button>
                    </div> 
                    <div class="card-footer">Footer</div>
                </div>
            </div>
        </div>
    </div>
    
    <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  <script>
    $(document).ready(function(){
        $("#signupbtn").on('click',function(){
            const name = $("#name").val();
            const email = $("#email").val();
            const password = $("#password").val();
            const confirm_password = $("#confirm_password").val();
            if(password !== confirm_password){
                alert('Passwords do not match');
                return;
            }
            $.ajax({
                url: '/api/signup',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                }),
                success: function(response){
                    console.log(response);
                    localStorage.setItem('token_api',response.token)
                    window.location.href = "http://localhost:8000/";
                },
                error:function(xhr,status,error){
                    alert('Error' + xhr.responseText);
                }
            });
        });
    });
  </script>
</body>
</html>