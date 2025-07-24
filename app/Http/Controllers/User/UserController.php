<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
public function usersList(User $user){
        $this->authorize('view', $user);
        return view('admin.users-list', ['users' => $user->get()]);
    }

    public function editUser(Request $request, User $user){
        $this->authorize('update', $user);
        return view('admin.edit-user', ['user' => $user->find($request->user->id)]);
    }

    public function updateUser(UserUpdateRequest $request){
        try{
            $validation = $request->validated();
            $user = User::find($request->user);
            $user->update([
                'name' => $validation['name'],
                'email' => $validation['email'],
            ]);
            $user->roles()->sync($request->role);

            return redirect()->route('users-list')->with('message', 'Usuário atualizado');
        }catch(Throwable $e){
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id){
        $this->authorize('delete', User::class);
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users-list')->with('message', 'Excluído usuário com sucesso.');

        }catch(Throwable $e) {
            throw $e;
            return back()->withErrors($e->getMessage());
        }
    }
}
