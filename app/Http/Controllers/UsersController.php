<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Enum\Role;
use App\Helpers\Helper;
use App\Http\Requests\UserRequest;
use App\Models\Log;
use App\Models\Positions;
use App\Models\User;
use App\View\Components\DeleteModal;
use App\View\Components\Form\Table\Actions;
use App\View\Components\Form\Table\Text;
use App\View\Components\UserRestoreModal;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->withTrashed()->get();
        $data = [];
        foreach ($users as $user) {
            $actions = [];
            if(!$user->trashed()){
                $actions = [
                    new Actions\IconLink(route('users.edit',$user->id),'edit'),
                    new DeleteModal(
                        title:'Удалить пользователя?',
                        text:'Вы действительно хотите удалить пользователя?',
                        url:route('users.destroy', $user->id),
                        id:$user->id,
                    ),

                ];
            }else{
                $actions = [new UserRestoreModal(
                    fio:$user->fio,
                    id:$user->id,
                    url:route('users.restore', $user->id),
                )];
            }
            $data[] = [
                new Text($user->fio),
                new Text($user->year_birth),
                new Text($user->phone),
                new Text(Role::from($user->role)->label()),
                new Actions($actions)
            ];
        }
        $data = Helper::paginateArray($data);
        return view('users.index',['users' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::query()->where('id',$id)->firstOrFail();
        return view('users.edit',[
            'user' => $user,
            'action' => route('users.update', $user->id),
            'method' => 'PUT',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        User::query()->where('id',$id)->firstOrFail()->update($request->validated());
        Log::Log(User::find($id),'Обновление пользователя');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Log::Log(User::find($id),'Удаление пользователя');
        User::query()->where('id',$id)->firstOrFail()?->delete();
        return redirect()->route('users.index');
    }

    public function restore(string $id)
    {
        User::query()->withTrashed()->where('id',$id)->firstOrFail()->restore();
        return redirect()->route('users.index');
    }
}
