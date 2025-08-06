<!-- Untuk Login -->
<?php 
include "service/db.php";

session_start();

$login_message = "";

if(isset($_SESSION['is_login'])){
  header("location: signIn.php");
  exit;
}

if(isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $hash_password = hash("sha256", $password);

  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hash_password'";

  $result = $db->query($sql);

  if($result->num_rows > 0) {
    $data = $result->fetch_assoc();
      $_SESSION['username'] = $data['username'];
      $_SESSION['is_login'] = true;

    header("location: signIn.php");
    exit;
  } else {
    $_SESSION['login_message'] = "Akun Tidak Ditemukan";
    header("location: index.php");
    exit;
  }
  $db->close();
}
?>

<!-- Untuk Register -->
<?php
$register_message = "";

if(isset($_POST['register'])) {
  $usernameReg = $_POST['username'];
  $passwordReg = $_POST['password'];

  $hash_passwordReg = hash("sha256", $passwordReg);

  try {
    $sql = "INSERT INTO users (username, password) VALUES ('$usernameReg', '$hash_passwordReg')";
  
    if($db->query($sql)) {
      $register_message = "Daftar Akun Berhasil, Silahkan Login";
    } else {
      $register_message = "Daftar Akun Gagal, Silahkan Coba Lagi";
    }

  }catch(mysqli_sql_exception) {
    $register_message = "Username Sudah Digunakan";
  }
  $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
    <script
      src="https://kit.fontawesome.com/91dd61597d.js"
      crossorigin="anonymous"
    ></script>
    <title>Netflix - Watch TV Show Online, Watch Movies Online</title>
  </head>
  <body>
    <!-- Fisrt Page -->
    <header class="showcase">
      <div class="showcase-top">
        <img src="img/logo.png" alt="Netflix" />
        <!-- Dropdown bahasa -->
        <select class="btn language-select">
          <i class="fa-solid fa-globe"></i>
          <option value="id">Bahasa Indonesia</option>
          <option value="en">English</option>
        </select>
        <a class="btn btn-rounded" data-bs-toggle="modal" data-bs-target="#exampleModal">Sign In</a>
      </div>

<!-- Modal Login -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h1 class="modal-title fs-4" id="exampleModalLabel">Sign In</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Menampilkan Pesan "Akun Tidak Ditemukan" -->
        <?php if(!empty($_SESSION['login_message'])) : ?>
        <div class="text-danger"><?= $_SESSION['login_message']; ?></div>
        <?php unset($_SESSION['login_message']); ?> <!-- menghilangkan pesan saat web direfresh -->
        <?php endif; ?>
        <!-- //end -->

        <form action="index.php" method="POST">
          <label for="username" class="text-white fs-5">Username</label>
          <input type="text" name="username" class="form-control">
          <p></p>
          <label for="password" class="text-white fs-5">Password</label>
          <input type="password" name="password" class="form-control">
          <p></p>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="login">Sign In</button>
            <a href="register.php" class="card-link text-primary" data-bs-target="#exampleModal2" data-bs-toggle="modal">Register</a>
          </div>
        </form>
      </div>     
    </div>
  </div>
</div>

<!-- Modal Register -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: black;">Register</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Menampilkan Pesan "Akun Tidak Ditemukan" -->
        <?php if(!empty($_SESSION['login_message'])) : ?>
        <div class="text-danger"><?= $_SESSION['login_message']; ?></div>
        <?php unset($_SESSION['login_message']); ?> <!-- menghilangkan pesan saat web direfresh -->
        <?php endif; ?>
        <!-- //end -->

        <form action="index.php" method="POST">
          <label for="username" class="text-dark">Username</label>
          <input type="text" name="username" class="form-control">
          <p></p>
          <label for="password" class="text-dark">Password</label>
          <input type="password" name="password" class="form-control">
          <p></p>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Back</button>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
          </div>
        </form>
      </div>     
    </div>
  </div>
</div>

      <div class="showcase-content">
        <h1>Unlimited movies, TV shows, and more</h1>
        <p class="text-md">Starts at IDR 54,000. Cancel anytime</p>
        <a class="btn btn-xl" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Watch Free For 30 Days <i class="fas fa-chevron-right btn-icon"></i>
        </a>
      </div>
    </header>

    <section class="tabs">
      <div class="container">
        <div id="tab-1" class="tab-item tab-border">
          <i class="fas fa-door-open fa-3x"></i>
          <p class="hide-sm">Cancel anytime</p>
        </div>
        <div id="tab-2" class="tab-item">
          <i class="fas fa-tablet-alt fa-3x"></i>
          <p class="hide-sm">Watch anywhere</p>
        </div>
        <div id="tab-3" class="tab-item">
          <i class="fas fa-tags fa-3x"></i>
          <p class="hide-sm">Pick your price</p>
        </div>
      </div>
    </section>

    <section class="tab-content">
      <div class="container">
        <!-- Tab Content 1 -->
        <div id="tab-1-content" class="tab-content-item show">
          <div class="tab-1-content-inner">
            <div>
              <p class="text-lg">
                If you decide Netflix isn't for you - no problem. No commitment.
                Cancel online anytime.
              </p>
              <a class="btn btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">Watch Free For 30 Days</a>
            </div>
            <img src="img/content-1.png" alt="" style="width: 70%" />
          </div>
        </div>

        <!-- Tab 2 Content -->
        <div id="tab-2-content" class="tab-content-item">
          <div class="tab-2-content-top">
            <p class="text-lg">
              Watch TV shows and movies anytime, anywhere - personalized for
              you.
            </p>
            <a class="btn btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">Watch Free For 30 Days</a>
          </div>
          <div class="tab-2-content-bottom">
            <div>
              <img src="img/content-1.png" alt="" style="width: 60%" />
              <p class="text-md">Watch on your TV</p>
              <p class="text-dark">
                Smart TV, PlayStation, Xbox, Chromecast, Apple TV, Blu-ray
                Players, and more.
              </p>
            </div>
            <div>
              <img src="img/content-1.png" alt="" style="width: 60%" />
              <p class="text-md">Watch instantly or download for later</p>
              <p class="text-dark">
                Available on phone and tablet, wherever you go.
              </p>
            </div>
            <div>
              <img src="img/content-1.png" alt="" style="width: 60%" />
              <p class="text-md">Use any computer</p>
              <p class="text-dark">Watch right on Netflix.com</p>
            </div>
          </div>
        </div>

        <!-- Tab 3 Content -->
        <div id="tab-3-content" class="tab-content-item">
          <div class="text-center">
            <p class="text-lg">
              Choose one plan and watch everything on Netflix
            </p>
            <a class="btn btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">Whatch Free For 30 Days</a>
          </div>

          <table class="table">
            <thead>
              <tr>
                <th></th>
                <th>Basic</th>
                <th>Standard</th>
                <th>Premium</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>Monthly price after free month ends on 6/19/19</td>
                <td>Rp.64.000</td>
                <td>Rp.120.000</td>
                <td>Rp.210.000</td>
              </tr>
              <tr>
                <td>HD Available</td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
              </tr>
              <tr>
                <td>Ultra HD Available</td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
              </tr>
              <tr>
                <td>Screens you can watch on at the same time</td>
                <td>1</td>
                <td>2</td>
                <td>4</td>
              </tr>
              <tr>
                <td>Watch on your laptop, TV, phone, and tablet</td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
              </tr>
              <tr>
                <td>Unlimited movies and TV shows</td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
              </tr>
              <tr>
                <td>Cancel anytime</td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
              </tr>
              <tr>
                <td>First month free</td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-check"></i></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <footer class="footer">
      <p>Questions? Call 007-803-321-8275</p>
      <div class="footer-cols">
        <ul>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Investor Relations</a></li>
          <li><a href="#">Ways to Watch</a></li>
          <li><a href="#">Corporate Information</a></li>
          <li><a href="#">Only on Netflix</a></li>
        </ul>
        <ul>
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Jobs</a></li>
          <li><a href="#">Terms of Use</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
        <ul>
          <li><a href="#">Account</a></li>
          <li><a href="#">Redeem Gift Cards</a></li>
          <li><a href="#">Privacy</a></li>
          <li><a href="#">Speed Test</a></li>
        </ul>
        <ul>
          <li><a href="#">Media Center</a></li>
          <li><a href="#">Buy Gift Cards</a></li>
          <li><a href="#">Cookie Preferences</a></li>
          <li><a href="#">Legal Notices</a></li>
        </ul>
      </div>
    </footer>

    <!-- Isi -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
  </body>
</html>

<?php 
function gpt(int $n): string {
  return $n > 0 ? "Positive" : ($n < 0 ? "Negative" : "Zero");
}
?>
