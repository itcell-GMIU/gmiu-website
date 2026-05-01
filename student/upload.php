<?php

if (isset($_POST["submit"]) && isset($_FILES['image'])) {

  $file_name = $_FILES['image']['name'];
  $file_size = $_FILES['image']['size'];
  $file_tmp = $_FILES['image']['tmp_name'];
  $file_type = $_FILES['image']['type'];
  move_uploaded_file($file_tmp, "photo/" . $file_name);
}
