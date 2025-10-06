<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\passwordChangeRequest;
use App\View\Components\Form\Modal;
use App\View\Components\Form\Table\ActionDropdown;
use App\View\Components\Form\Table\Date;
use App\View\Components\Form\Table\Text;
use App\View\Components\UserCustomerChangePwdModal;
use App\View\Components\UserCustomerEditModal;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserCustomerController extends Controller
{
//     public function __construct() {
//		parent::__construct();
//		$this->middleware("can:manipulate,App\UserCustomer");
//	}

    public function index()
    {
        $users = User::select("fio", "year_birth", "phone", "role", 'id')->where('id', '=', auth()->user()->id)->get();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                new Text($user->fio),
                new Text($user->year_birth),
                new Text($user->phone),
                new Text(Helper::role_to_russian()),
                new ActionDropdown([
                    new UserCustomerEditModal(),
                    new UserCustomerChangePwdModal()
                ])
            ];
        }
        $data = Helper::paginateArray($data);
        return view("userscustomer.index", ["users" => $data]);
    }

    public function save(UserRequest $request)
    {
        $user = auth()->user();
        $user->fill($request->all())->save();
        return redirect()->route('userscustomer.index')
            ->with("status", "Пользователь " . $user->fio . " сохранен.");
    }

    public function update(passwordChangeRequest $request)
    {
        $user = auth()->user();
        $user->fill($request->all())->save();
        return redirect()->route("userscustomer.index")
            ->with("status", "Пароль пользователя " . $user->fio . " изменен.");
    }

}
