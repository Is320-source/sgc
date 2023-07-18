<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartaments;
use App\Models\Buildings;
use App\Models\User;
use App\Models\UserResidents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class residentController extends Controller
{
    private $totalpage = 10;

    public function index()
    {

        $user = auth()->user();


        $residents = UserResidents::select(
            'user_residents.id','user_residents.status','user_residents.created_at', 
            'user_residents.apartament_id', 'user_residents.user_id', 'user_residents.deleted_at',
            'users.name', 'users.phone','users.email', 'users.photo', 'users.address', 

            'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 

            'buildings.building', 

            'typologies.typology'
        )
        ->join('users', 'users.id', '=', 'user_residents.user_id')
        ->join('apartaments', 'apartaments.id', '=', 'user_residents.apartament_id')
        ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
        ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
        ->whereNull('user_residents.deleted_at')
        ->paginate($this->totalpage);


        $buildings = Buildings::select('*')
        ->whereNull('buildings.deleted_at')
        ->get();

        return view('dashboard.resident.list', compact('residents', 'buildings', 'user'));
    }


    public function report(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        // try {

            if ($data['type'] == '0'):

                $building = $data['building_id'] ?? null;

                $dateStart = $data['start'] ?? date('2022-01-01');
                $dateEnd = $data['end'] ?? date('Y-m-d');

                $data = [
                    'residents' => UserResidents::select(
                        'user_residents.id','user_residents.status','user_residents.created_at', 
                        'user_residents.apartament_id', 'user_residents.user_id', 'user_residents.deleted_at',
                        'users.name', 'users.phone','users.email', 'users.photo', 'users.address', 
            
                        'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 
            
                        'buildings.building', 
            
                        'typologies.typology'
                    )
                    ->join('users', 'users.id', '=', 'user_residents.user_id')
                    ->join('apartaments', 'apartaments.id', '=', 'user_residents.apartament_id')
                    ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
                    ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
                    ->where('apartaments.building_id', $building)
                    ->whereBetween("user_residents.created_at", [$dateStart, $dateEnd])
                    ->whereNull('user_residents.deleted_at')
                    ->get()
                ];


                $pdf = \PDF::loadView('dashboard.exports.pdf.residents', $data);
                return $pdf->download('moradores.pdf');
                
            else:
                $request->session()->flash('alert-danger', 'Exportação para excel está temporáriamente indisponível.');
                return redirect()->back();
            endif;

        // } catch (\Throwable $th) {
        //     //throw $th;
        //     $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
        //     return redirect()->back();
        // }

    
    }

    public function search(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        $name = $data['name'] ?? '';


        $residents = UserResidents::select(
            'user_residents.id','user_residents.status','user_residents.created_at', 
            'user_residents.apartament_id', 'user_residents.user_id', 'user_residents.deleted_at',
            'users.name', 'users.phone','users.email', 'users.photo', 'users.address', 

            'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 

            'buildings.building', 

            'typologies.typology'
        )
        ->join('users', 'users.id', '=', 'user_residents.user_id')
        ->join('apartaments', 'apartaments.id', '=', 'user_residents.apartament_id')
        ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
        ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
        ->where('users.name', 'LIKE', '%'. $name .'%')
        ->whereNull('user_residents.deleted_at')
        ->paginate($this->totalpage);

        $residentsTotal = UserResidents::select(
            'user_residents.id','user_residents.status','user_residents.created_at', 
            'user_residents.apartament_id', 'user_residents.user_id', 'user_residents.deleted_at',
            'users.name', 'users.phone','users.email', 'users.photo', 'users.address', 

            'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 

            'buildings.building', 

            'typologies.typology'
        )
        ->join('users', 'users.id', '=', 'user_residents.user_id')
        ->join('apartaments', 'apartaments.id', '=', 'user_residents.apartament_id')
        ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
        ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
        ->where('users.name', 'LIKE', '%'. $name .'%')
        ->whereNull('user_residents.deleted_at')
        ->count();


        $buildings = Buildings::select('*')
        ->whereNull('buildings.deleted_at')
        ->get();


        $searched = [
            'result' => 'Foi encontrado '. $residentsTotal .' dado(s) referente a pesquisa "'. $name .'".',
            'name'   => $name ?? '',
        ];

        return view('dashboard.resident.list', compact('residents', 'buildings', 'user', 'searched'));
    }




    public function store(Request $request){

        $data = $request->all();

        $residentPhone = User::select('*')
        ->where('users.phone', '=', $data['phone'])
        ->where('users.type', '4')
        ->whereNull('users.deleted_at')
        ->count();

        if($residentPhone){
            $request->session()->flash('alert-danger', 'Já existe um morador com este número ('. $data['phone'] .') no sistema.');
            return redirect()->back();
        } else {

            // dd($request->hasFile('contract'));

            try {


                if ($request->hasFile('bi') && $request->file('bi')->isValid() && $request->hasFile('contract') && $request->file('contract')->isValid()):

                    $requestBi = $request->bi;
                    $extension = $requestBi->extension();
                    $biName = md5($requestBi->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $requestBi->move(public_path('documents/bi/'), $biName);
                    $data['bi'] = asset('documents/bi'). '/' . $biName;

                    $requestContract = $request->contract;
                    $extension = $requestContract->extension();
                    $contractName = md5($requestContract->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $requestContract->move(public_path('documents/contracts/'), $contractName);
                    $data['contract'] = asset('documents/contracts'). '/' . $contractName;

                    $n = rand(1, 999999);
                    $pin = str_pad($n, 6, 1, STR_PAD_LEFT);

                    $user = new User();
                    $user->name       = $data['name'];
                    $user->phone      = $data['phone'];
                    $user->genere     = $data['genere'];
                    $user->type       = '4';
                    $user->photo      = asset('img/padrao.jpg');
                    $user->status     = '0';
                    $user->password   = Hash::make($pin);
                    $user->save();

                    $userFind = User::find($user->id);

                    // dd($data);

                    $apartament = Apartaments::find($data['apartament_id']) //  Get Apartament
                    ->where('apartaments.occupation', '0')
                    ->whereNull('apartaments.deleted_at')
                    ->first();

                    if ($apartament != NULL):
                        $apartament->occupation = '1';
                        $apartament->update();
                    else:
                        $userFind->delete();
                        $request->session()->flash('alert-danger', 'O apartamento mencionado não existe no sistema.');
                        return redirect()->back();
                    endif;

                    $resident = new UserResidents();
                    $resident->user_id       = $userFind->id;
                    $resident->apartament_id = $data['apartament_id'];
                    $resident->bi            = $data['bi'];
                    $resident->contract      = $data['contract'];
                    // $resident->contract      = $data['number_family'];
                    $resident->status        = '0';
                    $resident->save();
    

                    $request->session()->flash('alert-success', 'Morador cadastrado com sucesso.');
                    return redirect()->back();
                else:
                    $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
                    return redirect()->back();
                endif;
                
            } catch (\Throwable $th) {
                //throw $th;
                $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
                return redirect()->back();
            }

        }
    }



    public function show(Request $request, $id){

        try {


            $user = auth()->user();

            $resident = UserResidents::select(
                'user_residents.id','user_residents.status','user_residents.created_at', 'user_residents.bi', 
                'user_residents.contract', 'user_residents.apartament_id', 'user_residents.user_id', 'user_residents.deleted_at',
                'users.name', 'users.phone','users.email', 'users.photo', 'users.address', 

                'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 

                'buildings.building', 

                'typologies.typology'
            )
            ->join('users', 'users.id', '=', 'user_residents.user_id')
            ->join('apartaments', 'apartaments.id', '=', 'user_residents.apartament_id')
            ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
            ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
            ->whereNull('user_residents.deleted_at')
            ->findOrFail($id);

            return view('dashboard.resident.detail', compact('resident', 'user'));

        } catch (\Throwable $th) {
            $request->session()->flash('alert-danger', 'Error to connected in page.');
            return redirect()->back();
        }



    }

    public function update(Request $request, $id)
    {

        $data = $request->all();


        if (in_array("", $data)) :
            $request->session()->flash('alert-danger', 'It is important to fill in all fields.');
            return redirect()->back();
        endif;


        $resident = UserResidents::findOrFail($id);

        $user = User::findOrFail($resident->user_id);

        if ($data['phone'] != $user->phone):

            $userPhone = User::select('*')
            ->where('users.phone', '=', $data['phone'])
            ->where('users.type', '4')
            ->whereNull('users.deleted_at')
            ->count();
    
            if($userPhone):
                $request->session()->flash('alert-danger', 'Já existe um morador com este número ('. $data['phone'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {

            $resident->apartament_id = $data['apartament_id'];
            // $resident->bi            = $data['bi'];
            // $resident->contract      = $data['number_family'];
            $resident->status        = $data['status'];
            $resident->update();

            $user->name    = $data['name'];
            $user->phone   = $data['phone'];
            $user->genere  = $data['genere'];
            $user->update();
            

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Morador actualizado com sucesso.');
        return redirect()->back();

    }


    public function destroy(Request $request, $id){


        try {
            
            $up = UserResidents::findOrFail($id);
            $up->delete();

            $apartament = Apartaments::find($up->apartament_id); //  Get Apartament
            $apartament->occupation = '0';
            $apartament->update();

            
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }
        
        $request->session()->flash('alert-success', 'Morador excluído com sucesso.');
        return redirect()->back();
    }




    public function getResidents(){

        $residents = UserResidents::select('*')
        ->where('apartaments.occupation', '0')
        ->whereNull('user_residents.deleted_at')
        ->orderBy('user_residents.resident', 'DESC')
        ->get();


        return $residents;
    }
}
