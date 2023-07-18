
<!DOCTYPE html>
<html>
<head>	
    <title>Lista de Prédios</title>
	<meta name="viewport" content="width=device-widty, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
    


<div style="text-align: center;">

<h2>Lista de Prédios</h2>
<p>Lista de prédios do condomínio</p><br><br>
</div>


<div  style="text-align: center;">
<table class="table" style="border: 1px solid;"  align="center">
        <thead>

        <tr>
            <th style="text-align: center; border: 1px solid;"><strong>Nº</strong></th>
            <th style="text-align: center; border: 1px solid;"><strong>Prédio</strong></th>
            <th style="text-align: center; border: 1px solid;"><strong>Total de Apartamentos</strong></th>
            <th style="text-align: center; border: 1px solid;"><strong>Estado</strong></th>
        </tr>
        </thead>
        <tbody>
            @foreach($buildings as $building)
                <tr>
                    <td style="text-align: center; border: 1px solid;">{{ $loop->index + 1 }}</td>
                    <td style="text-align: center; border: 1px solid;">{{ $building->building }}</td>
                    <td style="text-align: center; border: 1px solid;">{{ $building->total_apartament == NULL ? '0' :  $building->total_apartament }}</td>
    
                    @if ($building->status == '0')
                        <td style="text-align: center; border: 1px solid;">Activo</td>
                    @else
                        <td style="text-align: center; border: 1px solid;">Inativo</td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
