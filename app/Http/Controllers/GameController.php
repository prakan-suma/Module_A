<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameVersion;
use App\Models\Score;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function create()
    {
        return view('game.create');
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
            'user_id' => session('user')->id,
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

        return redirect('/');
    }

    public function control()
    {
        return view('game.control');
    }

    public function updateForm($id)
    {
        $game['game'] = Game::where('slug', $id)->first();
        return view('game.update', $game);
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

        return redirect('/');
    }

    public function show(string $slug)
    {
        // Get game form file name
        $game = GameVersion::where('files', $slug)->first();

        // Create a scores
        if (!$game->userScore) {
            Score::create([
                'user_id' => session('user')->id,
                'gameversion_id' => $game->id,
                'score' => 1,
            ]);
        } else {
            $score = Score::where(
                [
                    ['user_id', session('user')->id],
                    ['gameversion_id', $game->id]
                ]
            )->first();
            $add = $score->score + 1.00;
            $score->update(['score' => $add]);
        }

        return view('game.index', ['game' => $game]);
    }


}
