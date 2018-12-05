<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use PhpParser\Node\Stmt\Global_;
use Ramsey\Uuid\Uuid;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $configuracao = Configuracao::first();
        $estados = arrayToSelect(Estados::select('id', 'uf')->get()->toArray(), 'id', 'uf');

        $folderConfig = public_path() . '/storage/imagens/configuracao';

        if(!\Storage::directories($folderConfig))
        {
            \Storage::makeDirectory('public/imagens/configuracao');
        }

        $imageBanner = \File::glob(public_path().'/storage/imagens/configuracao/banner_*', GLOB_MARK);
        $imageBanner = ($imageBanner != null) ? 'storage/imagens/configuracao/'.basename($imageBanner[0]) : null;
        $imageLogo   = \File::glob(public_path().'/storage/imagens/configuracao/logo_*', GLOB_MARK);
        $imageLogo   = ($imageLogo != null) ? 'storage/imagens/configuracao/'.basename($imageLogo[0]) : null;

        return view('pages.configuracao.index', compact('estados', 'configuracao', 'imageLogo', 'imageBanner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $result = \DB::transaction(function () use ($request){
            try{

                $path = base_path('.env');

                $id    = $request->input('id');
                $request['cnpj']      = removeMask(trim($request->input('cnpj')));
                $request['numero']    = removeMask(trim($request->input('numero')));
                $request['cep']       = removeMask(trim($request->input('cep')));
                $request['telefone']  = removeMask(trim($request->input('telefone')));
                $request['celular']   = removeMask(trim($request->input('celular')));
                $request['skin']     = ($request['skin'] == null) ? "skin-blue" : $request['skin'];

                $configuracao = Configuracao::find($id);

                if(!$configuracao)
                {
                    $configuracao = new Configuracao();
                }

                $configuracao->fill($request->all());

                if($configuracao->id == null){
                    $configuracao->id = Uuid::uuid4();
                }

                if (file_exists($path)) {
                    file_put_contents($path, str_replace(
                        'MAIL_HOST='.env('MAIL_HOST'), 'MAIL_HOST='.$request['email_host'], file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        'MAIL_PORT='.env('MAIL_PORT'), 'MAIL_PORT='.$request['port_host'], file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        'MAIL_USERNAME='.env('MAIL_USERNAME'), 'MAIL_USERNAME='.$request['email_user'], file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        'MAIL_PASSWORD='.env('MAIL_PASSWORD'), 'MAIL_PASSWORD='.$request['password_host'], file_get_contents($path)
                    ));
                }
                $validate = validator($request->all(), $configuracao->rules(), $configuracao->msgRules);

                if($validate->fails())
                {
                    return response()->json(['success' => false, 'msg' => arrayToValidator($validate->errors())]);
                }

                $save = $configuracao->save();

                if($save) {


                    $save_image_banner = $this->storeImage($request, 'image_banner', 'banner');

                    $save_image = $this->storeImage($request, 'image', 'logo');

                    return response()->json(['success' => true, 'msg' => 'Configuração salva com sucesso.']);
                }else{
                    return response()->json(['success' => false, 'msg' => 'Erro ao salvar Configuração.']);
                }
            }
            catch(\Exception $exc)
            {
                return response()->json(['success' => false, 'msg' => 'Erro ao salvar Configuração. '. $exc->getMessage() ]);
            }
        });

        return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeImage($request, $file, $nameOriginal)
    {
        if($request->hasFile($file))
        {
            $folderConfig = public_path() . '/storage/imagens/configuracao';

            $files = $request->file($file);

            if(!\Storage::directories($folderConfig))
            {
                \Storage::makeDirectory('public/imagens/configuracao');
            }

            saveImages($nameOriginal, $files, $folderConfig);

        }
    }
}
