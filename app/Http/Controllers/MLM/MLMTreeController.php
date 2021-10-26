<?php

namespace App\Http\Controllers\MLM;

use App\Http\Controllers\Controller;
use App\Models\MLMRegister;
use App\Models\Ranking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MLMTreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mlm.tree.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = MLMRegister::where('sponser_id', Auth::user()->unique_id)
            ->orWhere('placement_id', Auth::user()->id)->where('status', 1)->get();
        $display = array();
        if ($data->count() > 0) {
            foreach ($data as $item) {
                $user = User::where('unique_id', $item->member_id)->first();
                $ranking = Ranking::where('id', $item->ranking)->first();

                if (array_search($item->member_id, array_column($display, 'member_id')) !== False) {
                } else {
                    $display[] = [
                        'id'        => $user->id,
                        'pid'       => $item->placement_id,
                        'name'      => $item->member_name,
                        'member_id' => $item->member_id,
                        'img'       => $user->image == null ?  asset('asset/image/icon/user.png') : asset($user->image),
                        'title'     => $ranking->type,
                        // 'title'     => $item->member_id,
                        'tag'       => $item->placement
                    ];
                }

                $more = MLMRegister::where('sponser_id', $item->member_id)
                    ->orWhere('placement_id', $user->id)->where('status', 1)->get();
                if ($more) {
                    foreach ($more as $value) {
                        $more_user = User::where('unique_id', $value->member_id)->first();
                        $more_ranking = Ranking::where('id', $value->ranking)->first();
                        if (array_search($value->member_id, array_column($display, 'member_id')) !== False) {
                        } else {
                            $display[] = [
                                'id'        => $more_user->id,
                                'pid'       => $value->placement_id,
                                'name'      => $value->member_name,
                                'member_id' => $value->member_id,
                                'img'       => $more_user->image == null ?  asset('asset/image/icon/user.png') : asset($more_user->image),
                                'title'     => $more_ranking->type,
                                // 'title'     => $value->member_id,
                                'tag'       => $value->placement
                            ];
                        }

                        $many_more = MLMRegister::where('sponser_id', $value->member_id)
                            ->orWhere('placement_id', $more_user->id)->where('status', 1)->get();
                        foreach ($many_more as $more_value) {
                            $many_more_user = User::where('unique_id', $more_value->member_id)->first();
                            // $more_ranking = Ranking::where('id', $more_value->ranking)->first();
                            if (array_search($more_value->member_id, array_column($display, 'member_id')) !== False) {
                            } else {
                                $display[] = [
                                    'id'        => $many_more_user->id,
                                    'pid'       => $more_value->placement_id,
                                    'name'      => $more_value->member_name,
                                    'member_id' => $more_value->member_id,
                                    'img'       => $many_more_user->image == null ?  asset('asset/image/icon/user.png') : asset($many_more_user->image),
                                    'title'     => $more_ranking->type,
                                    // 'title'     => $more_value->member_id,
                                    'tag'       => $more_value->placement
                                ];
                            }
                        }
                    }
                }
            }
        } else {
            $left_user = User::where('unique_id', Auth::user()->left_id)->first();
            $right_user = User::where('unique_id', Auth::user()->right_id)->first();
            if ($left_user) {
                $mlm = MLMRegister::where('member_id', Auth::user()->left_id)->first();
                $ranking = Ranking::where('id', $mlm->ranking)->first();
                $display[] = [
                    'id'    => $left_user->id,
                    'pid'   => Auth::user()->id,
                    'name'  => $left_user->name,
                    'img'       => Auth::user()->image == null ?  asset('asset/image/icon/user.png') : asset(Auth::user()->image),
                    'title'     => $ranking->type,
                    // 'title'     => Auth::user()->unique_id,
                    'tag'       => $mlm->placement
                ];
            }

            if ($right_user) {
                $mlm = MLMRegister::where('member_id', Auth::user()->left_id)->first();
                $ranking = Ranking::where('id', $mlm->ranking)->first();
                $display[] = [
                    'id' => $right_user->id,
                    'pid' => Auth::user()->id,
                    'name' => $right_user->name,
                    'img'       => Auth::user()->image == null ?  asset('public/icon/user.png') : asset(Auth::user()->image),
                    'title'     => $ranking->type,
                    // 'title'     => Auth::user()->unique_id,
                    'tag'       => $mlm->placement
                ];
            }
        }

        $main_user_mlm = MLMRegister::where('member_id', Auth::user()->unique_id)->first();
        if ($main_user_mlm)
            $main_user_ranking = Ranking::where('id', $main_user_mlm->ranking)->first();
        else
            $main_user_ranking = false;
        $display[] = [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'img'       => Auth::user()->image == null ?  asset('asset/image/icon/user.png') : asset(Auth::user()->image),
            'title'     => $main_user_ranking ?  $main_user_ranking->type : 'Diamond',
            'tag'       => 0
        ];

        // echo json_encode($display);
        usort($display, function ($a, $b) {
            return $a['tag'] <=> $b['tag'];
        });

        echo json_encode($display);
        // print_r($display)

        // echo count($display);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}