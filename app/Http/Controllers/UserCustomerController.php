<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UserCustomerController extends Controller
{
     public function __construct() {
		parent::__construct();
		$this->middleware("can:manipulate,App\UserCustomer");
	}
	
	public function index() {
		$users = User::select("id", "email", "fio", "year_birth", "phone", "role", "password")->where('role', '=', "a")->where('id', '=', auth()->user()->id)->orderBy("email")->get();
		return view("userscustomer.index", ["users" => $users]);
	}
	
	public function input(User $user) {
    return view("userscustomer.input", ["user" => $user]);
  }

  public function save(UserRequest $request) {
    $user = User::findOrFail($request->id);
    $user->fill($request->all())->save();
    return redirect()->action("UserCustomerController@index")
    ->with("status", "Пользователь " . $user->fio . " сохранен.");
  }
 //----------------------change password-----------------------
  public function changepwd(User $user) {
	  return view("userscustomer.cuchangepwd", ["user" => $user]);
  }
  
  public function update(Request $request) {
    $user = User::where('id', '=', $request->id)->first();
    $user->fill($request->all())->save();
	if ($request->password !="") {
		return redirect()->action("UserCustomerController@index")
		->with("status", "Пароль пользователя " . $user->fio . " изменен.");
	} else {
		return redirect()->action("UserCustomerController@index")
		->with("status", "Пользователь " . $user->fio . " сохранен.");
	}
  }
  
}
