{{-- @php
$endereco = "SEU_ENDERECO_DINAMICO";
$api_key = "SUA_CHAVE";

$endereco_codificado = urlencode($endereco);
$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$endereco_codificado}&key={$api_key}";

$response = file_get_contents($url);
$data = json_decode($response);

// Verifique se a solicitação foi bem-sucedida
if ($data->status === "OK") {
    $latitude = $data->results[0]->geometry->location->lat;
    $longitude = $data->results[0]->geometry->location->lng;
} else {
    // Lida com erro na solicitação da API
    $latitude = $longitude = null;
}
@endphp
<section id="mapsSection" class="section-map no-padding">
    <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d497856.48259637057!2d<?php echo $longitude; ?>!3d<?php echo $latitude; ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x716037ca23ca5b3%3A0x1b9fc7912c226698!2sSalvador%20-%20BA!5e0!3m2!1spt-BR!2sbr!4v1686405124368!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section> --}}