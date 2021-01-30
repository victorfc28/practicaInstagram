<?php
  session_start();
  unset($_SESSION["usuario"]);
  session_unset();
  session_destroy();
  header("Location: ../index.php");
