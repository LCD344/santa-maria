<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\Match;
use Illuminate\Http\Request;

$router->get('/', function() {
    $matches = Match::all();
    $manifestFile = json_decode(file_get_contents(base_path('public') . '/mix-manifest.json'));
    return view('app', compact('matches', 'manifestFile'));
});

$router->post('match', function(Request $request) {
    $this->validate($request, [
        'password' => 'required|in:' . config('session.action_password')
    ]);

    $match = new Match;
    $match->url = $request->get('url', null);
    $match->home_team = $request->get('homeTeam', null);
    $match->away_team = $request->get('awayTeam', null);
    $match->home_score = $request->get('homeScore', null);
    $match->away_score = $request->get('awayScore', null);
    $match->date = $request->get('date', null);
    $match->save();

    return response()->json([
        'success' => true,
        'match' => $match
    ]);
});


$router->delete('match/{match}', function(Request $request, $match) {
    $this->validate($request, [
        'password' => 'required|in:' . config('session.action_password')
    ]);

    Match::where('_id', $match)->delete();

    return response()->json([
        'success' => true
    ]);
});
