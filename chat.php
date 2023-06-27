<?php
require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    protected $rooms;
    protected $users;
    protected $users_name;
    protected $users_link;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        
        $msg = json_decode($msg);
        if ($msg->message == 'new room') {
            $this->rooms[$msg->value][$from->resourceId] = $from;
            $this->users[$from->resourceId] = $msg->value;
            $this->users_name[$msg->value][$from->resourceId] = $msg->user;
            $this->users_link[$msg->value][$from->resourceId] = $msg->link;
            $users = [];
            foreach ($this->users_name[$msg->value] as $user) $users[] = $user;
            foreach($this->rooms[$msg->value] as $client){
                $message = ['message' => 'connection','user' => $this->users_name[$msg->value][$from->resourceId]];
                $client->send(json_encode($message));
            }
            
        }
        elseif ($msg->message == 'new message') {
            $room = $this->users[$from->resourceId];
            foreach($this->rooms[$room] as $client){
                $message = ['message' => 'message', 'text' => $msg->value, 'user' => $this->users_name[$room][$from->resourceId], 'link' => $this->users_link[$room][$from->resourceId]];
                $client->send(json_encode($message));
            }
        }

    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        $room = $this->users[$conn->resourceId];
        unset($this->rooms[$room][$conn->resourceId]);
        unset($this->users[$conn->resourceId]);
        unset($this->users_name[$room][$conn->resourceId]);
        
        foreach($this->rooms[$room] as $client){
                
                if ($this->users[$conn->resourceId] == $client) {
                    $message = ['message' => 'disconnect', 'text' => "Собеседник покинул чат"];
                    $client->send(json_encode($message));
                }
                
            }
        echo "Connection {$conn->resourceId}  has disconnected\n";
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
        8777
    );

    $server->run();