
<!DOCTYPE html>
<html>
<head>	
    <title>Lista de Porteiros</title>
	<meta name="viewport" content="width=device-widty, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
    


<div style="text-align: center;">

<h2>Lista de Porteiros</h2>
<p>Lista de porteiros do condomínio</p><br><br>
</div>


<div  style="text-align: center;">
<table class="table" style="border: 1px solid;"  align="center">
        <thead>
            <tr>
                <th style="text-align: center; border: 1px solid;"><strong>Nº</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Nome</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Telefone</strong></th>
                <th style="text-align: center; border: 1px solid;"><strong>Estado</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach($porters as $porter)
                <tr>
                    <td style="text-align: center; border: 1px solid;">{{ $loop->index + 1 }}</td>
                    <td style="text-align: center; border: 1px solid;">{{ $porter->name }}</td>
                    <td style="text-align: center; border: 1px solid;">(+244){{ $porter->phone }}</td>
                    
                    @if ($porter->status == '0')
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
