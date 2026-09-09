<?php

namespace App\Http\Controllers;

use App\Services\ActiveDirectoryService;
use Illuminate\Http\Request;

class TestAdController extends Controller
{
    public function index()
    {
        abort_unless(config('app.debug'), 404);

        return view('test.testad', [
            'connection' => $this->connectionDetails(),
        ]);
    }

    public function authenticate(Request $request, ActiveDirectoryService $activeDirectory)
    {
        abort_unless(config('app.debug'), 404);

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $result = $activeDirectory->authenticate(
            $validated['username'],
            $validated['password'],
        );

        return view('test.testad', [
            'connection' => $this->connectionDetails(),
            'result' => $result,
            'username' => $validated['username'],
        ]);
    }

    private function connectionDetails(): array
    {
        $connection = config('ldap.connections.'.config('ldap.default', 'default'), []);

        return [
            'host' => implode(', ', (array) ($connection['hosts'] ?? [])),
            'port' => $connection['port'] ?? null,
            'base_dn' => $connection['base_dn'] ?? null,
            'ssl' => (bool) ($connection['use_tls'] ?? false),
            'tls' => (bool) ($connection['use_tls'] ?? false),
        ];
    }
}