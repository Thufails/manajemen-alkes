<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Jika user tidak login
        if (!$user) {
            return redirect('/login');
        }

        // Ambil role user dari relasi
        $userRole = $user->role ? $user->role->name : null;

        // Cek apakah role user termasuk dalam daftar role yang diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
