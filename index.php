<?php 
// INSERT INTO `notes` (`sno.`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy books', 'Buy books from the store.', current_timestamp());
$insert = false;
$update = false;
$delete = false;

// Connecting to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}


if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['snoEdit'])){
        // Update the record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

    //SQL query to be executed
    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";

    $result = mysqli_query ($conn, $sql);

    if($result){
        $update = true;
    }
    else{
        echo "  We could not update the record succesfully <br>";
    }
    }

else{
    $title = $_POST["title"];
    $description = $_POST["description"];

    //SQL query to be executed
    $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";

    $result = mysqli_query ($conn, $sql);

    
    if($result){
        // echo "The record has been inserted successfuly.";
        $insert = true; 
    }
    else{
        echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
    }
}
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Datatables.net
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->

    <title>iNotes - Notes taking make easy</title>

</head>

<body>

    <!-- Edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit The Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/crud/index.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="title">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                        <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/crud/index.php"><img src="/crud/logo.png" height="45px" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/crud/index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/crud/contact.php">Contact Us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php

    if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    
    ?>

    <div class="container my-4">
        <h2>Add a Note to iNotes app</h2>
        <form action="/crud/index.php" method="post">
            <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query ($conn, $sql);
                    $sno = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        $sno = $sno + 1;
                        echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td> <button class='edit btn btn-sm btn-primary' id= ". $row['sno'] .">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button> </td>
                    </tr>";
                    }
            ?>

            </tbody>
        </table>

    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
    <!-- <script>
    $(document).ready( function () {
    $('#myTable').DataTable();
    } );
    </script> -->



    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS-->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->


    <script>

        // Javascript for editing the list
        edits = document.getElementsByClassName('edit')
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edits")
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle')
            })
        })

        // Javascript for deleting the list
        deletes = document.getElementsByClassName('delete')
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edits")
                sno = e.target.id.substr(1,)

                if (confirm("Are you sure you want to delete this note?")) {
                    console.log("yes")
                    window.location = `/crud/index.php?delete=${sno}`;
                }
                else {
                    console.log("no");
                }
            })
        })
    </script>

</body>

</html>

