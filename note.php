<?php

$insert = false;
$Update = false;
$delete = false;
//connecting to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "mynote";

// create a connection

$conn = mysqli_connect($servername, $username, $password, $database);

// check the connection 
if (!$conn) {
  die("sorry! the connection was failed:" . mysqli_connect_error());
}
// echo $_SERVER('REQUEST_METHOD');

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $sql = "DELETE FROM `notes` WHERE `id` = $id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $delete = true;
  } else {
    echo "Deleting data has been failed:" . mysqli_error($conn);
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST["srnEdit"])) {
    //update the record
    $id = $_POST["srnEdit"];
    $title = $_POST["editTitle"];
    $description = $_POST["editDescription"];

    $sql = " UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`id` = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $Update = true;
    } else {
      echo "the recorted Updation has been failed:" . mysqli_error($conn);
    }
  } else {

    $title = $_POST["title"];
    $description = $_POST["description"];

    $sql = "INSERT INTO `notes`(`title`, `description`) VALUE ('$title', '$description')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $insert = true;
      // header("Location: " . $_SERVER['PHP_SELF']);
    } else {
      echo "the recorted insertion has been failed:" . mysqli_error($conn);
    }
  }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Notes</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
</head>

<body class="bg-gray">
  <!-- Edit modal -->
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editmodal">
    Edit modal
  </button> -->

  <!-- Modal -->
  <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit this Note</h1>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <form action="/notes/note.php" method="post">
            <input type="hidden" name="srnEdit" id="srnEdit">
            <div class="form-group">
              <label for="title">Your Note Title</label>
              <input type="text" name="editTitle" id="editTitle" class="form-control" placeholder="Enter Title Here" aria-describedby="helpId" />
            </div>
            <div class="form-group">
              <label for="description">Note Description</label>
              <textarea class="form-control" name="editDescription" id="editDescription" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="/notes/note.php">myTask</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/notes/note.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/notes/note.php">Notes</a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="#">Action 1</a>
            <a class="dropdown-item" href="#">Action 2</a>
          </div>
        </li> -->
      </ul>
      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" />
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
          Search
        </button>
      </form> -->
    </div>
  </nav>
  <div class="container">
    <?php
    if ($insert) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been saved.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
  <span aris-hidden='true'> &times;</span></button>
</div>";
    }
    if ($Update) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been updated.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
  <span aris-hidden='true'> &times;</span></button>
</div>";
    }
    if ($delete) {
      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been deleted.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
  <span aris-hidden='true'> &times;</span></button>
</div>";
    }
    ?>
  </div>
  <div class="container my-4">
    <h2 class="text-center">Write Your Notes Here</h2>
    <form action="/notes/note.php" method="post">
      <div class="form-group">
        <label for="title">Your Note Title</label>
        <input type="text" name="title" id="title" class="form-control required" placeholder="Enter Title Here" aria-describedby="helpId" required />
      </div>
      <div class="form-group">
        <label for="description">Note Description</label>
        <textarea class="form-control required" name="description" id="description" rows="2" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container">

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Title</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "select * from notes";
        $result = mysqli_query($conn, $sql);
        $srn = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $srn++;
          echo "   <tr>
            <td scope='row'>" . $srn . "</td>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td>
           <button type='button' class='edit btn btn-primary' data-toggle='modal' data-target='#editmodal' id=" . $row['id'] . ">Edit</button>
           <button type='button' class='delete btn btn-primary' id=d" . $row['id'] . ">Delete</button>
           
            </td>
          </tr>";
        }
        ?>

      </tbody>
    </table>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>
  <script>
    $("body").on("click", '.edit', (e) => {
      console.log("element", e)
      // console.log('Edited');
      tr = e.target.parentNode.parentNode;
      title = tr.querySelectorAll('td')[1].innerText;
      description = tr.querySelectorAll('td')[2].innerText;
      // console.log(title, description);
      // $('#editmodal').modal('toggle');
      document.querySelector("#editTitle").value = title;
      document.querySelector("#editDescription").value = description;
      document.querySelector("#srnEdit").value = e.target.id;
      console.log(e.target.id);
    })

    $("body").on("click", '.delete', (e) => {
      srn = e.target.id.substr(1, );
      if (confirm("Delete this Note!")) {
        console.log('yes');
        window.location = `/notes/note.php?delete=${srn}`;


      } else {
        console.log('no');

      }
    });
    // let deletes = document.querySelectorAll(".delete");
    // Array.from(deletes).forEach((element) => {
    //   element.addEventListener("click", (e) => {
    //     srn = e.target.id.substr(1, );
    //     if (confirm("Delete this Note!")) {
    //       console.log('yes');
    //       window.location = `/notes/note.php?delete=${srn}`;


    //     } else {
    //       console.log('no');

    //     }
    //   })
    // })
  </script>
</body>

</html>