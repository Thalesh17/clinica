<?php
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\Schema;

    function versao(){
        return '1.0';
    }
    
    function arrayToSelect(array $values, $key, $value) {
        if(count($values) > 0)
        {
            $data = array();
        
            $data[0] = 'Selecione';
            foreach ($values as $row) {
                $data[$row[$key]] = $row[$value];
            }

            return $data;
        }else{
            return [''];
        }
        
    }

    function onlyNumbers($val){
        $num = preg_replace("/[^0-9]+$/", "", $val);
        return ($val == $num) ? true : false;
    }

    function onlyLetters($val){
        $num = preg_replace("/[^A-Z-a-z]+$/", "", $val);
        return ($val == $num) ? true : false;
    }

    function objectToSelect(array $values, $key, $value) {
        $data = array();

        $data[0] = 'Selecione';
        foreach ($values as $row) {
            if ($row->$value != '') {
                $data[$row->$key] = $row->$value;
            }
        }

        return $data;
    }
    
    function arrayToValidator($arr) {
        
        $erros = '<ul>';
            
        foreach ($arr->toArray() as $erro)
        {
            foreach ($erro as $msg)
            {
                $erros .= '<li>' .$msg. '</li>';
            }
        }
        
        $erros .= '</ul>';
        
        return $erros;
    }
    
    function queryToArray($arr, $key)
    {
        $array = [];
        foreach ($arr as $row)
        {
            $array[] = $row->$key;
        }
        
        return $array;
    }
    
    function paginate($page, $request, $perPage, $dados)
    {
        //Remove da url &page=numero da pagina para não ficar repetindo na url        
        $paramsUrl = str_replace('&page='.$page, "", $request->fullUrl());
        //Total de registro por pagina
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($dados, $offset, $perPage, true), count($dados), $perPage, $page, ['path' => $paramsUrl] );   
    } 
    
    function exceptThumb($imagens)
    {
        $arr = [];
        foreach ($imagens as $imagem)
        {
            if(!stripos($imagem, '-thumb'))
            {
                $arr[] = $imagem;
            }
        }
        return $arr;
    }
    

    function saveImage($prefix, $file, $path) {
        $validextensions = ["jpeg", "jpg", "png"];
        $extension = $file->getClientOriginalExtension();

        if(in_array( strtolower($extension), $validextensions)){
            $nameHash = hash("md5", uniqid(time()));

            $picture = $prefix.'_' .$nameHash. '.'.$extension;
            dd($picture);
            $destinationPath = $path;

            $file->move($destinationPath, $picture);
        }else{
            throw new Exception('Erro extenções permitidas: jpg, jpge e png.');
        }
    }
    function deleteImage($request)
    {
        $srcThumb = $request->input('src');
        $srcThumb = str_replace(url('/'), '', $srcThumb);
        $src = str_replace('-thumb', '', $srcThumb);
        
        if(!empty($src)){
            $imagens = File::glob(public_path($src), GLOB_MARK);
            File::delete($imagens);   
            
            $imagensThumb = File::glob(public_path($srcThumb), GLOB_MARK);
            File::delete($imagensThumb);
            return response()->json(['success' => true, 'msg' => 'Imagem deletada da pasta com sucesso.']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Não foi possivel deletar a imagem.']);
        }
    }
    
    function getImagens($path, $id)
    {
        $imagens = File::glob($path .$id. '_*', GLOB_MARK);
        $imagens = exceptThumb($imagens);
        $imagens = str_replace('\\', '/', str_replace(public_path(''), url(''), $imagens)) ;
        return $imagens;
    }
    
    function getImagensThumb($path, $id)
    {
        $imagens = File::glob($path .$id. '_*-thumb*' , GLOB_MARK);
        return $imagens = str_replace(public_path(), url('/'), $imagens);
    }

    function getImagensForPdf($path, $id)
    {
        $imagens = File::glob($path .$id. '_*', GLOB_MARK);
        $imagens = exceptThumb($imagens);
    //        $imagens = str_replace('\\', '/', str_replace(public_path(''), url(''), $imagens)) ;
        return $imagens;
    }

    function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function($key) {
                    return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
    
    function xmlToArray($xml, $options = array()) {
        $defaults = array(
            'namespaceSeparator' => ':', //you may want this to be something other than a colon
            'attributePrefix' => '@', //to distinguish between attributes and nodes with the same name
            'alwaysArray' => array(), //array of xml tag names which should always become arrays
            'autoArray' => true, //only create arrays for tags which appear more than once
            'textContent' => '$', //key used for the text content of elements
            'autoText' => true, //skip textContent key if node has no attributes or child nodes
            'keySearch' => false, //optional search and replace on tag and attribute names
            'keyReplace' => false       //replace values for above search values (as passed to str_replace())
        );
        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces[''] = null; //add base (empty) namespace
        //get attributes from all namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch'])
                    $attributeName = str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix']
                        . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                        . $attributeName;
                $attributesArray[$attributeKey] = (string) $attribute;
            }
        }

        //get child nodes from all namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = xmlToArray($childXml, $options);
                list($childTagName, $childProperties) = each($childArray);

                //replace characters in tag name
                if ($options['keySearch'])
                    $childTagName = str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                //add namespace prefix, if any
                if ($prefix)
                    $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;

                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count
                    $tagsArray[$childTagName] = in_array($childTagName, $options['alwaysArray']) || !$options['autoArray'] ? array($childProperties) : $childProperties;
                } elseif (
                        is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName]) === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }

        //get text content of node
        $textContentArray = array();
        $plainText = trim((string) $xml);
        if ($plainText !== '')
            $textContentArray[$options['textContent']] = $plainText;

        //stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '') ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

        //return node as array
        return array(
            $xml->getName() => $propertiesArray
        );
    }
