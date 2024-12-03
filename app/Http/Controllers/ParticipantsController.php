<?php

namespace App\Http\Controllers;

use App\Models\Participants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class ParticipantsController extends Controller
{
    // List
    public function index(Request $request)
    {
        $data = [
            'title' => 'Participants'
        ];

        return view('contents.peparnas.participants.list', $data);
    }

    public function data(Request $request)
    {
        $list = Participants::select('*');

        return DataTables::of($list)
            ->addIndexColumn()
            ->make();
    }
}
