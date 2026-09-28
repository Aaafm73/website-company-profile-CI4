<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RateLimit implements FilterInterface
{
    private const LIMITS = [
        'global' => [300, 60],
        'admin-login' => [5, 60],
        'contact' => [5, 60],
        'checkout' => [8, 60],
        'tracking' => [20, 60],
        'cart' => [60, 60],
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $scope = $arguments[0] ?? '';
        $limit = self::LIMITS[$scope] ?? null;

        if ($limit === null) {
            return service('response')->setStatusCode(429)->setBody('Request limit exceeded.');
        }

        [$capacity, $period] = $limit;
        $clientKey = hash('sha256', $request->getIPAddress() . ':' . $scope);
        $throttler = service('throttler');

        if ($throttler->check($clientKey, $capacity, $period)) {
            return null;
        }

        $response = service('response')
            ->setStatusCode(429)
            ->setHeader('Retry-After', (string) $throttler->getTokenTime());

        if ($request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            return $response->setJSON([
                'success' => false,
                'message' => 'Terlalu banyak permintaan. Coba lagi sebentar.',
            ]);
        }

        return $response->setBody('Terlalu banyak permintaan. Coba lagi sebentar.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-response action is needed.
    }
}
