<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Buildings;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class buildingController extends Controller
{
    private $totalpage = 10;

    public function index()
    {

        $user = auth()->user();

        $buildings = Buildings::select('*')
        ->whereNull('buildings.deleted_at')
        ->paginate($this->totalpage);

        return view('dashboard.building.list', compact('buildings', 'user'));
    }


    
    public function search(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        $name = $data['name'] ?? '';

        $buildings = Buildings::select('*')
        ->where('buildings.building', 'LIKE', '%'. $name .'%')
        ->whereNull('buildings.deleted_at')
        ->paginate($this->totalpage);


        $buildingsTotal = Buildings::select('*')
        ->where('buildings.building', 'LIKE', '%'. $name .'%')
        ->whereNull('buildings.deleted_at')
        ->count();

        $searched = [
            'result' => 'Foi encontrado '. $buildingsTotal .' dado(s) referente a pesquisa "'. $name .'".',
            'name'   => $name ?? '',
        ];

        return view('dashboard.building.list', compact('buildings', 'user', 'searched'));
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
                    'buildings' => Buildings::select('*')
                    ->whereBetween("buildings.created_at", [$dateStart, $dateEnd])
                    ->whereNull('buildings.deleted_at')
                    ->get()
                ];

                // dd($data['buildings']);

                $pdf = \PDF::loadView('dashboard.exports.pdf.building', $data);
                return $pdf->download('predios.pdf');
                
            else:
                // return \Excel::download(new agendamentosGeralExport ($status, $de, $ate), 'predios.xlsx');
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

        $buildingName = Buildings::select('*')
        ->where('buildings.building', '=', $data['building'])
        ->whereNull('buildings.deleted_at')
        ->count();

        if($buildingName){
            $request->session()->flash('alert-danger', 'Já existe um prédio com este nome ('. $data['building'] .') no sistema.');
            return redirect()->back();
        } else {

            try {
                    
                $building = new Buildings();
                $building->building  = $data['building'];
                $building->notes     = $data['notes'];
                $building->status    = '0';
                $building->save();

                $request->session()->flash('alert-success', 'Prédio cadastrado com sucesso.');
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


        $building = Buildings::findOrFail($id);
        if ($data['building'] != $building->building):

            $buildingName = Buildings::select('*')
            ->where('buildings.building', '=', $data['building'])
            ->whereNull('buildings.deleted_at')
            ->count();

            if ($buildingName > 0) :
                $request->session()->flash('alert-danger', 'Já existe um prédio com este nome ('. $data['building'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {
            
            $building = Buildings::findOrFail($id);
            $building->building  = $data['building'];
            $building->notes     = $data['notes'];
            $building->status    = $data['status'];
            $building->update();

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Prédio actualizado com sucesso.');
        return redirect()->back();

    }


    public function destroy(Request $request, $id){


        try {
            
            $up = Buildings::findOrFail($id);
            $up->delete();
            
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }
        
        $request->session()->flash('alert-success', 'Prédio excluído com sucesso.');
        return redirect()->back();
    }




    public function getBuildings(){

        $buildings = Buildings::select('*')
        ->whereNull('buildings.deleted_at')
        ->orderBy('buildings.building', 'DESC')
        ->get();


        return $buildings;
    }
}
