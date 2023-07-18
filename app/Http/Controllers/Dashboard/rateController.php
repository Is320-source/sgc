<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Rates;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class rateController extends Controller
{
    
    private $totalpage = 10;
    
    public function index()
    {

        $user = auth()->user();

        $rates = Rates::select('*')
        ->whereNull('rates.deleted_at')
        ->paginate($this->totalpage);

        return view('dashboard.payment.rate', compact('rates', 'user'));
    }

  
    public function search(Request $request)
    {

        $user = auth()->user();

        $data = $request->all();

        $name = $data['name'] ?? '';


        $rates = Rates::select(
            'rates.id','rates.status','rates.created_at', 
            'rates.name', 'rates.phone','rates.email', 'rates.photo', 'rates.address'
        )
        ->join('users', 'rates.id', '=', 'rates.user_id')
        ->where('rates.name', 'LIKE', '%'. $name .'%')
        ->whereNull('rates.deleted_at')
        ->paginate($this->totalpage);


        $ratesTotal = Rates::select(
            'rates.id','rates.status','rates.created_at', 
            'rates.name', 'rates.phone','rates.email', 'rates.photo', 'rates.address'
        )
        ->join('users', 'rates.id', '=', 'rates.user_id')
        ->where('rates.name', 'LIKE', '%'. $name .'%')
        ->whereNull('rates.deleted_at')
        ->count();

        $searched = [
            'result' => 'Foi encontrado '. $ratesTotal .' dado(s) referente a pesquisa "'. $name .'".',
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
                    'porters' => Rates::select(
                        'rates.id','rates.status','rates.created_at', 
                        'rates.name', 'rates.phone','rates.email', 'rates.photo', 'rates.address'
                    )
                    ->join('users', 'rates.id', '=', 'rates.user_id')
                    ->whereBetween("rates.created_at", [$dateStart, $dateEnd])
                    ->whereNull('rates.deleted_at')
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

        $rateName = Rates::select('*')
        ->where('rates.rate_name', '=', $data['rate_name'])
        ->whereNull('rates.deleted_at')
        ->count();

        if($rateName){
            $request->session()->flash('alert-danger', 'Já existe uma taxa ('. $data['rate_name'] .') no sistema.');
            return redirect()->back();
        } else {

            try {
                
                $rate = new Rates();
                $rate->rate_name  = $data['rate_name'];
                $rate->value      = $data['value'];
                $rate->mult       = $data['mult'];
                $rate->date_limit = $data['date_limit'];
                $rate->status     = '0';
                $rate->save();

                $request->session()->flash('alert-success', 'Taxa cadastrada com sucesso.');
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


        $rate = Rates::findOrFail($id);
        if ($data['rate_name'] != $rate->rate_name):

            $rateName = Rates::select('*')
            ->where('rates.rate_name', '=', $data['rate_name'])
            ->whereNull('rates.deleted_at')
            ->count();

            if ($rateName > 0) :
                $request->session()->flash('alert-danger', 'Já existe uma taxa com este nome ('. $data['rate_name'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {
            
            $rate = Rates::findOrFail($id);
            $rate->rate_name  = $data['rate_name'];
            $rate->value      = $data['value'];
            $rate->mult       = $data['mult'];
            $rate->date_limit = $data['date_limit'];
            $rate->status     = $data['status'];
            $rate->update();

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Taxa actualizada com sucesso.');
        return redirect()->back();
    }


    public function destroy(Request $request, $id){


        try {
            
            $up = Rates::findOrFail($id);
            $up->delete();
            
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }
        
        $request->session()->flash('alert-success', 'Taxa excluída com sucesso.');
        return redirect()->back();
    }




    public function getPorters(){

        $rates = Rates::select('*')
        ->whereNull('porters.deleted_at')
        ->orderBy('porters.id', 'DESC')
        ->get();


        return $rates;
    }
}
