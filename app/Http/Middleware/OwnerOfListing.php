<?php

namespace App\Http\Middleware;

use App\Models\Listing;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerOfListing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $listingId = $request->segments()[1];
        $listing = Listing::findOrFail($listingId);
        if ($listing->user_id !== Auth::id()) {
            return abort(403);
        }

        return $next($request);
    }
}
