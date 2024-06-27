<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Ratchet\Client\Connector;
use React\EventLoop\Loop;
class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loop = Loop::get();
        $connector = new Connector($loop);
        $isInMaintenance = false;

        $connector('ws://localhost:8085/check-maintenance')
        ->then(function(\Ratchet\Client\WebSocket $conn) use (&$isInMaintenance, $loop) {
            $conn->on('message', function($msg) use ($conn, &$isInMaintenance, $loop) {
                $parsedDate = json_decode($msg, true);
                if ($parsedDate['maintenance']) {
                    $isInMaintenance = true;
                }
                $conn->close();
                $loop->stop();
            });

            $conn->send('check_maintenance');
        }, function(\Exception $e) use ($loop) {
            echo "Could not connect: {$e->getMessage()}\n";
            $loop->stop();
        });

        $loop->run();

        if ($isInMaintenance) {
            return response(view('maintenance'), 503);
        }

        return $next($request);
    }
}
