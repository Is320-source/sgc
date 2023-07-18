
<!DOCTYPE html>
<html>
<head>	
    <title>Lista de Apartamentos</title>
	<meta name="viewport" content="width=device-widty, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
    


<div style="text-align: center;">

<h2>Lista de Apartamentos</h2>
<p>Lista de apartamentos do condomínio</p><br><br>
</div>


<div  style="text-align: center;">
<table class="table" style="border: 1px solid;"  align="center">
        <thead>
            <tr>
                <th style="text-align: center; border: 1px solid;"><strong>Nº</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Apartamento</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Prédio</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Tipologia</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Situação</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Estado</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach($apartaments as $apartament)
                <tr>
                    <td style="text-align: center; border: 1px solid;">{{ $loop->index + 1 }}</td>
                    <td style="text-align: center; border: 1px solid;">{{ $apartament->apartament }}</td>
                    <td style="text-align: center; border: 1px solid;">{{ $apartament->building }}</td>
                    <td style="text-align: center; border: 1px solid;">{{ $apartament->typology }}</td>
                    <td style="text-align: center; border: 1px solid;">{{ $apartament->occupation == '0' ? 'Livre' : 'Ocupado' }}</td>
    
                    @if ($apartament->status == '0')
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
