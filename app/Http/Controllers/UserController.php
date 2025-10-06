<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware("can:manipulate,App\User");
    }

    public function index()
    {
        $users = User::select("id", "fio", "year_birth", "phone", "role", "password")->get();
        return view("users.index", ["users" => $users]);
    }

    public function input(User $user)
    {
        return view("users.input", ["user" => $user]);
    }

    public function save(UserRequest $request)
    {
        $user = User::findOrFail($request->id);
        $user->fill($request->all())->save();

        //-------------------------insert logs-----------------------------------------
        $logs_title = "обновление профиля сотрудника";
        $positions_id = DB::table('positions')->select('positions.id')->join("users", "positions.users_id", "users.id")->where('users.id', '=', $request->id)->first();
        if (!empty($positions_id->id)) {
            //var_dump($positions_id->id);die;
            DB::table('logs')->insert(['positions_id' => $positions_id->id, 'title' => $logs_title, 'admin_id' => auth()->user()->id]);
        }
        //-----------------------------------------------------------------------------

        return redirect()->action("UserController@index")
            ->with("status", "Пользователь " . $user->fio . " сохранен.");
    }

    public function destroy(User $user)
    {
        $fio = $user->fio;
        $user->delete();
        return redirect()->action("UserController@index")
            ->with("status", "Пользователь " . $fio . " удалён.");
    }

    //----------------------change password-----------------------
    public function changepwd(User $user)
    {
        return view("users.achangepwd", ["user" => $user]);
    }

    public function update(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();
        $user->fill($request->all())->save();
        return redirect()->action("UserController@index")
            ->with("status", "Пароль пользователя " . $user->fio . " изменен.");
    }
}
