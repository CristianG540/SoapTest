var BASEURL = $('#main').data('url');

var modMain = new Vue({
    el : '#main',
    mounted : function(){

    },
    data : {

    },
    methods : {
        procesar : function(){
            $("#modal").modal('show');
            var scope = this;
            $.get(BASEURL + '/cacheBoletin/BoletinProcesar', {
                idPer  : this.periodo,
                idSede : this.sede
            })
            .done(function(data){
                if(data.status == 201){
                    $("#modal").modal('hide');
                    toastr.success('Información procesada con éxito.');
                }else{
                    scope.failReq(data);
                }
            })
            .fail(this.failReq);
            toastr.info('Se esta procesando la informacion, espere por favor.');

        },
        failReq: function (e) {
            toastr.error('Error al procesar la peticion, revise la consola para mas informacion: '+e.error);
            console.log('Error processing your request: ', e);
        }
    },
    computed : {
        validData : function() {
            return !( this.periodo && this.sede );
        },
    }
});
