<?php

namespace App\Http\Controllers;

use App\User;
use App\Movimento;
use App\TiposLicencas;
use App\ClassesCertificados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Storage;

class UserController extends Controller
{   

    //Retirado o "middleware" pois já está implementado

    public function index(Request $request)
    {
        //$socios = User::orderBy('num_socio')->get();
        if ((Auth::user()->password_inicial==1)) {
            return redirect(route('password.change'));
        }

            if(count($request->except('page'))){
        
                $socios = User::query();
          
                if ($request->filled('num_socio')){
                    $socios->where('num_socio','=',$request->num_socio);
                }

                if ($request->filled('nome_informal')){
                    $socios->where("nome_informal",'like','%'.$request->nome_informal.'%');
                }

                if ($request->filled('email')){
                    $socios->where("email",'like','%'.$request->email.'%');
                }

                if ($request->filled('tipo')){
                    $socios->where('tipo_socio','=',$request->tipo);
                }

                if ($request->filled('direcao')){
                    $socios->where('direcao','=',$request->direcao);
                }

                if ($request->filled('quotas_pagas')){
                    $socios->where('quota_paga','=',$request->quotas_pagas);
                }

                if ($request->filled('ativo')){
                    $socios->where('ativo','=',$request->ativo);
                }
            
                $socios = $socios->paginate(14)->appends($request->except('page'));
            }
        else{
            if (auth()->user()->direcao){
                $socios = User::paginate(14);
            }
            else{
            $socios = User::where("ativo","1")->paginate(14);
            }

        }

    
    return view('socios.index', compact('socios'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $socio = new User;
        $tipos_licencas=TiposLicencas::orderBy('nome')->get();
        $classes_certificados=ClassesCertificados::orderBy('nome')->get();

        return view('socios.add', compact('socio','tipos_licencas','classes_certificados'));
    }

    
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $socio = new User();
        $socio->fill($request->all());
        $socio->password=Hash::make($socio->data_nascimento);
        $socio->password_inicial=1;
        $socio->save();
 
         if($request->instrutor == 1 && $request->aluno == 1){
            return redirect()
                ->back()
                ->withErrors(['Esse sócio não pode ser instrutor e aluno ao mesmo tempo!'])
                ->withInput($request->all());
        }else{
            if ($request->file('file_foto')){
                $name = $socio->id."_".time().'.'.$request->file_foto->getClientOriginalExtension();
                $socio->foto_url=$name;
                Storage::putFileAs('public/fotos', $request->file_foto, $name);
            }

            //Pedir apenas se for piloto
            if ($request->file('file_licenca')){
                $name = "licenca"."_".$socio->id.'.'.$request->file_licenca->getClientOriginalExtension();
                Storage::putFileAs('docs_piloto', $request->file_licenca, $name);
                Storage::disk("local")->putFileAs("docs_piloto", $request->file('file_licenca'),$name);
            }

            if ($request->file('file_certificado')){
                $name = "certificado"."_".$socio->id.'.'.$request->file_certificado->getClientOriginalExtension();
                Storage::putFileAs('docs_piloto', $request->file_certificado, $name);
                Storage::disk("local")->putFileAs("docs_piloto", $request->file('file_certificado'),$name);
            }
        }

        $socio->save();
        
        $socio->sendEmailVerificationNotification(); 

        return redirect()
            ->route('socios.index')
            ->with('success', 'Socio adicionado com sucesso!');
    }
    
    public function edit(User $socio)
    {
        $this->authorize('update', $socio);

        $tipos_licencas=TiposLicencas::orderBy('nome')->get();
        $classes_certificados=ClassesCertificados::orderBy('nome')->get();

        return view('socios.edit', compact('socio','tipos_licencas','classes_certificados'));
        
    }

    
    public function update(UpdateUserRequest $request, User $socio)
    {
        $this->authorize('update', $socio);

        //dd($socio->instrutor);
        if($request->instrutor == 1 && $request->aluno == 1){
            return redirect()
                ->back()
                ->withErrors(['Esse sócio não pode ser instrutor e aluno ao mesmo tempo!'])
                ->withInput($request->all());
        }else{
            if(auth()->user()->direcao){
                $socio->fill($request->except('password'));

            }else{
                if(auth()->user()->tipo_socio=='P'){
                 $socio->fill($request->only('nome_informal', 'name', 'data_nascimento', 'email','foto_url','nif', 'telefone' ,'endereco','num_licenca', 'tipo_licenca', 'num_certificado', 'classe_certificado', 'validade_licenca', 'validade_certificado')); 
                }else{
                    $socio->fill($request->only('nome_informal', 'name', 'data_nascimento', 'email','foto_url','nif', 'telefone' ,'endereco'));
                }

            }                                        


            if ($request->file('file_foto')){
                $name=$socio->num_socio."_".time().".".$request->file_foto->getClientOriginalExtension();
                if(Storage::disk("public")->exists("fotos/".$socio->foto_url)){
                    Storage::disk("public")->delete("fotos/".$socio->foto_url);
                }
                $socio->foto_url=$name;
                Storage::putFileAs('public/fotos', $request->file_foto, $name);
            }

            if ($request->file('file_licenca')){
                $name="licenca"."_".$socio->id.'.'.$request->file_licenca->getClientOriginalExtension();
                if(Storage::disk("local")->exists("docs_piloto/".$name)){
                    Storage::disk("local")->delete("docs_piloto/".$name);
                }
                Storage::putFileAs('docs_piloto', $request->file_licenca, $name);
                
            }

            if ($request->file('file_certificado')){
                $name="certificado"."_".$socio->id.'.'.$request->file_certificado->getClientOriginalExtension();
                if(Storage::disk("local")->exists("docs_piloto/".$name)){
                    Storage::disk("local")->delete("docs_piloto/".$name);
                }
                Storage::putFileAs('docs_piloto', $request->file_certificado, $name); 

            }
        
        //dd($socio->isDirty('nome_informal'));
/*
        if(filemtime('file_certificado') > $result_set['filemtime']) {
            $socio->certificado_confirmado = 0;
        }
        */
/*
        if($file_certificado->isDirty()){
            $socio->certificado_confirmado = 0;
        }
        */
        }
        $socio->save();

        return redirect()
            ->route('socios.index')
            ->with('success', 'Socio atualizado com sucesso!');
    }


    public function destroy(User $socio)
    {
        $this->authorize('delete', $socio);

        if(count($socio->movimentosP) || count($socio->movimentosI)){
            $socio->delete(); 
        }else {
            $socio->forceDelete();
        }

        return redirect()
            ->route('socios.index')
            ->with('success', 'Socio removido com sucesso!');
    }


    public function alterarSenha()
    {
        return view('auth.passwords.password-reset');
            
    }

    public function guardarSenha(Request $request)
    {
        
        $socio = $request->validate ([
            'old_password' => 'required|SameOld_password',
            'password' => 'required|min:8|NotSameOld_password|same:password_confirmation',
            'password_confirmation' => 'required_with:password'], 
            );

        $LoginSocio = User::findorfail(Auth::id());


        $LoginSocio->password = Hash::make($socio['password']);

        $LoginSocio->password_inicial=0;

        $LoginSocio->save();
         
        return redirect()
            ->route('socios.index');
    }

    public function send_reactivate_email(User $socio){
        

        $socio->sendEmailVerificationNotification();

        return redirect()
            ->route('socios.index')
            ->with('success', 'Email de notificação enviado com sucesso!');
    }

    public function ativar(User $socio)
    {
        if(request()->filled('ativo')){
            $socio->ativo=request()->ativo;
            
        }
        elseif($socio->ativo == 0){
            $socio->ativo = 1;
        }else{
            $socio->ativo = 0;
        }

        $socio->update();

        return redirect()
            ->route("socios.index")
            ->with('success', 'Sócio ativado/desativado com sucesso.');
    }


    public function quota(User $socio)
    {
        if(request()->filled('quota_paga')){
            $socio->quota_paga=request()->quota_paga;
            
        }elseif($socio->quota_paga == 0){
            $socio->quota_paga = 1;
        }else{
            $socio->quota_paga = 0;
        }

        $socio->update();

        return redirect()
            ->route("socios.index")
            ->with('success', 'Quota alterada com sucesso.');
    }


    public function reset_quotas()
    {
        $this->authorize("reset",User::class);

        $socios = User::all();
        foreach ($socios as $socio){
            $socio->quota_paga = 0;
            $socio->update();            
        }
        return redirect()
            ->route("socios.index")
            ->with('success', 'Quotas atualizadas com sucesso.');
    }


    public function desativa_sem_quotas()
    {
        $this->authorize("ativar",User::class);

        $socios = User::all();

        foreach ($socios as $socio){
                if($socio->quota_paga == 0){
                    $socio->ativo = 0;
                }else{
                    $socio->ativo = 1;
                }

            $socio->update();
        }    

        return redirect()
            ->route("socios.index")
            ->with('success', 'Sócios Sem Quotas Desativados com sucesso!');
    }

    
    public function mostraCertificado(User $piloto)
    {
        //Só o próprio ou um elemento da Direção é que vê
        //$this->authorize("podeVerDocumentos",$piloto);
                //dd($piloto);
        
       
        if (Storage::disk('local')->exists('docs_piloto/certificado_'.$piloto->id.'.pdf')){

            return Storage::disk('local')->response('docs_piloto/certificado_'.$piloto->id.'.pdf');
        }
        
        return redirect()
            ->back();
    }


    public function mostraLicenca(User $piloto)
    {
        //Só o próprio ou um elemento da Direção é que vê
        //$this->authorize("podeVerDocumentos",User::class);
        if (Storage::disk('local')->exists('docs_piloto/licenca_'.$piloto->id.'.pdf')){

            return Storage::disk('local')->response('docs_piloto/licenca_'.$piloto->id.'.pdf');
        }
        
        return redirect()
            ->back();    

    }

}
