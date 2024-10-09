<div class="cookie-card" id="cookieCard">
    <span class="title">🍪 Aviso de Cookies</span>
    <p class="description">Usamos cookies para garantir que oferecemos a melhor experiência em nosso site. <a href="#">Leia as políticas de cookies</a>.</p>
    <div class="actions">
        <button class="pref">Gerenciar suas preferências</button>
        <button class="accept" onclick="acceptCookies()">Aceitar</button>
    </div>
</div>

<script>
    function checkCookieConsent() {
        const cookieConsent = localStorage.getItem('cookieConsent');
        if (cookieConsent) {
            document.getElementById('cookieCard').style.display = 'none';
        }
    }

    function acceptCookies() {
        localStorage.setItem('cookieConsent', 'accepted');
        document.getElementById('cookieCard').style.display = 'none';
    }

    window.onload = checkCookieConsent;
</script>
