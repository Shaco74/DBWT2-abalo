<?php
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected SplObjectStorage $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
        $conn->sessionID = uniqid();

        echo "New connection! ({$conn->resourceId})\n";
        // send welcome message
        $welcomeMsg = array(
            'isServer' => true,
            'message' => 'Welcome to the chat!',
            'timestamp' => time()
        );

        $welcomeMsgJson = json_encode($welcomeMsg);
        $conn->send($welcomeMsgJson);
    }

public function onMessage(ConnectionInterface $from, $msg) {
    $newMsg = array(
        'isServer' => false,
        'ip of sender' => $from->remoteAddress,
        'sessionID' => $from->sessionID,
        'message' => $msg,
        'timestamp' => time()
    );

    $newMsgJson = json_encode($newMsg);

    echo "New message: {$newMsgJson}\n";
    foreach ($this->clients as $client) {
        if ($from !== $client) {
            $client->send($newMsgJson);
        }
    }
}

    public function onClose(ConnectionInterface $conn) {
        // Detach the connection
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8085
);

$server->run();