// função de formatação de datas para views, $value a data, $hour se a formatação vai exibir hora tambem
    function dateToView($value, $hour = null) {

        if(!isset($value)){
            return '';
        }

        if($hour){

            return date('d/m/Y H:i', strtotime($value));
        }

        return date('d/m/Y', strtotime($value));
    }

    function saveImageBase64($prefix, $file, $path)
    {
        $nameHash = hash("md5", uniqid(time()));

        $picture = $prefix.'_' .$nameHash. '.jpg';
        $pictureThumb = $prefix.'_' .$nameHash. '-thumb.jpg';
        $destinationPath = $path;

        Image::make($file)->save($destinationPath .'/'. $picture);

        Image::make($file)->resize(300, null, function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath .'/'. $pictureThumb);
    }

function dateToSave($data,$hour = null){
    if(!isset($data)){
        return null;
    }
    $formatDate = str_replace("/", ".", $data);
    if($hour){
        return date('Y-m-d H:i', strtotime($formatDate));
    }

    return date('Y-m-d', strtotime($formatDate));
}

function getSigla(){
    $config = \App\Models\Configuracao::select('sigla')->first();

    if($config){
        return $config->sigla;
    }
    return 'DEF';
}

function getSkin(){
    $config = \App\Models\Configuracao::select('skin')->first();

    if($config){
        return $config->skin;
    }
    return 'skin-blue';
}

function getSkinPattern(){
    $config = \App\Models\Configuracao::select('skin')->first();

    if($config){
        return $config->skin."-pattern";
    }
    return 'skin-blue-pattern';
}

function removeMask($texto) {
    return preg_replace('/[\-\|\(\)\/\.\:\_ ]/', '', $texto);
}

function getLogo()
{
    $folderConfig = public_path() . '/storage/imagens/configuracao/';

    $file = \File::glob($folderConfig.'logo_*', GLOB_MARK);

    $result = str_replace('\\', '/', str_replace(public_path(''), url(''), $file));

    return $result;
}

function validateData($data){
    $date = dateToSave($data);
    $now = date('Y-m-d');
    if($date > $now){
        return true;
    }
    return false;
}

function validateErros($validate)
{
    $messages_erros = array();
    $messages       = $validate->messages();

    foreach($messages as $key => $message)
    {
        $messages_erros["$key"] = $message;
    }

    return $messages_erros;
}


function getDateToMonth($date)
{

    if(!isset($date)){
        return '';
    }

    $mes = date('m', strtotime($date));
    $dia = date('d', strtotime($date));
    $ano = date('Y', strtotime($date));

    return $dia . ' ' . getMonthDate($mes) . ' '. $ano;
}

function getMonthDate($mes){

    switch ($mes){

        case 1: $mes = "Janeiro"; break;
        case 2: $mes = "Fevereiro"; break;
        case 3: $mes = "Março"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Maio"; break;
        case 6: $mes = "Junho"; break;
        case 7: $mes = "Julho"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Setembro"; break;
        case 10: $mes = "Outubro"; break;
        case 11: $mes = "Novembro"; break;
        case 12: $mes = "Dezembro"; break;

    }

    return $mes;
}

