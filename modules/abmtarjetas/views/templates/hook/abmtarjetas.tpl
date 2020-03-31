<script>
    $(function() {        

        $('#planes').hide();
        
        $("#tarjetas").change(function(){
          $('#planes').hide();
          $("#msjCuotas h4").html();
          var idTarjeta=$(this).val();        
            if($(this).val() > 0){              
              abmTarjetas.getPlanes(idTarjeta);
              abmTarjetas.precioCuota();
              $('#planes').show();
            }else{
              $('#planes').hide();
              $("#our_price_display").html(abmTarjetas.preciobase);
            }            
        });

        $("#planes").change(function(){
            abmTarjetas.CuotaPlan();
        });
    });

    var abmTarjetas = {
        name:'abmtarjetas',
        modebug:1,
        baseURL:location.href.substr(0, location.href.lastIndexOf("/") + 1),
        url:'http://'+location.hostname,
        preciobase:$("#our_price_display").text(),
        precioCuota:function(){
          //var precio = $("#our_price_display").text();
          if(this.modebug)
            console.log(this.preciobase);
          var precioCuota = parseFloat(this.preciobase.replace(/[^0-9\.]+/g,"")) / parseInt($("#planes option:selected").attr("rel"));
          if(this.modebug)
            console.log(precioCuota);
          var coeficiente = precioCuota * parseFloat($("#planes option:selected").val());
          if(this.modebug)
            console.log(coeficiente + precioCuota);
          var NuevoPrecio = coeficiente + precioCuota;
          var cuotas = parseInt($("#planes option:selected").attr("rel"));
          if($("#planes option:selected").val() > 0)
          $("#msjCuotas h4").html('Paga '+ cuotas +' Cuotas de $'+NuevoPrecio.toFixed(2));
        },//End precioCuota
        CuotaPlan:function(){  
          var precioBase = parseFloat(this.preciobase.replace(/[^0-9\.]+/g,""));  
          var porcentaje = parseInt($("#planes option:selected").val());  
          var cuotas = parseInt($("#planes option:selected").attr("rel"));  
          var precioCuota = precioBase * (1 + (porcentaje/100)) / cuotas;
          if(this.modebug)
            console.log(precioCuota);          
          //var NuevoPrecio = precioCuota * cuotas;          
          if($("#planes option:selected").val() != 0)
            $("#msjCuotas h4").html('<b>'+cuotas +'</b> cuotas de <b>$'+ precioCuota.toFixed(2)+'</b>');
          else
            $("#msjCuotas h4").html('');
        },//End CuotaPlan
        getPlanes:function(idTarjeta){
          //alert(this.url);
          $.ajax({
            type: "GET", 
            url: this.url + "/producto-mto/" + "modules/"+this.name+"/"+this.name+"-ajax.php",
            data: "method=planes&idTarjeta="+idTarjeta,                              
            success: function(planes) {                  
                $('#planes').html(planes);//completo el combo planes     
                  if(this.modebug)
                  console.log(planes);   
               }
          });
        },//End getPlanes  
    };
    //alert(planes);
</script>
<div id="abmtarjetas">
    <div class="payments-card">
        <label class="col-sm-12">Calculador de Cuotas</label>
        <div class="col-sm-4">
            <select id="tarjetas" name="tarjetas"> 
              <option value="0">Tarjeta</option>
            {foreach from=$tarjetas item=tarjeta key=key}
                <option value="{$tarjeta.codigotarjeta}">{$tarjeta.descripcion}</option>
            {/foreach}
            </select>
        </div>
        <div class="col-sm-4">
            <select id="planes" name="planes" style="    margin-left: 8px;"></select>
        </div>
        <div class="clearfix"></div>        
        <div id="msjCuotas" class="col-sm-12">
            <h4 style="font-size:14px;"></h4>
        </div>
    </div>
</div>