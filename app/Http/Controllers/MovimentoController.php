<?php

namespace App\Http\Controllers;

use App\User;
use App\Aeronave;
use App\Aerodromo;
use App\Movimento;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMovimentoRequest;
use App\Http\Requests\UpdateMovimentoRequest;
use App\Aeronaves_piloto;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
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

        $aeronaves = Aeronave::orderBy('matricula')->get();
        $users=User::where('tipo_socio','P')->orderBy('nome_informal')->get();
        $instrutors=User::where('instrutor', 1)->orderBy('nome_informal')->get();

        if(count($request->except('page'))){
            $movimentos = Movimento::query();
            $movimentos2 = Movimento::query();
      
            if ($request->filled('id')){
                $movimentos->where('id','=',$request->id);
            }

            if ($request->filled('aeronave')){
                $movimentos->where('aeronave','=',$request->aeronave);
            }

            if ($request->filled('aerodromo_partida')){
                $movimentos->where('aerodromo_partida','=',$request->aerodromo_partida);
            }

            if ($request->filled('data_inf')){
                $movimentos->where('data','>=',$request->data_inf);
            }

            if ($request->filled('data_sup')){
                $movimentos->where('data','<=',$request->data_sup);
            }

            if ($request->filled('natureza')){
                $movimentos->where('natureza','=',$request->natureza);
            }

            if ($request->filled('confirmado')){
                $movimentos->where('confirmado','=',$request->confirmado);
            }

            if ($request->filled('piloto')){
                //$pilotos_id=User::where("nome_informal",'like','%'.$request->piloto.'%')->where('tipo_socio','=','P')->pluck("id");
                //$movimentos->whereIn('piloto_id',$pilotos_id);
                $movimentos->where('piloto_id',$request->piloto);
            }

            if ($request->filled('instrutor')){
                //$instrutor_id=User::where("nome_informal",'like','%'.$request->instrutor.'%')->where('tipo_socio','=','P')->pluck("id");
                //$movimentos->whereIn('instrutor_id',$instrutor_id);
                $movimentos->where('instrutor_id',$request->instrutor);
            }

            if ($request->filled('meus_movimentos')){
                $movimentos->where(function ($p){
                    $p->where('instrutor_id','=',auth()->user()->id)->orWhere('piloto_id','=',auth()->user()->id);
                });
              
                //$movimentos2=movimentos->where('instrutor_id','=',auth()->user()->id);
                //$movimentos=Movimento::where('piloto_id','=',auth()->user()->id)->unionall($movimentos2);

            }

            $movimentos = $movimentos->paginate(14)->appends($request->except('page'));
        }else{
            $movimentos = Movimento::paginate(14);
        }
        
        return view('movimentos.index', compact('movimentos','aeronaves','users','instrutors'));
    }


    public function create()
    {
        $this->authorize('create', Movimento::class);
        
        $movimento = new Movimento;
        $aeronaves=Aeronave::orderBy('matricula')->get();
        $aerodromos=Aerodromo::orderBy('nome')->get();
        $users=User::where('tipo_socio','P')->orderBy('nome_informal')->get();
        $instrutors=User::where('instrutor', 1)->orderBy('nome_informal')->get();

        return view('movimentos.add', compact('movimento','aeronaves','aerodromos','users','instrutors'));
    }

    
    public function store(StoreMovimentoRequest $request)
    {
        $this->authorize('create', Movimento::class);

        if(auth()->user()->direcao ||$request->piloto_id == auth()->user()->id ||$request->instrutor_id == auth()->user()->id){

            $movimento = new Movimento();
            $movimento->fill($request->except('hora_aterragem','hora_descolagem'));
            $users = Aeronaves_piloto::all();

            $this->precoAutomatico($movimento);

            $movimento->hora_descolagem=date('Y-m-d H:i',strtotime($request->data.' '.$request->hora_descolagem));
            $movimento->hora_aterragem=date('Y-m-d H:i',strtotime($request->data.' '.$request->hora_aterragem));

            $aeronave=Aeronave::find($movimento->aeronave);
            $num_pilotos=$aeronave->pilotos->where('id','=',$request->piloto_id)->count();
    
        /*foreach($users as $user){

            //dd($request->piloto_id);
            if($user->piloto_id==$request->piloto_id)
            {
                //dd($users[$aux+1]);
                if($users[$aux+1]->matricula==$request->aeronave){
                    $aux=1;
                    break;
                }
                else{
                    $i=$i+1;
                }
            }
            else{
                $aux=$aux+1;
            }
            //$aux=$aux+$i;
        }*/
        //dd($users[$aux+1]->matricula);
        //dd($request->aeronave);
        /*if($users[$aux+1]->matricula==$request->aeronave)
        {
            $aux=1;
        }
        else{
            $aux=2;
        }*/
    
            if($num_pilotos){
                //para o piloto:
                $piloto=User::where('id',$movimento->piloto_id)->first();
                //dd($movimento->piloto_id);
                $movimento->tipo_licenca_piloto=$piloto->tipo_licenca;
                $movimento->num_licenca_piloto=$piloto->num_licenca;
                $movimento->validade_licenca_piloto=$piloto->validade_licenca;
                $movimento->classe_certificado_piloto=$piloto->classe_certificado;
                $movimento->num_certificado_piloto=$piloto->num_certificado;
                $movimento->validade_certificado_piloto=$piloto->validade_certificado;

                //para o instrutor:
                $instrutor=User::where('id',$movimento->instrutor_id)->first();
                
                if(empty($movimento->confirmado)){
                    $movimento->confirmado = 0;
                }

                //dd($request->natureza);
                if($request->natureza == 'I'){
                    $request->validate([
                        'tipo_instrucao' => 'required|in:D,S',
                        'instrutor_id' => 'required|exists:users,id' 
                    ]);
                }

                if(!empty($movimento->instrutor_id)){
                    if($request->piloto_id!=$request->instrutor_id){
                        $num_pilotos=$aeronave->pilotos->where('id','=',$request->instrutor_id)->count();
                        if($num_pilotos){
                            $movimento->tipo_licenca_instrutor=$instrutor->tipo_licenca;
                            $movimento->num_licenca_instrutor=$instrutor->num_licenca;
                            $movimento->validade_licenca_instrutor=$instrutor->validade_licenca;
                            $movimento->classe_certificado_instrutor=$instrutor->classe_certificado;
                            $movimento->num_certificado_instrutor=$instrutor->num_certificado;
                            $movimento->validade_certificado_instrutor=$instrutor->validade_certificado;
                        }
                        else{
                            return redirect()
                                ->back()
                                ->withErrors(['instrutor_id'=>'Esse instrutor não tem permissões para conduzir essa aeronave!'])
                                ->withInput($request->all());
                        }

                    }
                    else{
                        return redirect()
                            ->back()
                            ->withErrors(['instrutor_id'=>'O instrutor não pode ser igual ao piloto!'])
                            ->withInput($request->all());
                    }
                }
            }
            else{
                return redirect()
                    ->back()
                    ->withErrors(['piloto_id'=>'Esse piloto não tem permissões para conduzir essa aeronave!'])
                    ->withInput($request->all());
            }
        }
        else
        {
            return redirect()
            ->back()
            ->withErrors(['instrutor_id'=>'O registo tem de pertencer ao piloto/instrutor indicado!','piloto_id'=>'O registo tem de pertencer ao piloto/instrutor indicado!'])
            ->withInput($request->all());
        }

        $movimento->save();

        return redirect()
        ->route('movimentos.index')
        ->with('success', 'Movimento adicionado com sucesso!');

    }
    
    public function edit(Movimento $movimento)
    {
        $this->authorize('update', $movimento);

        $aeronaves=Aeronave::orderBy('matricula')->get();
        $aerodromos=Aerodromo::orderBy('nome')->get();
        $users=User::where('tipo_socio','P')->orderBy('nome_informal')->get();
        $instrutors=User::where('instrutor', 1)->orderBy('nome_informal')->get();

        return view('movimentos.edit', compact('movimento','aeronaves','aerodromos','users','instrutors'));
        
    }

    
    public function update(UpdateMovimentoRequest $request, Movimento $movimento)
    {
        $this->authorize('update', $movimento);

        if(auth()->user()->direcao ||$request->piloto_id == auth()->user()->id ||$request->instrutor_id == auth()->user()->id){
            
            $movimento->fill($request->except('hora_aterragem','hora_descolagem'));
                    
            $this->precoAutomatico($movimento);

            $movimento->hora_descolagem=date('Y-m-d H:i',strtotime($request->data.' '.$request->hora_descolagem));
            $movimento->hora_aterragem=date('Y-m-d H:i',strtotime($request->data.' '.$request->hora_aterragem));

            $aeronave=Aeronave::find($movimento->aeronave);
            $num_pilotos=$aeronave->pilotos->where('id','=',$request->piloto_id)->count();
    

            if($num_pilotos){
                //para o piloto:
                $piloto=User::where('id',$movimento->piloto_id)->first();
                //dd($movimento->piloto_id);
                $movimento->tipo_licenca_piloto=$piloto->tipo_licenca;
                $movimento->num_licenca_piloto=$piloto->num_licenca;
                $movimento->validade_licenca_piloto=$piloto->validade_licenca;
                $movimento->classe_certificado_piloto=$piloto->classe_certificado;
                $movimento->num_certificado_piloto=$piloto->num_certificado;
                $movimento->validade_certificado_piloto=$piloto->validade_certificado;

                //para o instrutor:
                $instrutor=User::where('id',$movimento->instrutor_id)->first();
                
                if(empty($movimento->confirmado)){
                    $movimento->confirmado = 0;
                }

                //dd($request->natureza);
                if($request->natureza == 'I'){
                    $request->validate([
                        'tipo_instrucao' => 'required|in:D,S',
                        'instrutor_id' => 'required|exists:users,id' 
                    ]);
                }

                if(!empty($movimento->instrutor_id)){
                    if($request->piloto_id!=$request->instrutor_id){
                        $num_pilotos=$aeronave->pilotos->where('id','=',$request->instrutor_id)->count();
                        if($num_pilotos){
                            $movimento->tipo_licenca_instrutor=$instrutor->tipo_licenca;
                            $movimento->num_licenca_instrutor=$instrutor->num_licenca;
                            $movimento->validade_licenca_instrutor=$instrutor->validade_licenca;
                            $movimento->classe_certificado_instrutor=$instrutor->classe_certificado;
                            $movimento->num_certificado_instrutor=$instrutor->num_certificado;
                            $movimento->validade_certificado_instrutor=$instrutor->validade_certificado;
                        }
                        else{
                            return redirect()
                                ->back()
                                ->withErrors(['instrutor_id'=>'Esse instrutor não tem permissões para conduzir essa aeronave!'])
                                ->withInput($request->all());
                        }

                    }
                    else{
                        return redirect()
                            ->back()
                            ->withErrors(['instrutor_id'=>'O instrutor não pode ser igual ao piloto!'])
                            ->withInput($request->all());
                    }
                }
            }
            else{
                return redirect()
                    ->back()
                    ->withErrors(['piloto_id'=>'Esse piloto não tem permissões para conduzir essa aeronave!'])
                    ->withInput($request->all());
            }
        }
        else
        {
            return redirect()
            ->back()
            ->withErrors(['instrutor_id'=>'O registo tem de pertencer ao piloto/instrutor indicado!','piloto_id'=>'O registo tem de pertencer ao piloto/instrutor indicado!'])
            ->withInput($request->all());
        }

        $movimento->save();

        return redirect()
        ->route('movimentos.index')
        ->with('success', 'Movimento adicionado com sucesso!');

    }

    public function confirmar(Movimento $movimento)
    {
        $this->authorize('confirmar', $movimento);

        $movimento->confirmado=1;
        $movimento->save();

        return redirect()
            ->route('movimentos.index')
            ->with('success', 'Movimento confirmado com sucesso!');

    }

    public function precoAutomatico(Movimento $movimento){
 
        $conta_dif=0;
        $horas=0;
        $unidades=0;

        $conta_dif =  $movimento->conta_horas_fim - $movimento->conta_horas_inicio;
        $horas = (int)($conta_dif/10); //1hora
        $unidades = $conta_dif%10; //vai buscar o resto para ter os minutos
        $tempo_voo = $preco_voo = 0;
        

        $aeronave=Aeronave::where('matricula',$movimento->aeronave)->first();
        $valores=$aeronave->valores;
        $tempo_voo = $horas*60;
        $preco_voo = $horas+50*$valores[9]->preco;
        
        if($unidades != 0){
            $tempo_voo += $valores[$unidades-1]->minutos;
            $preco_voo += $valores[$unidades-1]->preco;
        }

        $movimento->tempo_voo=$tempo_voo;
        $movimento->preco_voo=$preco_voo;
    }

    public function pendentes(Request $request)
    {
        $this->authorize('viewAll', Movimento::class);

        $aeronaves = Aeronave::orderBy('matricula')->get();

        if(count($request->except('page'))){
            $movimentos = Movimento::where('confirmado','0');
    
            if ($request->filled('id')){
                $movimentos->where('id','=',$request->id);
            }

            if ($request->filled('aeronave')){
                $movimentos->where('aeronave','=',$request->aeronave);
            }

            if ($request->filled('data_inf')){
                $movimentos->where('data','>=',$request->data_inf);
            }

            if ($request->filled('data_sup')){
                $movimentos->where('data','<=',$request->data_sup);
            }

            if ($request->filled('natureza')){
                $movimentos->where('natureza','=',$request->natureza);
            }

            if ($request->filled('confirmado')){
                $movimentos->where('confirmado','=',$request->confirmado);
            }

            if ($request->filled('piloto')){
                $pilotos_id=User::where("nome_informal",'like','%'.$request->piloto.'%')->where('tipo_socio','=','P')->pluck("id");
                $movimentos->whereIn('piloto_id',$pilotos_id);
            }

            if ($request->filled('instrutor')){
                $instrutor_id=User::where("nome_informal",'like','%'.$request->instrutor.'%')->where('tipo_socio','=','P')->pluck("id");
                $movimentos->whereIn('instrutor_id',$instrutor_id);
            }

            $movimentos = $movimentos->paginate(14)->appends($request->except('page'));
        }else{
            $movimentos = Movimento::where('confirmado','0')->paginate(14);
        }

        return view('movimentos.pendentes', compact('movimentos','aeronaves'));
    }
      
    public function destroy(Movimento $movimento)
    {
        $this->authorize('delete', $movimento);

        $movimento->delete();
        return redirect()
            ->route('movimentos.index')
            ->with('success', 'Movimento removido com sucesso!');
    }

}
