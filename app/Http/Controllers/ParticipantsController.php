<?php

namespace App\Http\Controllers;

use App\Models\Participants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        DB::enableQueryLog();
        $list = Participants::select('*')
            ->where('category_sys_cd', 'C00009')
            ->orWhere('category_sys_cd', 'C00012')
            ->with(['kk', 'ktp', 'pp']);

        return DataTables::of($list)
            ->addIndexColumn()
            ->make(true);
    }

    public function generate()
    {
        $list = Participants::select('*')
            ->where('category_sys_cd', 'C00009')
            ->orWhere('category_sys_cd', 'C00012')
            ->with(['kk', 'ktp', 'pp'])
            ->get();

        $countKK = 0;
        $countKTP = 0;
        $countPP = 0;

        foreach ($list as $item) {
            $pathKK = @$item->kk->save_file_nm;
            $pathKTP = @$item->ktp->save_file_nm;
            $pathPP = @$item->pp->save_file_nm;

            if ($pathKK != null) {
                Storage::disk('public')->copy(@$item->kk->save_file_nm, 'kk' . @$item->kk->save_file_nm);
                $countKK++;
            }
            if ($pathKTP != null) {
                Storage::disk('public')->copy(@$item->ktp->save_file_nm, 'ktp' . @$item->ktp->save_file_nm);
                $countKTP++;
            }
            if ($pathPP != null) {
                Storage::disk('public')->copy(@$item->pp->save_file_nm, 'pp' . @$item->pp->save_file_nm);
                $countPP++;
            }
        };

        return 'kk = ' . $countKK . ' - ktp = ' . $countKTP . ' - pp = ' . $countPP;
    }
}
