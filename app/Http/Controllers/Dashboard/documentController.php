<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Documents;
use Illuminate\Http\Request;

class documentController extends Controller
{
    
    private $totalpage = 10;

    public function index()
    {

        $user = auth()->user();

        $documents = Documents::select('*')
        ->whereNull('documents.deleted_at')
        ->get();

        return view('dashboard.', compact('documents', 'user'));
    }


    public function store(Request $request){

        $data = $request->all();

        $documentName = Documents::select('*')
        ->where('documents.document', '=', $data['document'])
        ->whereNull('documents.deleted_at')
        ->count();

        if($documentName){
            $request->session()->flash('alert-danger', 'Já existe um documento com este nome ('. $data['document'] .') no sistema.');
            return redirect()->back();
        } else {

            try {

                if ($request->hasFile('file') && $request->file('file')->isValid()){

                    $requestFile = $request->file;
                    $extension = $requestFile->extension();
    
                    $imageName = md5($requestFile->getClientOriginalName() . strtotime("now")) . "." . $extension;
                    $requestFile->move(public_path('files/document/'), $imageName);
                    $data['file'] = asset('files/document'). '/' . $imageName;
    
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
        if ($data['document'] != $document->document):

            $documentName = Documents::select('*')
            ->where('documents.document', '=', $data['document'])
            ->whereNull('documents.deleted_at')
            ->count();

            if ($documentName > 0) :
                $request->session()->flash('alert-danger', 'Já existe uma documento com este nome ('. $data['document'] .') no sistema.');
                return redirect()->back();
            endif;
            
        endif;

        try {
            
            if ($request->hasFile('file') && $request->file('file')->isValid()){

                $requestFile = $request->file;
                $extension = $requestFile->extension();

                $imageName = md5($requestFile->getClientOriginalName() . strtotime("now")) . "." . $extension;
                $requestFile->move(public_path('files/document/'), $imageName);
                $data['file'] = asset('files/document'). '/' . $imageName;

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


    public function destroy(Request $request, $id){


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




    public function getDocuments(){

        $documents = Documents::select('*')
        ->whereNull('documents.deleted_at')
        ->orderBy('documents.title', 'DESC')
        ->get();


        return $documents;
    }
}
