<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class serviceController extends Controller
{
    private $totalpage = 10;

    public function index()
    {

        $user = auth()->user();

        $services = Services::select('*')
        ->whereNull('services.deleted_at')
        ->paginate($this->totalpage);

        return view('dashboard.service.list', compact('services', 'user'));
    }


    public function store(Request $request){

        $data = $request->all();

        $serviceName = Services::select('*')
        ->where('services.service', '=', $data['service'])
        ->whereNull('services.deleted_at')
        ->count();

        if($serviceName){
            $request->session()->flash('alert-danger', 'Já existe um serviço com este nome ('. $data['service'] .') no sistema.');
            return redirect()->back();
        } else {

            try {
                    
                $service = new Services();
                $service->service     = $data['service'];
                $service->description = $data['description'];
                $service->status      = '0';
                $service->save();

                $request->session()->flash('alert-success', 'Serviço cadastrado com sucesso.');
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
                    'services' => Services::select('*')
                    ->whereBetween("services.created_at", [$dateStart, $dateEnd])
                    ->whereNull('services.deleted_at')
                    ->get()
                ];

                // dd($data['services']);

                $pdf = \PDF::loadView('dashboard.exports.pdf.services', $data);
                return $pdf->download('serviços.pdf');
                
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


        $services = Services::select('*')
        ->where('services.service', 'LIKE', '%'. $name .'%')
        ->whereNull('services.deleted_at')
        ->paginate($this->totalpage);


        $servicesTotal = Services::select('*')
        ->where('services.service', 'LIKE', '%'. $name .'%')
        ->whereNull('services.deleted_at')
        ->count();

        $searched = [
            'result' => 'Foi encontrado '. $servicesTotal .' dado(s) referente a pesquisa "'. $name .'".',
            'name'   => $name ?? '',
        ];

        return view('dashboard.service.list', compact('services', 'user', 'searched'));
    }



    public function update(Request $request, $id)
    {

        $data = $request->all();


        if (in_array("", $data)) :
            $request->session()->flash('alert-danger', 'It is important to fill in all fields.');
            return redirect()->back();
        endif;


        $service = Services::findOrFail($id);
        if ($data['service'] != $service->service):

            $serviceName = Services::select('*')
            ->where('services.service', '=', $data['service'])
            ->whereNull('services.deleted_at')
            ->count();

            if ($serviceName > 0) :
                $request->session()->flash('alert-danger', 'Já existe um serviço com este nome ('. $data['service'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {
            
            $service = Services::findOrFail($id);
            $service->service     = $data['service'];
            $service->description = $data['description'];
            $service->status      = $data['status'];
            $service->update();

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Serviço actualizado com sucesso.');
        return redirect()->back();

    }


    public function destroy(Request $request, $id){


        try {
            
            $up = Services::findOrFail($id);
            $up->delete();
            
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }
        
        $request->session()->flash('alert-success', 'Serviço excluído com sucesso.');
        return redirect()->back();
    }




    public function getServices(){

        $services = Services::select('*')
        ->whereNull('services.deleted_at')
        ->orderBy('services.service', 'DESC')
        ->get();


        return $services;
    }
}
