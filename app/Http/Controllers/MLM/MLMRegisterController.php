<?php

namespace App\Http\Controllers\MLM;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Cart;
use App\Models\DirectSponsor;
use App\Models\MLMRegister;
use App\Models\Ranking;
use App\Models\UseOfPv;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MLMRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mlm.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ranking = Ranking::all();
        $branch = Branch::all();
        echo json_encode(['ranking' => $ranking, 'branch' => $branch]);
    }


    public function search_user()
    {
        $users = User::where('unique_id', 'Like', '%' . request()->term . '%')
            ->where('id', '!=', Auth::user()->id)
            ->where('is_mlm_member', 0)->get();
        if ($users->count() > 0) {
            foreach ($users as $item) {
                $data[] = [
                    'label' => $item->unique_id,
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'unique_id' => $item->unique_id
                ];
            }
        } else {
            $data[] = ['label' => 'Not Found', 'id' => 0];
        }
        echo json_encode($data);
    }

    public function check_user_status()
    {
        $user = User::where('unique_id', request()->id)->first();
        if ($user) {
            $mlm_user = MLMRegister::where('member_id', $user->unique_id)->first();
            if ($mlm_user) {
                if ($mlm_user->status == 0) {
                    echo json_encode(['status' => 'no', 'message' => 'Member Alrady Under Process']);
                } else {
                    echo json_encode(['status' => 'no', 'message' => 'Member Alrady Register']);
                }
            } else {
                echo json_encode(['status' => 'success']);
            }
        } else {
            request()->validate([
                'not_user' => 'required',
            ], [
                'not_user.required' => 'Invalid User Id'
            ]);
        }
    }

    public function get_placement_id()
    {
        $users = MLMRegister::where('sponser_id', Auth::user()->unique_id)
            ->orWhere('m_l_m_registers.placement_id', Auth::user()->id)->get();
        if ($users->count() > 0) {
            $data = MLMRegister::join('users', 'users.unique_id', '=', 'm_l_m_registers.member_id')
                ->select('users.*')
                ->where('sponser_id', Auth::user()->unique_id)
                ->where('m_l_m_registers.status', 1)
                ->orWhere('m_l_m_registers.placement_id', Auth::user()->id)
                ->get();
            $new = array();
            foreach ($data as $item) {
                if ($item->left_id == null || $item->right_id == null) {
                    if (array_search($item->id, array_column($new, 'id')) !== False) {
                    } else
                        $new[] = ['name' => $item->name, 'id' => $item->id, 'unique_id' => $item->unique_id];
                }

                $more_data = MLMRegister::join('users', 'users.unique_id', '=', 'm_l_m_registers.member_id')
                    ->select('users.*')
                    ->where('sponser_id', $item->unique_id)
                    ->where('m_l_m_registers.status', 1)
                    ->orWhere('m_l_m_registers.placement_id', $item->id)
                    ->get();
                foreach ($more_data as $value) {
                    if ($value->left_id == null || $value->right_id == null) {
                        if (array_search($value->id, array_column($new, 'id')) !== False) {
                        } else
                            $new[] = ['name' => $value->name, 'id' => $value->id, 'unique_id' => $value->unique_id];
                    }
                }
            }
            if (Auth::user()->left_id == null || Auth::user()->right_id == null) {
                $exit[] = ['name' => Auth::user()->name, 'id' => Auth::user()->id];
                $merge = array_merge($new, $exit);
            } else {
                $merge = $new;
            }
            echo json_encode(['status' => 'success', 'data' => $merge]);
        } else {
            $data = array(
                'status' => 'no',
                'name' => Auth::user()->name,
                'id' => Auth::user()->id
            );
            echo json_encode($data);
        }
    }

    public function get_pv_point()
    {
        $data = User::where('unique_id', request()->id)->first();
        $check_pv = Ranking::where('id', request()->pv_id)->first();
        if ($data && request()->pv_id != null) {
            if ($data->total_pv_point >= $check_pv->points) {
                $data = ['status' => 'success'];
            } else {
                $data = ['status' => 'faild', 'message' => 'You Not Able To Register Because Register User Does Not Have Sufficient PV Point'];
            }
            echo json_encode($data);
        }
        // else {
        //     request()->validate([
        //         'not_user' => 'required',
        //     ], [
        //         'not_user.required' => 'Invalid User Id'
        //     ]);
        // }
    }

    public function get_placement()
    {
        $user = User::where('id', request()->id)->first();
        if ($user->left_id == null && $user->right_id == null) {
            echo json_encode(['view' => 2, 'data' => array('left' => 'Left', 'right' => 'Right')]);
        } else {
            if ($user->left_id == null) {
                $placement = 'Left';
                $value = 0;
            } else {
                $placement = 'Right';
                $value = 1;
            }
            echo json_encode(['view' => 1, 'data' => $placement, 'value' => $value]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mlm_data = $request->validate([
            'ranking'               => 'required',
            'branch_id'             => 'required',
            'member_id'             => 'required|exists:users,unique_id',
            'member_id'             => 'required|unique:m_l_m_registers,member_id',
            'member_name'           => 'required',
            'postcode'              => '',
            'nationality'           => 'required',
            'sponser_id'            => '',
            'placement_id'          => 'required',
            'placement'             => 'required',
            'street_address'        => '',
            'office_contact_no'     => '',
            'home_contact_no'       => '',
            'nick_name'             => '',
            'gender'                => '',
            'birthday'              => '',
            'email'                 => '',
            'contact_address'       => '',
            'account_holder'        => '',
            'bank_name'             => '',
            'payment_information'   => '',
            'branch'                => '',
            'account_no'            => '',
        ], [
            'ranking.required'      => 'Please Select Ranking',
            'branch_id.required'    => 'Please Select Branch',
            'member_id.required'    => 'Please Enter Member Id',
            'member_name.required'  => 'Please Enter Member Name',
            'placement_id.required' => 'Please Select Placement Id',
            'placement.required'    => 'Please Select Placement',
            'nationality.required'  => 'Please Select Country',
            'member_id.unique'      => 'Alrady Register As MLM User'
        ]);


        // check for register
        $data = User::where('unique_id', $request->member_id)->first();
        $check_pv = Ranking::where('id', $request->ranking)->first();

        if ($data->total_pv_point < $check_pv->points) {
            $request->validate([
                'less_pv' => 'required'
            ], [
                'less_pv.required' => 'You Not Able To Register Because Register User Does Not Have Sufficient PV Point'
            ]);
        }

        $user = User::where('id', $request->placement_id)->first();
        $right_id = $user->right_id;
        $left_id = $user->left_id;

        $user_sponser_count = User::where('id', Auth::user()->id)->first();
        $left_row_count = $user_sponser_count->left_row_count;
        $right_row_count = $user_sponser_count->right_row_count;

        if ($request->placement == 0) {
            $left_id = $request->member_id;

            $left_row_count = $left_row_count + 1;
        } else {
            $right_id = $request->member_id;

            $right_row_count = $right_row_count + 1;
        }



        User::where('id', $request->placement_id)->update([
            'left_id'   => $left_id,
            'right_id'  => $right_id,
        ]);

        // - pv point and update membership
        $ranking = Ranking::find($request->ranking);
        $registe_user = User::where('unique_id', $request->member_id)->first();
        User::where('unique_id', $request->member_id)->update([
            'is_mlm_member'        => 1,
            'total_pv_point'    => $registe_user->total_pv_point - $ranking->points,
            'rank_id'           => $request->ranking
        ]);

        // for uses of pv point
        UseOfPv::create([
            'user_id'       => $registe_user->id,
            'use_pv_point'  => $ranking->points,
            'description'   => 'Use For MLM Register MLM Register By ' . Auth::user()->Name,
        ]);

        $mlm_data['status'] = 1;
        MLMRegister::create($mlm_data);

        // direct sponsore

        $add_point_user = Ranking::find(Auth::user()->rank_id);
        if ($add_point_user->id == 1) {
            $per = 10;
            $direct_cal = ($per / 100) * $ranking->points;
        } else if ($add_point_user->id == 2) {
            $per = 15;
            $direct_cal = ($per / 100) * $ranking->points;
        } else if ($add_point_user->id == 3) {
            $per = 20;
            $direct_cal = ($per / 100) * $ranking->points;
        } else {
            $per = 25;
            $direct_cal = ($per / 100) * $ranking->points;
        }


        // add in DirectSponsor table
        DirectSponsor::create([
            'sponsors_id'   => Auth::user()->unique_id,
            'member_id'     => $request->member_id,
            'member_name'   => $request->member_name,
            'rank_id'       => $request->ranking,
            'point'         => $direct_cal,
        ]);


        // increment left and right row
        User::where('id', Auth::user()->id)->update([
            'left_row_count'        => $left_row_count,
            'right_row_count'       => $right_row_count,
            'total_direct_dponsor'  => Auth::user()->total_direct_dponsor + $direct_cal
        ]);


        echo json_encode(['status' => 'success', 'message' => 'Register Successfully']);
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