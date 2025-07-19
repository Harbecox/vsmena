<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Positions;
use App\Http\Requests\UserRequest;

class UserManagerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware("can:manipulate,App\UserManager");
    }

    public function index()
    {
        $posits = Positions::select("restaurants.id")
            ->join("users", "positions.users_id", "users.id")
            ->join("restaurants", "positions.restaurants_id", "restaurants.id")
            ->whereIn('users.role', array("e"))->where('users.id', '=', auth()->user()->id)->orderBy("users.fio")->get();
        if ($posits->isNotEmpty()) {
            foreach ($posits as $posit) {
                $restaurantsID[] = $posit->id;
            }
        } else {
            $restaurantsID = array();
        }

        if (!empty($restaurantsID)) {
            $users = Positions::select("users.id", "users.email", "users.fio", "users.year_birth", "users.phone", "restaurants.name", "positions.name as pname", "users.role", "users.password")
                ->join("users", "positions.users_id", "users.id")
                ->join("restaurants", "positions.restaurants_id", "restaurants.id")
                ->whereIn('users.role', array("a", "e"))->whereIn('positions.restaurants_id', $restaurantsID)->orderBy("users.email")->get();   //where('users.id', '=', auth()->user()->id)->
            return view("usersmanager.index", ["users" => $users]);
        } else {
            return redirect()->action(MainController::class."@index")
                ->with("status", "Вы не поставлены на должность в ресторане - обратитесь к администратору.");
        }
    }

    public function input(User $user)
    {
        return view("usersmanager.input", ["user" => $user]);
    }

    public function save(UserRequest $request)
    {
        $user = User::findOrFail($request->id);
        $user->fill($request->all())->save();
        return redirect()->action("UserManagerController@index")
            ->with("status", "Пользователь " . $user->fio . " сохранен.");
    }

    //----------------------change password-----------------------
    public function changepwd(User $user)
    {
        return view("usersmanager.mchangepwd", ["user" => $user]);
    }

    public function update(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();
        $user->fill($request->all())->save();
        if ($request->password != "") {
            return redirect()->action("UserManagerController@index")
                ->with("status", "Пароль пользователя " . $user->fio . " изменен.");
        } else {
            return redirect()->action("UserManagerController@index")
                ->with("status", "Пользователь " . $user->fio . " сохранен.");
        }
    }

    //--------------------------delete---------------------------------
    public function destroy(User $user)
    {
        $fio = $user->fio;
        $user->delete();
        return redirect()->action("UserManagerController@index")
            ->with("status", "Пользователь " . $fio . " удалён.");
    }
}
