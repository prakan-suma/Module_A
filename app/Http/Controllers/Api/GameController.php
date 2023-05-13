<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::where('delete_status', null)->get();

        // Foreach data
        foreach ($games as $g) {
            $g->user;
            $g->currentVersion;
        }

        return response()->json(['game' => $games]);
    }

    public function uploaded(Request $request)
    {
        $games = Game::where([['user_id', $request->user], ['delete_status', null]])->get();

        // Foreach data
        foreach ($games as $g) {
            $g->user;
            $g->currentVersion;
        }

        return response()->json(['game' => $games ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:100|unique:games,title',
            'slug' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9-]+$/|unique:games,slug',
            'description' => 'required|min:3|max:255',
            'thumbnail' => 'required|mimes:jpg',
            'gamefile' => 'required|mimes:zip',
        ]);

        // Create the new thumbnail name
        $thumbanil = md5($request->thumbnail) . '.jpg';
        $request->thumbnail->move(public_path('images/thumbnails'), $thumbanil);

        // Insert to database
        $game = Game::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'thumbnail' => $thumbanil,
            'user_id' => $request->user_id,
        ]);


        $zip = new \ZipArchive();
        $request->gamefile->storeAs('public/games', $request->slug . '-v1.zip');

        if ($zip->open(public_path('storage/games/' . $request->slug . '-v1.zip')) === TRUE) {
            $zip->extractTo('storage/' . $request->slug . '-v1');
            $zip->close();
        } else {
            return back()->withErrors(['error' => 'Cannot open this file.']);
        }

        // Insert gameversion
        GameVersion::create([
            'game_id' => $game->id,
            'files' => $request->slug . '-v1',
        ]);

        return response()->json([
            'status' => 'success',
            'slug' => $game->slug,
        ], 201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:100',
            'slug' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9-]+$/',
            'description' => 'required|min:3|max:255',
            'thumbnail' => 'required|mimes:jpg',
            'gamefile' => 'required|mimes:zip',
        ]);

        // // Create the new name of thumbnail
        $tumbnail = md5($request->thumbnail) . '.jpg';
        $request->thumbnail->move(public_path('images/thumbnails'), $tumbnail);

        // Create the new file name.
        $game = Game::whereId($request->id)->first();
        $fileName = $request->slug . '-v' . $game->gameVersions->count() + 1;

        $zip = new \ZipArchive();
        $request->gamefile->storeAs('public/games', $fileName);

        if ($zip->open(public_path('storage/games/' . $fileName)) === TRUE) {
            $zip->extractTo('storage/' . $fileName);
            $zip->close();
        } else {
            return back()->withErrors(['error' => 'Cannot open this file.']);
        }

        Game::whereId($game->id)->update(['description' => $request->description]);

        GameVersion::create([
            'game_id' => $game->id,
            'files' => $fileName,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
