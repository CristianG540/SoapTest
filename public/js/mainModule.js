var BASEURL = $('#main').data('url');

var modMain = new Vue({
    el : '#main',
    mounted : function(){

    },
    data : {
        sessionId : '',
        docEntry  : ''
    },
    methods : {
        login : function(){
            var scope = this;
            $.get(BASEURL + '/login')
            .done(function(d){
                if(d.status == 201){
                    scope.sessionId = d.data.SessionID;
                    toastr.success('Información procesada con éxito, su Id de sesión es : '+scope.sessionId);
                }else{
                    scope.failReq(d);
                }
            })
            .fail(this.failReq);
        },
        ordenar : function(){
            var scope = this;
            $.get(BASEURL + '/orders', {
                sessionId : this.sessionId
            })
            .done(function(d){
                if(d.status == 201){
                    scope.docEntry = d.data.DocumentParams.DocEntry;
                    toastr.success('Información procesada con éxito.');
                }else{
                    scope.failReq(d);
                }
            })
            .fail(this.failReq);
        },
        logout : function(){
            var scope = this;
            $.get(BASEURL + '/logout/'+scope.sessionId)
            .done(function(d){
                if(d.status == 201){
                    scope.sessionId = '';
                    scope.docEntry = '';
                    toastr.success('Se deslogueo con exito.');
                }else{
                    scope.failReq(d);
                }
            })
            .fail(this.failReq);
        },
        failReq: function (e) {
            toastr.error('Error al procesar la peticion, revise la consola para mas informacion: '+e.error);
            console.log('Error processing your request: ', e);
        }
    },
    computed : {
        validData : function() {
            return ( this.sessionId != '' );
        },
    }
});
