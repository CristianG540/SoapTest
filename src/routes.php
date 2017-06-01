<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    xdebug_break();
    $login = new nusoap_client("http://b1ws.igbcolombia.com/B1WS/WebReferences/LoginService.wsdl", true);
    $error  = $login->getError();
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

    /*$client = new SoapClient('http://b1ws.igbcolombia.com/B1WS/WebReferences/LoginService.wsdl');*/
    //$client->__setLocation('http://b1ws.igbcolombia.com/B1WS/Service.asmx');
    /*$result = $client->__soapCall("LoginService/Login", array(
        'DatabaseServer'  => '192.168.10.102', //string
        'DatabaseName'    => 'MERCHANDISING', //string
        'DatabaseType'    => 'dst_MSSQL2012', //DatabaseType
        'CompanyUsername' => 'manager', //string
        'CompanyPassword' => 'Pa$$w0rd', //string
        'Language'        => 'ln_Spanish', //Language
        'LicenseServer'   => '192.168.10.102:30000' //string
    )); */
    /*$res = $client->Login(array(
        'DatabaseServer'  => '192.168.10.102', //string
        'DatabaseName'    => 'MERCHANDISING', //string
        'DatabaseType'    => 'dst_MSSQL2012', //DatabaseType
        'CompanyUsername' => 'manager', //string
        'CompanyPassword' => 'Pa$$w0rd', //string
        'Language'        => 'ln_Spanish', //Language
        'LicenseServer'   => '192.168.10.102:30000' //string
    ));*/

    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', ['data' => $soapRes]);
});
