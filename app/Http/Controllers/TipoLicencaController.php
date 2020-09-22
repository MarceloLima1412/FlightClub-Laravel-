<?php

namespace App\Http\Controllers;

use App\TiposLicenca;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTipoLicencaRequest;

class TipoLicencaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos_licenca = TiposLicenca::paginate(14);

        return view('tiposlicencas.index', compact('tipos_licenca'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

        $tipos_licenca = new TiposLicenca;
        return view('tiposlicencas.add', compact('tipos_licenca'));
    }

    public function store(StoreTipoLicencaRequest $request)
    {
        $tipos_licenca = new TiposLicenca();
        $tipos_licenca->fill($request->all());
        $tipos_licenca->save();

        return redirect()
            ->route('tiposlicencas.index')
            ->with('success', 'Licencas adicionada com sucesso!');

    }

    
}
