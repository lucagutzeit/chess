<?php
session_start();

// ! Session variable should be nickname to work.
if (!isset($_SESSION['nickname'])) {
    include __DIR__ . '/src/LandingPage/landing.php';
} else {
    echo "Here should be the user area.";
}
