<?php

namespace App\Http\Controllers;

use App\Models\Councilor;
use App\Models\Legislature;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialVoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Material $material)
    {
        return view('panel.materials.votes.index', compact('material'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Material $material)
    {
        $allCouncilors = (new Councilor())->getCurrentCouncilors();

        $voteCouncilor = $material->votes->where('vote', 'Sim')->pluck('councilor_id');
        
        $councilors = $allCouncilors->map(function ($councilor) use ($voteCouncilor) {
            $councilor->vote = $voteCouncilor->contains($councilor->id);
            return $councilor;
        });
        
        return view('panel.materials.votes.create', compact('material', 'councilors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Material $material)
    {
        // dd($request->all());
        $votes = $request->councilors;

        foreach($votes as $voteData){
            $voteStatus = array_key_exists('vote', $voteData) ? 'Sim' : 'Não';

            $existVote = $material->votes()->where('councilor_id', $voteData['id'])->first();

            if ($existVote) {
                $existVote->update(['vote' => $voteStatus]);
            } else {
                $material->votes()->create([
                    'councilor_id' => $voteData['id'],
                    'vote' => $voteStatus,
                ]);
            }
        }
        return redirect()->route('votes.create', $material->slug)->with('success', 'Votação realizada com sucesso!');
    }
}
