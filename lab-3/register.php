<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>Signup</title>
</head>
<body>
  <div class="bg-light d-flex align-items-center justify-content-center" style="height: 90vh;">
    <div class="container">
      <div class="row mt-5">
        <div class="col-lg-4 bg-white m-auto rounded-top wrapper shadow p-100">
          <h2 class="text-center pt-3">Signup Now</h2>

          <!-- Display error message if it exists -->
          <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $_GET['error']; ?>
            </div>
          <?php endif; ?>

          <!-- Display success message if it exists -->
          <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
              <?php echo $_GET['success']; ?>
            </div>
          <?php endif; ?>

          <!-- Signup form -->
          <form class="form-signup" action="mailer.php" method="post">
            <div class="input-group mb-3 pt-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname:" pattern="^[a-zA-Z\s]*$" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname:" pattern="^[a-zA-Z\s]*$" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middlename:" pattern="^[a-zA-Z\s]*$" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username:" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password:" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="email" name="email" placeholder="Email:" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" id="status" name="status" placeholder="Status:" required>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="termsCheckbox">
              <label class="form-check-label" for="termsCheckbox">  
                I agree to the <a href="#">Terms and Conditions</a>
              </label>
            </div>
            <div class="d-grid pt-3">
              <button type="submit" name="submit" class="btn btn-success">Signup Now</button>
            </div>
            <div class="text-center pt-3">
              Already have an account? <a href="Loginform.php">Login Here</a>
            </div>
            <div class="pt-3"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
