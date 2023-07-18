<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartaments;
use App\Models\Buildings;
use App\Models\Typologies;
use Illuminate\Http\Request;

class apartamentController extends Controller
{
    private $totalpage = 10;

    public function index()
    {

        $user = auth()->user();

        $apartaments = Apartaments::select(
            'apartaments.id','apartaments.status','apartaments.created_at','apartaments.notes', 'apartaments.occupation', 
            'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 
            
            'buildings.building', 

            'typologies.typology'
        )
        ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
        ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
        ->whereNull('apartaments.deleted_at')
        ->paginate($this->totalpage);


        $buildings = Buildings::select('*')
        ->whereNull('buildings.deleted_at')
        ->get();


        $typologies = Typologies::select('*')
        ->whereNull('typologies.deleted_at')
        ->get();


        return view('dashboard.apartament.list', compact('apartaments', 'buildings', 'typologies', 'user'));
    }


    
    public function search(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        $name = $data['name'] ?? '';

        // Search Reference
        $apartaments = Apartaments::select(
            'apartaments.id','apartaments.status','apartaments.created_at','apartaments.notes', 'apartaments.occupation', 
            'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 
            
            'buildings.building', 

            'typologies.typology'
        )
        ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
        ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
        ->where('apartaments.apartament', 'LIKE', '%'. $name .'%')
        ->whereNull('apartaments.deleted_at')
        ->paginate($this->totalpage);


        $apartamentsTotal = Apartaments::select(
            'apartaments.id','apartaments.status','apartaments.created_at','apartaments.notes', 'apartaments.occupation', 
            'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 
            
            'buildings.building', 

            'typologies.typology'
        )
        ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
        ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
        ->where('apartaments.apartament', 'LIKE', '%'. $name .'%')
        ->whereNull('apartaments.deleted_at')
        ->count();


        $buildings = Buildings::select('*')
        ->whereNull('buildings.deleted_at')
        ->get();


        $typologies = Typologies::select('*')
        ->whereNull('typologies.deleted_at')
        ->get();

        $searched = [
            'result' => 'Foi encontrado '. $apartamentsTotal .' dado(s) referente a pesquisa "'. $name .'".',
            'name'   => $name ?? ''
        ];

        return view('dashboard.apartament.list', compact('apartaments', 'buildings', 'typologies', 'user', 'searched'));
    }


    public function report(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        try {

            if ($data['type'] == '0'):

                $building = $data['building_id'] ?? null;

                $dateStart = $data['start'] ?? date('2022-01-01');
                $dateEnd = $data['end'] ?? date('Y-m-d');

                $data = [
                    'apartaments' => Apartaments::select(
                                        'apartaments.id','apartaments.status','apartaments.created_at','apartaments.notes', 
                                        'apartaments.occupation', 
                                        'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 
                                        
                                        'buildings.building', 
                                        
                                        'typologies.typology'
                                    )
                                    ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
                                    ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
                                    ->where("apartaments.building_id", $building)
                                    ->whereBetween("apartaments.created_at", [$dateStart, $dateEnd])
                                    ->whereNull('apartaments.deleted_at')
                                    ->get()
                ];

                // dd($data['apartaments']);


                $pdf = \PDF::loadView('dashboard.exports.pdf.apartaments', $data);
                return $pdf->download('apartamentos.pdf');
                
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

        $apartamentName = Apartaments::select('*')
        ->where('apartaments.apartament', '=', $data['apartament'])
        ->whereNull('apartaments.deleted_at')
        ->count();

        if($apartamentName){
            $request->session()->flash('alert-danger', 'Já existe um apartamento com este nome ('. $data['apartament'] .') no sistema.');
            return redirect()->back();
        } else {

            try {

                $apartament = new apartaments();
                $apartament->apartament  = $data['apartament'];
                $apartament->notes       = $data['notes'];
                $apartament->typology_id = $data['typology_id'];
                $apartament->building_id = $data['building_id'];
                $apartament->status    = '0';
                $apartament->save();

                $building = Buildings::findOrFail($data['building_id']);
                $building->total_apartament += 1;
                $building->update();
            
                $request->session()->flash('alert-success', 'Apartamento cadastrado com sucesso.');
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


        $apartament = Apartaments::findOrFail($id);
        if ($data['apartament'] != $apartament->apartament):

            $apartamentName = Apartaments::select('*')
            ->where('apartaments.apartament', '=', $data['apartament'])
            ->whereNull('apartaments.deleted_at')
            ->count();

            if ($apartamentName > 0) :
                $request->session()->flash('alert-danger', 'Já existe um apartamento com este nome ('. $data['apartament'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {
            
            $apartament = Apartaments::findOrFail($id);
            $apartament->apartament  = $data['apartament'];
            $apartament->notes       = $data['notes'];
            $apartament->typology_id = $data['typology_id'];
            $apartament->building_id = $data['building_id'];
            $apartament->update();

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Apartamento actualizada com sucesso.');
        return redirect()->back();

    }


    public function destroy(Request $request, $id){


        try {
            
            $up = Apartaments::findOrFail($id);
            $up->delete();

            $building = Buildings::findOrFail($up->building_id);
            $building->total_apartament -= 1;
            $building->update();

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }
        
        $request->session()->flash('alert-success', 'Apartamento excluído com sucesso.');
        return redirect()->back();
    }




    public function apartamentsBuildings($buildingId){

        $apartaments = Apartaments::select(
            'apartaments.id','apartaments.status','apartaments.created_at','apartaments.notes', 'apartaments.occupation', 
            'apartaments.apartament', 'apartaments.building_id','apartaments.typology_id', 
            
            'buildings.building', 

            'typologies.typology'
        )
        ->join('buildings', 'buildings.id', '=', 'apartaments.building_id')
        ->join('typologies', 'typologies.id', '=', 'apartaments.typology_id')
        ->where('apartaments.occupation', '0')
        ->where('apartaments.status', '0')
        ->where('apartaments.building_id', $buildingId)
        ->whereNull('apartaments.deleted_at')
        ->get();


        return $apartaments;
    }
}
