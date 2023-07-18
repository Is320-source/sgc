<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    private $totalpage = 10;

    public function index()
    {

        $userAuth = auth()->user();

        $user = User::select('*')
        ->where('users.id', '=', $userAuth->id)->first();

        $users = User::select(
            'users.id', 'users.name', 'users.email', 'users.phone', 'users.genere', 'users.address', 
            'users.photo', 'users.status', 'users.first_login', 'users.type', 'users.created_at', 'users.deleted_at',
        )
        ->whereIn('users.type', ['0', '1', '2'])
        ->whereNull('users.deleted_at')
        ->orderBy('users.name', 'DESC')
        ->get();

        return view('dashboard.user.list', compact('user', 'users'));
    }


    public function store(Request $request){

        $data = $request->all();

        $userEmail = User::select()
            ->where('email', '=', $data['email'])
            ->whereNull('users.deleted_at')
            ->count();

        if($userEmail){
            $request->session()->flash('alert-danger', 'Email já existente ('. $data['email'] .') no sistema.');
            return redirect()->back();
        } elseif (strlen($data['password']) > 8){

            if ($data['password'] == $data['confirm_password']){

                $user = new User;
                $user->name         = $data['name'];
                $user->email        = $data['email'];
                $user->phone        = $data['phone'];
                $user->genere       = '0';
                $user->type         = $data['type'];
                $user->photo        = asset('images/padrao.jpg');
                $user->status       = '0';
                $user->password     = Hash::make($data['password']);
                $user->save();

                $request->session()->flash('alert-success', 'Administrador cadastrado com sucesso.');
                return redirect()->back();

            } else {
                $request->session()->flash('alert-danger', 'The passwords entered are different.');
                return redirect()->back();
            }

        } else {
            $request->session()->flash('alert-danger', 'The password must contain 8 or more caracters.');
            return redirect()->back();
        }
    }

    public function status(Request $request, $id){

        $data = $request->all();

        $user = User::findOrFail($id);

        if ($user->id != Null):

            if ($user->status == '0'):
                $user->status = '1';
                $user->update();
            else:
                $user->status = '0';
                $user->update();
            endif;

            $request->session()->flash('alert-success', 'O estado do administrador foi modificado com sucesso..');
            return redirect()->back();
        else:

            $request->session()->flash('alert-danger', 'Ocorreu um erro, tente novamente mais tarde.');
            return redirect()->back();

        endif;

    }

    public function show(Request $request, $id){

        $user = User::select(
            'users.id',
            'users.name',
            'users.email',
            'users.phone',
            'users.photo',
            'users.status',
            'users.genere',
            'users.first_login',
            'users.address',
            'users.type',
            'users.created_at',
        )
        ->whereIn('type', ['0', '1'])
        ->whereNull('users.deleted_at')
        ->findOrFail($id);

        try {
            return view('dashboard.user.profile', compact('user'));
        } catch (\Throwable $th) {
            $request->session()->flash('alert-danger', 'Error to connected in page.');
            return redirect()->back();
        }



    }


    public function update(Request $request, $id)
    {

        $data = $request->all();

        // dd($data);

        if (in_array("", $data)) :
            $request->session()->flash('alert-danger', 'É necessário preencher todos os campos.');
            return redirect()->back();
        endif;



        $user = User::findOrFail($id);

        try {

            if ($request->hasFile('photo') && $request->file('photo')->isValid()){

                $requestImage = $request->photo;
                $extension = $requestImage->extension();

                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestImage->move(public_path('images/adm/'), $imageName);
                $data['photo'] = asset('images/adm'). '/' . $imageName;

                $user = User::findOrFail($id);
                $user->photo           = $data['photo'];
                $user->update();


                $request->session()->flash('alert-success', 'Sua foto foi actualizada com sucesso.');
                return redirect()->back();

            } else {


                $phoneSearch = 0;
                if ($data['phone'] != $user->phone):
                    $phoneSearch = User::select('*')
                    ->where('users.phone', $data['phone'])
                    ->whereNull('users.deleted_at')
                    ->count();
                endif;

                $emailSearch = 0;
                if ($data['email'] != $user->email):
                    $emailSearch = User::select('*')
                    ->where('users.email', $data['email'])
                    ->whereNull('users.deleted_at')
                    ->count();
                endif;

                if ($phoneSearch != '0'):
                $request->session()->flash('alert-danger', 'The Phone Number exist in data base.');
                return redirect()->back();
                elseif ($emailSearch != '0'):
                $request->session()->flash('alert-danger', 'E-mail já existe no sistema.');
                return redirect()->back();
                endif;
                

                $user = User::findOrFail($id);
                $user->name            = $data['name'];
                $user->email           = $data['email'];
                $user->phone           = $data['phone'];
                $user->genere          = $data['genere'];
                $user->address         = $data['address'];
                $user->update();


                $request->session()->flash('alert-success', 'Seu perfil foi actualizado com sucesso.');
                return redirect()->back();
            }


        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'Ocorreu um erro, tente novamente.');
            return redirect()->back();
        }


    }

    public function password(Request $request, $id)
    {

        $data = $request->all();

        if (in_array("", $data)) :
            $request->session()->flash('alert-danger', 'É necessário preencher todos os campos.');
            return redirect()->back();
        endif;


        $user = User::findOrFail($id);


        try {

            if (Hash::check($data['old_password'], $user->password)) :

                if ($data['new_password'] == $data['confirm_password']):

                    $firstLogin = $user->first_login;

                    $user->first_login = '0';
                    $user->password = Hash::make($request->new_password);
                    $user->update();

                    $request->session()->flash('alert-success', 'Sua senha foi alterada com sucesso.');
                    return redirect()->back();
                else:
                    $request->session()->flash('alert-danger', 'As senhas inseridas são diferentes.');
                    return redirect()->back();
                endif;

            else:
                $request->session()->flash('alert-danger', 'Senha actual está incorrecta.');
                return redirect()->back();
            endif;


        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'Ocorreu um erro, tente novamente.');
            return redirect()->back();
        }

    }

    

    public function destroy(Request $request, $id)
    {

        $up = User::findOrFail($id);
        $up->delete();

        $request->session()->flash('alert-success', 'Administrador excluído com sucesso.');
        return redirect()->back();

    }




    public function getUsers(){

        $users = User::select(
            'users.id', 'users.first_name', 'users.second_name', 'users.email', 'users.phone', 'users.genere', 'users.address', 
            'users.photo', 'users.status', 'users.first_login', 'users.type', 'users.created_at', 'users.deleted_at',
        )
        ->whereIn('users.type', ['0', '1'])
        ->whereNull('users.deleted_at')
        ->orderBy('users.first_name', 'DESC')
        ->get();

        return $users;
    }

}