function cpfIsValid($cpf) {
    $valido = true;
    if(!ctype_digit($cpf)){
        return false;
    }
    for ($x = 0; $x < 10; $x ++) {
        if ($cpf == str_repeat($x, 11)) {
            $valido = false;
        }
    }
    if ($valido) {
        if (strlen($cpf) != 11) {
            $valid = false;
        } else {
            for ($t = 9; $t < 11; $t ++) {
                $d = 0;
                for ($c = 0; $c < $t; $c ++) {
                    $d += $cpf {$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $valido = false;
                    break;
                }
            }
        }
    }
    return $valido;
}

function validateCpf($cpf){
    $lenght = strlen($cpf);
    if ($lenght < 11 || $lenght != 11) {
        return 'CPF inválido.';
    }

    if ($lenght == 11) {
        $valid = cpfIsValid($cpf);
        if(!$valid){
            return 'O CPF informado é inválido.';
        }
    }
    return "";
}

//validatePermissions

function getPermissionsPage($permission = null){

    $result = DB::table('permissions')
        ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
        ->join('roles', 'roles.id', '=', 'permission_role.role_id')
        ->join('role_user', 'role_user.role_id', '=', 'roles.id')
        ->select('permissions.name')
        ->distinct()
        ->where('role_user.user_id', \Auth::user()->id);


    if($permission){
        $result = $result->where('permissions.name', 'ilike', $permission . '%');
    }

    return array_column($result->get()->toArray(), 'name');

}

function validatePermission($permissions, $arrayPermissions){

//    if(validateRoles(['ADMINISTRADOR', 'GERENTE']) || \Auth::user()->id == 1){
//        return true;
//    }

    if(isset($arrayPermissions) && isset($permissions)){
        for ($i = 0; $i < count($arrayPermissions); $i++) {
            if (in_array($arrayPermissions[$i], $permissions)) {
                return true;
            }
        }
    }

    return false;
}

function autorizePermissionController($permissions,$arrayPermissions){

    if(validatePermission($permissions, $arrayPermissions)){
        return true;
    }

    abort(401, 'Ação não autorizada.');
}

function validateMasterAccess($supervisor = null){
    return validateRoles(['ADMINISTRADOR', 'GERENTE']);
}

function validateLogin($role)
{
    $result = DB::table('roles')
        ->leftJoin('permission_role', 'permission_role.role_id', '=', 'roles.id')
        ->leftJoin('role_user', 'role_user.role_id', '=', 'roles.id')
        ->select('roles.name')
        ->distinct()
        ->where('role_user.user_id', \Auth::user()->id)
        ->get()
        ->toArray();

    if(isset($result) && isset($role)){
        $roles = array_column($result, 'name');
        for ($i = 0; $i < count($roles); $i++) {
            if (in_array($roles[$i], $role)) {
                return true;
            }
        }
    }
    return false;
}

function validateRoles($role){

    if(\Auth::user()->id == 1){
        return true;
    }

    $result = DB::table('role_user')
        ->leftJoin('permission_role', 'permission_role.role_id', '=', 'role_user.role_id')
        ->leftJoin('roles', 'roles.id', '=', 'permission_role.role_id')
        ->select('roles.name')
        ->distinct()
        ->where('role_user.user_id', \Auth::user()->id)
        ->get()
        ->toArray();

    if(isset($result) && isset($role)){
        $roles = array_column($result, 'name');
        for ($i = 0; $i < count($roles); $i++) {
            if (in_array($roles[$i], $role)) {
                return true;
            }
        }
    }
    return false;
}

function listaHorarios($horaInicio, $horaFinal) {
    $horas = [];
    $secsInicio = strtotime($horaInicio) ;
    $secsFinal = strtotime($horaFinal);

    $formato = function ($horario) {
        return date('G:ia', $horario);
    };

    $horarios = range($secsInicio, $secsFinal, 3600);
    $arrayHours = array_map($formato, $horarios);

    foreach ($arrayHours as $t){
        if(strpos($t, 'am')){
            $t = str_replace("am","", $t);
        }else{
            $t = str_replace("pm","", $t);
        }
        array_push($horas, $t);
    }

    return $horas;
}

function urlEspecificBack($url){
    $editar = false;
    $result = explode('/', url()->previous());
    if(isset($result[3]) && $result[3] == $url || isset($result[4]) && $result[4] == $url){
        return true;
    }
    return false;
}

function rangeCustomYear($start, $end){
    $result  = array( 0 => 'Selecione');
    for ($start; $start <= $end; $end--){
        $result[$end] = $end;
    }

    return $result;
}


