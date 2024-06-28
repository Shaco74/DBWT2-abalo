<?php
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Loop;

class Chat implements MessageComponentInterface
{
    protected SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
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

    public function onMessage(ConnectionInterface $from, $msg)
    {
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

class CheckMaintenance implements MessageComponentInterface
{
    protected SplObjectStorage $clients;
    protected bool $isInMaintenance;

    public function __construct(bool $isInMaintenance)
    {
        $this->clients = new \SplObjectStorage;
        $this->isInMaintenance = $isInMaintenance;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection
        $this->clients->attach($conn);
        $conn->sessionID = uniqid();

        echo "New connection on /check-maintenance! ({$conn->resourceId})\n";
        // send initial maintenance status
        $this->sendMaintenanceStatus($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Handle incoming messages if needed
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Detach the connection
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} on /check-maintenance has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred on /check-maintenance: {$e->getMessage()}\n";
        $conn->close();
    }

    protected function sendMaintenanceStatus(ConnectionInterface $conn)
    {
        $statusMsg = array(
            'isServer' => true,
            'maintenance' => $this->isInMaintenance,
            'timestamp' => time()
        );

        $statusMsgJson = json_encode($statusMsg);
        $conn->send($statusMsgJson);
    }

    public function broadcastMaintenanceStatus()
    {
        foreach ($this->clients as $client) {
            $this->sendMaintenanceStatus($client);
        }
    }
}

class Sell implements MessageComponentInterface
{
    protected SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection
        $this->clients->attach($conn);
        $conn->sessionID = uniqid();

        echo "New connection on /sells! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $parsedMsg = json_decode($msg, true);
        if (isset($parsedMsg['articleName'])) {
            $sellMsg = array(
                'isServer' => true,
                'articleName' => $parsedMsg['articleName'],
                'creatorId' => $parsedMsg['creatorId'],
                'message' => "Item '{$parsedMsg['articleName']}' has been sold!",
                'timestamp' => time()
            );

            $sellMsgJson = json_encode($sellMsg);

            echo "New sell message: {$sellMsgJson}\n";
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send($sellMsgJson);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Detach the connection
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} on /sells has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred on /sells: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Define the maintenance status
$isInMaintenance = false;

// Get the event loop instance
$loop = Loop::get();
$checkMaintenance = new CheckMaintenance($isInMaintenance);

$server = new App('localhost', 8085, '0.0.0.0', $loop);

// Define the /chat route
$server->route('/chat', new Chat, array('*'));
$server->route('/check-maintenance', new WsServer($checkMaintenance), array('*'));
$server->route('/sells', new WsServer(new Sell), array('*'));

// Periodically broadcast the maintenance status every minute
$loop->addPeriodicTimer(60, function() use ($checkMaintenance) {
    $checkMaintenance->broadcastMaintenanceStatus();
});

// Run the server
$server->run();