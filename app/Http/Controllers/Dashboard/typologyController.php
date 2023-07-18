<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Typologies;
use Illuminate\Http\Request;

class typologyController extends Controller
{
    private $totalpage = 10;

    public function index()
    {

        $user = auth()->user();

        $typologies = Typologies::select('*')
        ->whereNull('typologies.deleted_at')
        ->paginate($this->totalpage);

        return view('dashboard.typology.list', compact('typologies', 'user'));
    }


    public function store(Request $request){

        $data = $request->all();

        $typologyName = Typologies::select('*')
        ->where('typologies.typology', '=', $data['typology'])
        ->whereNull('typologies.deleted_at')
        ->count();

        if($typologyName){
            $request->session()->flash('alert-danger', 'Já existe um Tipologia com este nome ('. $data['typology'] .') no sistema.');
            return redirect()->back();
        } else {

            try {
                    
                $typology = new Typologies();
                $typology->typology  = $data['typology'];
                $typology->notes     = $data['notes'];
                $typology->status    = '0';
                $typology->save();

                $request->session()->flash('alert-success', 'Tipologia cadastrado com sucesso.');
                return redirect()->back();
                
            } catch (\Throwable $th) {
                //throw $th;
                $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
                return redirect()->back();
            }

        }
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
                    'typologies' =>Typologies::select('*')
                    ->whereBetween("typologies.created_at", [$dateStart, $dateEnd])
                    ->whereNull('typologies.deleted_at')
                    ->get()
                ];

                // dd($data['typologies']);

                $pdf = \PDF::loadView('dashboard.exports.pdf.typologies', $data);
                return $pdf->download('tipologias.pdf');
                
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



    public function search(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        $name = $data['name'] ?? '';


        $typologies = Typologies::select('*')
        ->where('typologies.typology', 'LIKE', '%'. $name .'%')
        ->whereNull('typologies.deleted_at')
        ->paginate($this->totalpage);


        $typologiesTotal = Typologies::select('*')
        ->where('typologies.typology', 'LIKE', '%'. $name .'%')
        ->whereNull('typologies.deleted_at')
        ->count();

        $searched = [
            'result' => 'Foi encontrado '. $typologiesTotal .' dado(s) referente a pesquisa "'. $name .'".',
            'name'   => $name ?? '',
        ];

        return view('dashboard.typology.list', compact('typologies', 'user', 'searched'));
    }




    public function update(Request $request, $id)
    {

        $data = $request->all();


        if (in_array("", $data)) :
            $request->session()->flash('alert-danger', 'It is important to fill in all fields.');
            return redirect()->back();
        endif;


        $typology = Typologies::findOrFail($id);
        if ($data['typology'] != $typology->typology):

            $typologyName = Typologies::select('*')
            ->where('typologies.typology', '=', $data['typology'])
            ->whereNull('typologies.deleted_at')
            ->count();

            if ($typologyName > 0) :
                $request->session()->flash('alert-danger', 'Já existe uma tipologia com este nome ('. $data['typology'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {
            
            $typology = Typologies::findOrFail($id);
            $typology->typology  = $data['typology'];
            $typology->notes     = $data['notes'];
            $typology->status    = $data['status'];
            $typology->update();

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Tipologia actualizada com sucesso.');
        return redirect()->back();

    }


    public function destroy(Request $request, $id){


        try {
            
            $up = Typologies::findOrFail($id);
            $up->delete();
            
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }
        
        $request->session()->flash('alert-success', 'Tipologia excluído com sucesso.');
        return redirect()->back();
    }




    public function getTypologies(){

        $typologies = Typologies::select('*')
        ->whereNull('typologies.deleted_at')
        ->orderBy('typologies.typology', 'DESC')
        ->get();


        return $typologies;
    }
}

