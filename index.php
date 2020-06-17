<?php
session_start();

// ! Session variable should be nickname to work.
if (!isset($_SESSION[''])) {
    include './src/landing.php';
} else {
    echo "Here should be the user area.";
}
