<?php
session_start();
require __DIR__ . '/../DBConnection.php';

/**
 * Is the user already in a game?
 */
if (!isset($_SESSION['gameId'])) {

    $id = $_POST['id'];
    $nickname = $_SESSION['nickname'];

    /**
     * Get the data of the game from the database
     */
    $sql = $connection->prepare('SELECT * FROM games WHERE id = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $result = $sql->get_result()->fetch_assoc();

    /**
     * Check if the user is already part of the game.
     */
    if ($result['player1'] === $nickname || $result['player2'] === $nickname) {
        echo "http://localhost/chess/src/game.php?id=$id";
        die;
    }

    /**
     * Check which player is not set.
     */
    if ($result['player1'] === null) {
        $sql = $connection->prepare('UPDATE games SET player1 = ? WHERE id = ?');
        $sql->bind_param('si', $nickname, $id);
        $sql->execute();
        $_SESSION['gameId'] = $id;
    } elseif ($result['player2'] === null) {
        $sql = $connection->prepare('UPDATE games SET player2 = ? WHERE id = ?');
        $sql->bind_param('si', $nickname, $id);
        $sql->execute();
        $_SESSION['gameId'] = $id;
    } else {
        echo "?error='gameFull'";
    }

    /**
     * If game is full, change state to 1.
     */
    if (!($result['player1'] === null && $result['player2'] === null)) {
        $sql = $connection->prepare('UPDATE games SET state = 1 WHERE id = ?');
        $sql->bind_param('i', $id);
        $sql->execute();
    }
} else {
    /**
     * Redirect to the right game.
     */
    $id = $_SESSION['gameId'];
    echo "http://localhost/chess/src/game.php?id=$id";
}
