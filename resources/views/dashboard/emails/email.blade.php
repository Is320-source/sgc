
@if ($data['type'] == 'store')

    <h2>Seja bem-vindo a ITECH Group, {{ $data['name'] }}!</h2>
    <p>Ficamos muito felizes em tê-lo como nosso afiliado(a).</p>
    <p>O seu número de referência é <strong>{{ $data['reference'] }}</strong>.</p>
    <br>

    <h5>Atenciosamente,<br>
    Team ITech Group</h5>

@elseif ($data['type'] == 'payment')

    <h1>Olá, {{ $data['name'] }}!</h1>
    <p>O cliente {{ $data['client'] }} efectuou uma compra e o seu valor de comissão é <strong>{{ $data['commission'] }}</strong>.<br> 
    Dependendo do seu banco, a sua comissão refletirá em sua conta bancária em um período máximo de até 48H. 
    Caso não aconteça, por favor, contacte a <strong>ITECH</strong>.</p>

    <br>

    <h5>Atenciosamente,<br>
    Team ITech Group</h5>

@endif