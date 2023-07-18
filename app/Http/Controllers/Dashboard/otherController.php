<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartaments;
use App\Models\Buildings;
use App\Models\Documents;
use App\Models\Services;
use App\Models\Typologies;
use App\Models\UserPorters;
use App\Models\UserResidents;
use Illuminate\Http\Request;

class otherController extends Controller
{

    private $totalpage = 10;

    public function index(Request $request)
    {

        $user = auth()->user();


        $building = Buildings::select('*')
            ->whereNull('buildings.deleted_at')
            ->count();

        $apartament = Apartaments::select('*')
            ->whereNull('apartaments.deleted_at')
            ->count();

        $resident = UserResidents::select('*')
            ->whereNull('user_residents.deleted_at')
            ->count();

        $porter = UserPorters::select('*')
            ->whereNull('user_porters.deleted_at')
            ->count();

        try {

            return view('dashboard.others.home', compact('user', 'building', 'apartament', 'resident', 'porter'));
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'Ocorreu um erro, por favor, tente novamente.');
            return redirect()->back();
        }
    }



    public function statistics(Request $request)
    {

        $user = auth()->user();


        try {

            $building = Buildings::select('*')
                ->whereNull('buildings.deleted_at')
                ->count();


            $porter = UserPorters::select(
                'user_porters.id',
                'user_porters.status',
                'user_porters.created_at',
                'users.name',
                'users.phone',
                'users.email',
                'users.photo',
                'users.address'
            )
                ->join('users', 'users.id', '=', 'user_porters.user_id')
                ->whereNull('user_porters.deleted_at')
                ->count();


            $typology = Typologies::select('*')
                ->whereNull('typologies.deleted_at')
                ->count();

            $service = Services::select('*')
                ->whereNull('services.deleted_at')
                ->count();

            // Data of the apartament 
            $apartamentGet = [
                'total' => Apartaments::select('*')
                    ->whereNull('apartaments.deleted_at')
                    ->count(),

                'free' => Apartaments::select('*')
                    ->whereNull('apartaments.deleted_at')
                    ->where('apartaments.occupation', '0')
                    ->count(),


                'weekfree' => Apartaments::select('*')
                    // ->whereBetween('time',array($timfrom,$timto))
                    ->whereRaw('updated_at >= UNIX_TIMESTAMP(DATE_SUB(NOW(),INTERVAL 1 WEEK))')
                    ->where('apartaments.occupation', '0')
                    ->whereNull('apartaments.deleted_at')
                    ->count(),

                'on'  => Apartaments::select('*')
                    ->whereNull('apartaments.deleted_at')
                    ->where('apartaments.occupation', '1')
                    ->count(),


                'weekon' => Apartaments::select('*')
                    // ->whereBetween('time',array($timfrom,$timto))
                    ->whereRaw('updated_at >= UNIX_TIMESTAMP(DATE_SUB(NOW(),INTERVAL 1 WEEK))')
                    ->where('apartaments.occupation', '1')
                    ->whereNull('apartaments.deleted_at')
                    ->count(),
            ];

            // Data of the apartament 
            $apartament = [
                'total' => ($apartamentGet['total'] == 0) ? 1 : $apartamentGet['total'],
                'free' => ($apartamentGet['free'] == 0) ? 1 : $apartamentGet['free'],
                'weekfree' => ($apartamentGet['weekfree'] == 0) ? 1 : $apartamentGet['weekfree'],
                'on'  => ($apartamentGet['on'] == 0) ? 1 : $apartamentGet['on'],
                'weekon' => ($apartamentGet['weekon'] == 0) ? 1 : $apartamentGet['weekon'],
            ];

            // dd($apartament);


            // Data of the residents
            $residentGet = [
                'total' => UserResidents::select('*')
                    ->whereNull('user_residents.deleted_at')
                    ->count(),

                'weektotal' => UserResidents::select('*')
                    ->whereRaw('created_at >= UNIX_TIMESTAMP(DATE_SUB(NOW(),INTERVAL 1 WEEK))')
                    ->whereNull('user_residents.deleted_at')
                    ->count(),

                'inative' => UserResidents::select('*')
                    ->where('user_residents.status', '1')
                    ->whereNull('user_residents.deleted_at')
                    ->count(),

                'weekinative' => UserResidents::select('*')
                    ->whereRaw('updated_at >= UNIX_TIMESTAMP(DATE_SUB(NOW(),INTERVAL 1 WEEK))')
                    ->where('user_residents.status', '1')
                    ->whereNull('user_residents.deleted_at')
                    ->count(),
            ];

            
            // Data of the apartament 
            $resident = [
                'total' => ($residentGet['total'] == 0) ? 0.5 : $residentGet['total'],
                'weektotal' => ($residentGet['weektotal'] == 0) ? 1 : $residentGet['weektotal'],
                'inative' => ($residentGet['inative'] == 0) ? 1 : $residentGet['inative'],
                'weekinative'  => ($residentGet['weekinative'] == 0) ? 1 : $residentGet['weekinative'],
            ];

            // dd($resident);

            return view('dashboard.others.statics', compact('user', 'building', 'apartament', 'resident', 'service', 'porter', 'typology'));
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'Ocorreu um erro, por favor, tente novamente.');
            return redirect()->back();
        }
    }




    public function indexFinances(Request $request)
    {

        $user = auth()->user();

        // Data of the month 
        $month = [
            'total' => UserResidents::select('*')
                ->where('user_residents.status', '0')
                ->whereNull('user_residents.deleted_at')
                ->count(),
        ];

        // Data of the year 
        $year = [
            'total' => UserResidents::select('*')
                ->where('user_residents.status', '0')
                ->whereNull('user_residents.deleted_at')
                ->count()
        ];


        try {

            return view('dashboard.others.finances', compact('user', 'month', 'year'));
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'Ocorreu um erro, por favor, tente novamente.');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {

        $data = $request->all();

        $documentName = Documents::select('*')
            ->where('documents.document', '=', $data['document'])
            ->whereNull('documents.deleted_at')
            ->count();

        if ($documentName) {
            $request->session()->flash('alert-danger', 'Já existe um documento com este nome (' . $data['document'] . ') no sistema.');
            return redirect()->back();
        } else {

            try {

                if ($request->hasFile('file') && $request->file('file')->isValid()) {

                    $requestFile = $request->file;
                    $extension = $requestFile->extension();

                    $imageName = md5($requestFile->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $requestFile->move(public_path('files/document/'), $imageName);
                    $data['file'] = asset('files/document') . '/' . $imageName;

                    $document = new Documents();
                    $document->title       = $data['title'];
                    $document->file        = $data['file'];
                    $document->type        = $data['type'];
                    $document->resident_id = $data['resident_id'] ?? NULL;
                    $document->about       = $data['about'];
                    $document->status    = '0';
                    $document->save();
                } else {

                    $document = new Documents();
                    $document->title       = $data['title'];
                    $document->type        = $data['type'];
                    $document->resident_id = $data['resident_id'] ?? NULL;
                    $document->about       = $data['about'];
                    $document->status    = '0';
                    $document->save();
                }

                $request->session()->flash('alert-success', 'Documento cadastrado com sucesso.');
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


        $document = Documents::findOrFail($id);
        if ($data['document'] != $document->document) :

            $documentName = Documents::select('*')
                ->where('documents.document', '=', $data['document'])
                ->whereNull('documents.deleted_at')
                ->count();

            if ($documentName > 0) :
                $request->session()->flash('alert-danger', 'Já existe uma documento com este nome (' . $data['document'] . ') no sistema.');
                return redirect()->back();
            endif;

        endif;

        try {

            if ($request->hasFile('file') && $request->file('file')->isValid()) {

                $requestFile = $request->file;
                $extension = $requestFile->extension();

                $imageName = md5($requestFile->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestFile->move(public_path('files/document/'), $imageName);
                $data['file'] = asset('files/document') . '/' . $imageName;

                $document = Documents::findOrFail($id);
                $document->title       = $data['title'];
                $document->file        = $data['file'];
                $document->type        = $data['type'];
                $document->resident_id = $data['resident_id'] ?? NULL;
                $document->about       = $data['about'];
                $document->status    = '0';
                $document->update();
            } else {

                $document = Documents::findOrFail($id);
                $document->title       = $data['title'];
                $document->type        = $data['type'];
                $document->resident_id = $data['resident_id'] ?? NULL;
                $document->about       = $data['about'];
                $document->status    = '0';
                $document->update();
            }
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Documento actualizado com sucesso.');
        return redirect()->back();
    }


    public function destroy(Request $request, $id)
    {


        try {

            $up = Documents::findOrFail($id);
            $up->delete();
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('alert-danger', 'An error has occurred, try again later.');
            return redirect()->back();
        }

        $request->session()->flash('alert-success', 'Documento excluído com sucesso.');
        return redirect()->back();
    }




    public function getDocuments()
    {

        $documents = Documents::select('*')
            ->whereNull('documents.deleted_at')
            ->orderBy('documents.title', 'DESC')
            ->get();


        return $documents;
    }
}
