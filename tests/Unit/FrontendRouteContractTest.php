<?php

namespace Modules\Glitter\Reservation\Tests\Unit;

use PHPUnit\Framework\TestCase;

class FrontendRouteContractTest extends TestCase
{
    private string $modulePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modulePath = dirname(__DIR__, 2);
    }

    public function test_admin_reservations_route_resolves_existing_layout(): void
    {
        $routes = $this->readRoutes('admin');
        $route = $this->findRoute($routes, '*/admin/reservations');

        $this->assertNotNull($route, 'The canonical /admin/reservations frontend route must be registered.');
        $this->assertSame('reservation_booking_list', $route['layout'] ?? null);
        $this->assertTrue($route['auth_required'] ?? false);
        $this->assertSame('glitter-reservation.reservations.read', $route['permission'] ?? null);
        $this->assertFileExists(
            $this->modulePath.'/resources/layouts/admin/'.($route['layout'] ?? '').'.json'
        );
    }

    public function test_public_reservation_routes_resolve_existing_layouts(): void
    {
        $routes = $this->readRoutes('user');

        foreach ([
            '*/reservation/apply' => 'reservation_apply',
            '*/reservation/lookup' => 'reservation_lookup',
        ] as $path => $layout) {
            $route = $this->findRoute($routes, $path);

            $this->assertNotNull($route, "The {$path} frontend route must be registered.");
            $this->assertSame($layout, $route['layout'] ?? null);
            $this->assertFileExists($this->modulePath.'/resources/layouts/user/'.$layout.'.json');
        }
    }

    /** @return array<int, array<string, mixed>> */
    private function readRoutes(string $type): array
    {
        $path = $this->modulePath.'/resources/routes/'.$type.'.json';

        $this->assertFileExists($path);
        $decoded = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $this->assertIsArray($decoded['routes'] ?? null);

        return $decoded['routes'];
    }

    /**
     * @param  array<int, array<string, mixed>>  $routes
     * @return array<string, mixed>|null
     */
    private function findRoute(array $routes, string $path): ?array
    {
        foreach ($routes as $route) {
            if (($route['path'] ?? null) === $path) {
                return $route;
            }
        }

        return null;
    }
}
