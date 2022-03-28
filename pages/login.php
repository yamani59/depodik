<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href=<?= BASEURL . "pages/style/css/bootstrap.css" ?>>
  <title>login</title>
</head>

<body>
  <div class="container-fluid d-flex justify-content-center align-items-center m-0 p-0 bg-dark" style="
      height: 100vh;
      width: 100%;
    ">
    <div class="form-container shadow-lg p-3 border rounded" style="
        width: 50%;
        background: #3a3845;
      ">
      <div class="row p-4">
        <div class="row" style="
          color: white;
        ">
          <p class="fs-1">LOGIN</p>
        </div>
        <div class="col-3 bg-warning">

        </div>
        <div class="col">
          <form action="" method="post" class="form">
            <div class="form-floating mb-3">
              <input type="text" name="username" class="form-control">
              <label for="">Username</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" name="password" class="form-control">
              <label for="">Password</label>
            </div>
            <a href=<?= BASEURL . 'logic/register.php' ?> style="color: white; text-decoration: none">Belum punya akun</a>
            <div class="form-group d-flex justify-content-end" style="
              width: 100%;
              ">
              <input type="submit" style="width: 40%" value="Submit" class="form-control btn btn-warning">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>