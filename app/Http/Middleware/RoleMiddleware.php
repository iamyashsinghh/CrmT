<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // If the user has the correct role, allow the request
            if ($user->role->name === $role) {
                Auth::guard($user->role->name)->login($user);
                return $next($request);
            }

            // Redirect to the user's role-specific dashboard if role doesn't match
            return redirect($this->getDashboardRouteForRole($user->role->name))
                ->with('error', 'Unauthorized access to this section');
        }

        // If the user is not authenticated, redirect to login
        return redirect()->route('home')->with('error', 'Please log in first');
    }

    /**
     * Get the dashboard route based on the user's role.
     *
     * @param  string  $roleName
     * @return string
     */
    private function getDashboardRouteForRole($roleName)
    {
        // Define the route for each role
        switch ($roleName) {
            case 'Admin':
                return route('admin.dashboard');
            case 'Sales':
                return route('sales.dashboard');
            case 'Doctor':
                return route('doctor.dashboard');
            case 'MedicineVital':
                return route('medicinevital.dashboard'); // Assuming route exists
            case 'Bill':
                return route('billing.dashboard'); // Assuming route exists
            case 'Lab':
                return route('lab.dashboard'); // Assuming route exists
            case 'Dispatcher':
                return route('dispatcher.dashboard'); // Assuming route exists
            case 'TPA':
                return route('tpa.dashboard'); // Assuming route exists
            case 'PostSales':
                return route('postsales.dashboard'); // Assuming route exists
            case 'Vendor':
                return route('vendor.dashboard'); // Assuming route exists
            default:
                return route('login'); // Fallback
        }
    }
}
