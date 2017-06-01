<?php
// Routes

$app->get('/', function ($request, $response) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', ['basePath' => $request->getUri()->getBaseUrl() ]);
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

        return $response->withJson([
            'status' => 201,
            'data' => $soapRes
        ]);
    }else{
    	return $response->withJson([
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

        return $response->withJson([
            'status' => 201,
            'data' => $soapRes
        ]);
    }else{
        return $response->withJson([
            'status' => 500
        ]);
    }

});

$app->get('/orders', function ($request, $response, $args) use ($app) {
    $sessionId = $request->getParam('sessionId');
    $order = new nusoap_client("http://b1ws.igbcolombia.com/B1WS/WebReferences/OrdersService.wsdl", true);
    $paramsH = [
        'SessionID'   => (isset($sessionId) && $sessionId ) ? $sessionId : '',
        'ServiceName' => 'OrdersService'
    ];
    $order->setHeaders(['MsgHeader' => $paramsH]);
    $error  = $order->getError();
    if(!$error){
        $soapRes = $order->call('Add', ''
                . '<Add>'
                    . '<Document>'
	                    . '<Confirmed>N</Confirmed>'
	                    . '<CardCode>c10026162</CardCode>'
	                    . '<Comments>orden de prueba por webservice</Comments>'
	                    . '<DocDueDate>2017-06-22</DocDueDate>'
	                    . '<NumAtCard>pedidoweb 2</NumAtCard>'
	                    . '<DocumentLines>'
                    		. '<DocumentLine>'
                    			. '<LineNum>0</LineNum>'
                    			. '<ItemCode>RP169Q51</ItemCode>'
                    			. '<Quantity>2</Quantity>'
                    		. '</DocumentLine>'
                		. '</DocumentLines>'
                	. '</Document>'
            	. '</Add>'
                );

        return $response->withJson([
            'status' => 201,
            'data' => $soapRes
        ]);
    }else{
        return $response->withJson([
            'status' => 500
        ]);
    }
});

