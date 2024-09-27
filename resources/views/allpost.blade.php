<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="containe">
        <div class="row">
            <div class="col-8 bg-primary text-white mb-4">
                <h1>All Posts</h1>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-8">
                <a href="/addpost" class="btn btn-sm btn-primary"> Add New</a>
                <button class="btn btn-sm btn-danger" id="logoutbtn">LogOut</button>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div id="postcontainer">
                   
                </div>
            </div>
        </div>
    </div>

<!-- Modal for veiw post -->
<div class="modal fade" id="singlepostmodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="singlepostLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="singlepostLabel">Single Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal for update post-->
<div class="modal fade" id="updatepostmodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatepostLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateepostLabel">Update Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateform">
      <div class="modal-body">
       
        <input type="hidden" id="postid" class="form-control " value="">
        <b>Title </b><input type="text" id="posttitle" class="form-control" value="">
        <b>Discription </b><input type="text" id="postdiscription" class="form-control" value="">
        <img id="showimage" width="150px">
        <p> Upload Image </p> <input type="file" id="postimage" class="form-control">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary me-5" value="save changes">
      </div>
    </form>
    </div>
  </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        document.querySelector("#logoutbtn").addEventListener('click', function() {
          const token = localStorage.getItem('token_api');
          fetch('/api/logout', {
            method: 'POST',
            headers: {
              Authorization: `Bearer ${token}`,
            }
          })
          .then(response => response.json())
          .then(data => {
            // console.log(data);
            window.location.href = "http://localhost:8000/";
          });
        });

        function loaddata(){
            const token = localStorage.getItem('token_api'); 
            fetch('/api/posts', {
            method: 'GET',
            headers: {
              Authorization: `Bearer ${token}`,
            }
          })
          .then(response => response.json())
          .then(data => {
            // console.log(data.data.posts);
            const postcontainer = document.querySelector("#postcontainer");

                var allpost = data.data.posts;
            var tabledata = `<table class="table table-bordered">
                          <tr class="table-dark">
                            <th>Image</th>
                            <th>Title</th>
                            <th>Discription</th>
                            <th>View</th>
                            <th>Update</th>
                            <th>Delete</th>
                          </tr>`;
                          allpost.forEach(post => {
                            tabledata+=` <tr>
                            <td> <img src="/uploads/${post.image} " width="60px"></td>
                            <td> <h5>${post.title} </h5></td>
                            <td> <p>${post.discription}</p></td>
                            <td><button class="btn btn-sm btn-primary" data-bs-postid="${post.id}" data-bs-toggle="modal" data-bs-target="#singlepostmodel">Veiw</button></td>
                            <td><button class="btn btn-sm btn-success" data-bs-postid="${post.id}" data-bs-toggle="modal" data-bs-target="#updatepostmodel">Update</button></td>
                            <td><button onClick="deletpost(${post.id})" class="btn btn-sm btn-danger">Delete</button></td>
                          </tr>`;
                          });
                          
                          tabledata+= `</table>`;
                          postcontainer.innerHTML =  tabledata;
          });
        }
        loaddata();

        //open single post code
        var singlemodel = document.querySelector("#singlepostmodel");
        singlemodel.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget

  const modelbody = document.querySelector("#singlepostmodel .modal-body");
  modelbody.innerHTML = "";

  var id = button.getAttribute('data-bs-postid')
  const token = localStorage.getItem('token_api');
  fetch(`/api/posts/${id}`, {
            method: 'GET',
            headers: {
              Authorization: `Bearer ${token}`,
              contentType: 'application/json',
            }
          })
          .then(response => response.json())
          .then(data => {
           const post = data.data.post[0];
           
           modelbody.innerHTML = `
          <div class="bg-primary text-center text-white rounded p-3"> TITLE : ${post.title} </div>
           <br>
            <div class="bg-primary text-center text-white rounded p-3">  DISCRIPTION : ${post.discription} </div>
          
           <br>
           <div class="d-flex justify-content-center align-item-center"> <img width="150px"; src="http://localhost:8000/uploads/${post.image}"></div>
           `;
          });
    });

      //show single post code in form
      var updatemodel = document.querySelector("#updatepostmodel");
      updatemodel.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget

  // const modelbody = document.querySelector("#singlepostmodel .modal-body");
  // modelbody.innerHTML = "";

  var id = button.getAttribute('data-bs-postid');

  const token = localStorage.getItem('token_api');

  fetch(`/api/posts/${id}`, {
            method: 'GET',
            headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json',
                      }
          })
          .then(response => response.json())
          .then(data => {
           const post = data.data.post[0];
           
            document.querySelector("#postid").value = post.id;
            document.querySelector("#posttitle").value = post.title;
            document.querySelector("#postdiscription").value = post.discription;
           document.querySelector("#showimage").src = `/uploads/${post.image}`;
          });
    });

    // now update data
    var updateform = document.querySelector("#updateform");
    updateform.addEventListener("submit", async (e) => {
  e.preventDefault();

  const token = localStorage.getItem('token_api');
  const postid = document.querySelector("#postid").value;
  const title = document.querySelector("#posttitle").value;
  const discription = document.querySelector("#postdiscription").value;
 
  

  var formdata = new FormData();
  formdata.append('id', postid);
  formdata.append('title', title);
  formdata.append('discription', discription);

  if(!document.querySelector("#postimage").files[0] == ""){
    const image = document.querySelector("#postimage").files[0];
    formdata.append('image', image);
  }

  let response = await fetch(`/api/posts/${postid}`, {
    method: 'POST',
    body:formdata,
    headers: {
      Authorization: `Bearer ${token}`,
      'X-HTTP-method-override': 'PUT',
    },
    body: formdata,
  })
  .then(response => response.json())
  .then(data => {
    //  console.log(data);
 window.location.href = "http://localhost:8000/allpost";
  })
  .catch(error => console.error('Error:', error));
});

// delet post here
async function deletpost(postid){
  const token = localStorage.getItem('token_api');

  let response = await fetch(`/api/posts/${postid}`, {
    method: 'DELETE',
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })
  .then(response => response.json())
  .then(data => {
      // console.log(data);
window.location.href = "http://localhost:8000/allpost";
  })
}
</script>,
</body>
</html>