<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Game;
use App\Models\Score;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function signin()
    {
        return view('admin.signin');
    }

    public function admin()
    {
        return view('admin.admin', ['admins' => Admin::all()]);
    }
    public function user()
    {
        return view('admin.user', ['users' => User::all()]);
    }
    public function game()
    {
        return view('admin.game', ['games' => Game::all()]);
    }

    public function block(Request $request)
    {
        $request->validate([
            'block' => 'required'
        ]);

        User::whereId($request->id)->update([
            'block_status' => true,
            'block_reason' => $request->block
        ]);
        return back()->withErrors(['error' => 'Bloked this user success. ']);
    }

    public function unblock($id)
    {
        User::whereId($id)->update([
            'block_status' => false,
            'block_reason' => null
        ]);
        return back()->withErrors(['error' => 'Unbloked this user success.']);
    }

    public function deleteGame($id)
    {
        Game::whereId($id)->update(['delete_status' => true]);
        return back();
    }

    public function search(Request $request)
    {
        $request->validate(['keyword' => 'required']);

        $games = Game::where([['title', 'like', '%' . $request->keyword . '%']])->get();

        return view('admin.search', ['games' => $games]);
    }

    public function score($id)
    {
        return view('admin.score', ['score' => Game::whereId($id)->first()]);
    }

    public function resetscore($id)
    {
        $game = Game::whereId($id)->first();
        $idHeightScroe = $game->currentVersion->scores->first();

        Score::where([
            ['user_id', $idHeightScroe->user_id],
            ['gameversion_id', $idHeightScroe->gameversion_id],
        ])->delete();
        return back();
    }

    public function deletescore($id)
    {
        Score::whereId($id)->delete();
        return back();
    }

    // Delete score of user all game

    public function deleteall($id)
    {
        Score::join('game_versions', 'game_versions.id', '=', 'scores.gameversion_id')->join('games', 'games.id', '=', 'game_versions.game_id')->where('scores.user_id', $id)->delete();
        return back();
    }


}
