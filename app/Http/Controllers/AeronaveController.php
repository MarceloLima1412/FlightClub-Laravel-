<?php

namespace App\Http\Controllers;

use App\User;
use App\Aeronave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreAeronaveRequest;
use App\Http\Requests\UpdateAeronaveRequest;
use Illuminate\Support\Facades\Auth;

class AeronaveController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ((Auth::user()->password_inicial==1)) {
            return redirect(route('password.change'));
         } 
            if(count($request->except('page'))){

                $aeronaves = Aeronave::query();
          
                if ($request->filled('matricula')){
                    $aeronaves->where("matricula",'like','%'.$request->matricula.'%');
                }
    

                if ($request->filled('marca')){
                    $aeronaves->where("marca",'like','%'.$request->marca.'%');
                }

                if ($request->filled('modelo')){
                    $aeronaves->where("modelo",'like','%'.$request->modelo.'%');
                }

                if ($request->filled('num_lugares')){
                    $aeronaves->where('num_lugares','=',$request->num_lugares);
                }

                if ($request->filled('conta_horas')){
                    $aeronaves->where('conta_horas','=',$request->conta_horas);
                }

                if ($request->filled('preco_hora')){
                    $aeronaves->where('preco_hora','=',$request->preco_hora);
                }     
                
        $aeronaves = $aeronaves->paginate(14)->appends($request->except('page'));

        }else{
            $aeronaves = Aeronave::paginate(14);
        }
        
        return view('aeronaves.index', compact('aeronaves'));
        }

    public function create()
    {
        $this->authorize('create', Aeronave::class);

        $aeronave = new Aeronave;
        return view('aeronaves.add', compact('aeronave'));
    }

    
    public function store(StoreAeronaveRequest $request)
    {
        $this->authorize('create', Aeronave::class);

        $aeronave = new Aeronave();
        $aeronave->fill($request->all());
        $aeronave->save();

        for($i=1; $i<=10; $i++){
            $aeronave->valores()->create(["unidade_conta_horas"=> $i, "minutos"=> $request->tempos[$i], "preco"=> $request->precos[$i]]);
        }
     
    

        return redirect()
            ->route('aeronaves.index')
            ->with('success', 'Aeronave adicionada com sucesso!');
    }
    
    public function edit(Aeronave $aeronave)
    {
        $this->authorize('update', $aeronave);

        return view('aeronaves.edit', compact('aeronave'));
        
    }

    
    public function update(UpdateAeronaveRequest $request, Aeronave $aeronave)
    {
        $this->authorize('update', $aeronave);
        $aeronave->fill($request->except('matricula'));
        $aeronave->save();

        $aeronave->valores()->delete();
        
        for($i=1; $i<=10; $i++){
            $aeronave->valores()->create(["unidade_conta_horas"=> $i, "minutos"=> $request->tempos[$i], "preco"=> $request->precos[$i]]);
        }
     
        return redirect()
            ->route('aeronaves.index')
            ->with('success', 'Aeronave atualizada com sucesso!');
    }

    
    public function destroy(Aeronave $aeronave)
    {
        $this->authorize('delete', $aeronave);
        if(count($aeronave->movimentos)){
            $aeronave->delete(); 
        }else {
            $aeronave->forceDelete();
        }
        return redirect()
            ->route('aeronaves.index')
            ->with('success', 'Aeronave removida com sucesso!');
    }

    public function pilotosAut(Aeronave $aeronave)
    {
    
        $pilotos = DB::table('aeronaves_pilotos')->where('matricula', '=', $aeronave -> matricula)->pluck('piloto_id');
        $pilotosAut = User::whereIn("id", $pilotos) -> paginate(10);
        return view('aeronaves.pilotosAut', compact('pilotosAut','aeronave'));
    }

    public function pilotosNAut(Aeronave $aeronave)
    {   
        $pilotos = DB::table('aeronaves_pilotos')->where('matricula', '=', $aeronave -> matricula)->pluck('piloto_id');
        $pilotosNAut = User::wherenotIn("id", $pilotos) -> where("tipo_socio", "=", "P")-> paginate(10);
        return view('aeronaves.pilotosNAut', compact('pilotosNAut','aeronave'));
    }

    public function addPiloto(Aeronave $aeronave, User $piloto){
        DB::table('aeronaves_pilotos')->insert(['matricula'=>$aeronave->matricula, 'piloto_id'=>$piloto->id]);
        return redirect()
            ->route('aeronaves.pilotosAut', $aeronave)
            ->with('success', 'Piloto adicionado com sucesso!');
    }

    public function removePiloto(Aeronave $aeronave, User $piloto){
        DB::table('aeronaves_pilotos')->where('matricula', '=', $aeronave -> matricula)->where('piloto_id', '=', $piloto -> id)->delete();
        return redirect()
            ->route('aeronaves.pilotosNAut', $aeronave)
            ->with('success', 'Piloto adicionado com sucesso!');
    }

    
}
