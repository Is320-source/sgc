<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPorters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class paymentController extends Controller
{
    
    private $totalpage = 10;
    
    public function index()
    {

        $user = auth()->user();

        $porters = UserPorters::select(
            'user_porters.id','user_porters.status','user_porters.created_at', 
            'users.name', 'users.phone','users.email', 'users.photo', 'users.address'
        )
        ->join('users', 'users.id', '=', 'user_porters.user_id')
        ->whereNull('user_porters.deleted_at')
        ->paginate($this->totalpage);

        return view('dashboard.payment.list', compact('porters', 'user'));
    }

  
    public function search(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        $name = $data['name'] ?? '';


        $porters = UserPorters::select(
            'user_porters.id','user_porters.status','user_porters.created_at', 
            'users.name', 'users.phone','users.email', 'users.photo', 'users.address'
        )
        ->join('users', 'users.id', '=', 'user_porters.user_id')
        ->where('users.name', 'LIKE', '%'. $name .'%')
        ->whereNull('user_porters.deleted_at')
        ->paginate($this->totalpage);


        $portersTotal = UserPorters::select(
            'user_porters.id','user_porters.status','user_porters.created_at', 
            'users.name', 'users.phone','users.email', 'users.photo', 'users.address'
        )
        ->join('users', 'users.id', '=', 'user_porters.user_id')
        ->where('users.name', 'LIKE', '%'. $name .'%')
        ->whereNull('user_porters.deleted_at')
        ->count();

        $searched = [
            'result' => 'Foi encontrado '. $portersTotal .' dado(s) referente a pesquisa "'. $name .'".',
            'name'   => $name ?? '',
        ];

        return view('dashboard.porter.list', compact('porters', 'user', 'searched'));
    }



    public function report(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        try {

            if ($data['type'] == '0'):

                $dateStart = $data['start'] ?? date('2022-01-01');
                $dateEnd = $data['end'] ?? date('Y-m-d');

                $data = [
                    'porters' => UserPorters::select(
                        'user_porters.id','user_porters.status','user_porters.created_at', 
                        'users.name', 'users.phone','users.email', 'users.photo', 'users.address'
                    )
                    ->join('users', 'users.id', '=', 'user_porters.user_id')
                    ->whereBetween("user_porters.created_at", [$dateStart, $dateEnd])
                    ->whereNull('user_porters.deleted_at')
                    ->get()
                ];

                // dd($data['buildings']);

                $pdf = \PDF::loadView('dashboard.exports.pdf.porter', $data);
                return $pdf->download('porteiros.pdf');
                
            else:
                $request->session()->flash('alert-danger', 'Exportação para excel está temporáriamente indisponível.');
                return redirect()->back();
            endif;

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

    
    }


    public function store(Request $request){

        $data = $request->all();

        $porterName = UserPorters::select('*')
        ->join('users', 'users.id', '=', 'user_porters.user_id')
        ->where('users.phone', '=', $data['phone'])
        ->whereNull('user_porters.deleted_at')
        ->count();

        if($porterName){
            $request->session()->flash('alert-danger', 'Já existe um porteiro com este telefone ('. $data['phone'] .') no sistema.');
            return redirect()->back();
        } else {

            try {

                $n = rand(1, 999999);
                $pin = str_pad($n, 6, 1, STR_PAD_LEFT);
                    
                
                $user = new User();
                $user->name       = $data['name'];
                $user->phone      = $data['phone'];
                $user->genere     = $data['genere'];
                $user->type       = '3';
                $user->photo      = asset('images/padrao.jpg');
                $user->status     = '0';
                $user->password   = Hash::make($pin);
                $user->save();

                $userFind = User::find($user->id);

                $resident = new UserPorters();
                $resident->user_id       = $userFind->id;
                $resident->status    = '0';
                $resident->save();
    

                $request->session()->flash('alert-success', 'Porteiro cadastrado com sucesso.');
                return redirect()->back();
                
            } catch (\Throwable $th) {
                //throw $th;
                $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
                return redirect()->back();
            }

        }
    }


    public function update(Request $request, $id)
    {

        $data = $request->all();


        if (in_array("", $data)) :
            $request->session()->flash('alert-danger', 'It is important to fill in all fields.');
            return redirect()->back();
        endif;


        $porter = UserPorters::findOrFail($id);
        if ($data['porter'] != $porter->porter):

            $porterName = UserPorters::select('*')
            ->where('porters.user_id', '=', $data['user_id'])
            ->whereNull('user_porters.deleted_at')
            ->count();

            if ($porterName > 0) :
                $request->session()->flash('alert-danger', 'Já existe uma porteiro com este nome ('. $data['porter'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {
            
            $porter = UserPorters::findOrFail($id);
            $porter->apartament_id = $data['apartament_id'];
            $porter->number_family = $data['number_family'];
            $porter->update();

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Porteiro actualizado com sucesso.');
        return redirect()->back();
    }


    public function destroy(Request $request, $id){


        try {
            
            $up = UserPorters::findOrFail($id);
            $up->delete();
            
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }
        
        $request->session()->flash('alert-success', 'Porteiro excluído com sucesso.');
        return redirect()->back();
    }




    public function getPorters(){

        $porters = UserPorters::select('*')
        ->whereNull('porters.deleted_at')
        ->orderBy('porters.id', 'DESC')
        ->get();


        return $porters;
    }
}
