<!doctype html>
<html lang="en">
  <head>
    <title>Resident Search</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css">

  </head>
  <body class = "body1">

    <div class="container">
      <h1 class= "serh1">🔍 Resident Search</h1>

      <div>
        <form class="search-boxx" method="POST" action="search_result.php">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="fullname" class="form-label"></label>
              <input type="text" class="form-control" name="full_name" id="fullname" placeholder="Enter full name">
            </div>

            <div class="col-md-4">
              <label for="nic" class="form-label"></label>
              <input type="text" class="form-control" name ="NIC" id="nic" placeholder="Enter NIC number">
            </div>

            <div class="col-md-4">
              <label for="address" class="form-label"></label>
              <input type="text" class="form-control" name ="addr" id="address" placeholder="Enter address">
            </div>
          </div>
<br><br>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Search</button>
<br><br><br><br>
            <a href="index.html" class="btn btn-outline-secondary">Go To Home</a>
          </div>
        </form>
      </div>
    </div>

  </body>
</html>
