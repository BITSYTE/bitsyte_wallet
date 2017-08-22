<div class="visible-print text-center">
    {!! QrCode::size(300)->generate($address) !!}
    <p>Dirección: {{ $address }}</p>
</div>