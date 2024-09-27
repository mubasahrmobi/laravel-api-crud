<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    
        <div class="container">
            <div class="head col-8 bg-primary p-3 rounded text-center text white mb-4">
                <h1>Create Post</h1>
            </div>
            <div class="row">
                <div class="col-8">
                    <form id="addform">
                          <input type="text" class="form-control mb-3" id="title" placeholder="Enter Title" name="title">
                          <textarea class="form-control mb-3" rows="2" id="discription" name="discription" placeholder="Enter Disription"></textarea>
                          <input type="file" class="form-control mb-3" id="image"  name="image">
                          <input type="submit" class="btn btn-primary me-5">
                          <a href="/allpost" class="btn btn-dark">Back</a>
                      </form>
                </div>
            </div>
        </div>

<script>
    var addform = document.querySelector("#addform");
addform.addEventListener("submit", async (e) => {
  e.preventDefault();

  const token = localStorage.getItem('token_api');
  const title = document.querySelector("#title").value;
  const discription = document.querySelector("#discription").value;
  const image = document.querySelector("#image").files[0];

  var formdata = new FormData();
  formdata.append('title', title);
  formdata.append('discription', discription);
  formdata.append('image', image);

  let response = await fetch('/api/posts', {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${token}`,
    },
    body: formdata,
  })
  .then(response => response.json())
  .then(data => {
    // console.log(data);
 window.location.href = "http://localhost:8000/allpost";
  })
  .catch(error => console.error('Error:', error));
});
</script>

</body>
</html>