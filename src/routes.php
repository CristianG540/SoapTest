<?php
// Routes

$app->get('/', function ($request, $response) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', ['data' => '' ]);
});

$app->get('/login', function ($request, $response) {

    $login = new nusoap_client("http://b1ws.igbcolombia.com/B1WS/WebReferences/LoginService.wsdl", true);
    $error  = $login->getError();
    if(!$error){
        $params = array(
            'DatabaseServer'  => '192.168.10.102', //string
            'DatabaseName'    => 'MERCHANDISING', //string
            'DatabaseType'    => 'dst_MSSQL2012', //DatabaseType
            'CompanyUsername' => 'manager', //string
            'CompanyPassword' => 'Pa$$w0rd', //string
            'Language'        => 'ln_Spanish', //Language
            'LicenseServer'   => '192.168.10.102:30000' //string
        );
        $soapRes = $login->call('Login', $params);

        return json_encode([
            'status' => 201,
            'data' => $soapRes
        ]);
    }else{
        return json_encode([
            'status' => 500
        ]);
    }
});

$app->get('/logout/{sessionid}', function ($request, $response, $args) {

    $logout = new nusoap_client("http://b1ws.igbcolombia.com/B1WS/WebReferences/LoginService.wsdl", true);
    $params = [
        'SessionID' => (isset($args['sessionid']) && $args['sessionid'] ) ? $args['sessionid'] : ''
    ];
    $logout->setHeaders(['MsgHeader' => $params]);
    $error  = $logout->getError();
    if(!$error){

        $soapRes = $logout->call('Logout', '<Logout xmlns="LoginService" />');

        return json_encode([
            'status' => 201,
            'data' => $soapRes
        ]);
    }else{
        return json_encode([
            'status' => 500
        ]);
    }

});

