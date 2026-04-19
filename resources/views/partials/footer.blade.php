<style>
    .energy-footer {
        background-color: #1a1a1a;
        color: #fff;
        padding: 60px 0 30px;
        font-family: sans-serif;
        border-top: 3px solid #ff0000;
    }

    .footer-brand {
        font-size: 1.8rem;
        font-weight: 800;
        text-decoration: none;
        color: #fff;
        display: block;
        margin-bottom: 15px;
    }

    .footer-brand span {
        color: #ff0000;
    }

    .footer-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 25px;
        color: #ff0000;
    }

    .footer-links {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: #bbb;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.3s;
    }

    .footer-links a:hover {
        color: #fff;
    }

    /* Redes Oficiales Estilo Compacto */
    .footer-social-link {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #bbb;
        text-decoration: none;
        margin-bottom: 15px;
        transition: 0.3s;
    }

    .footer-social-link:hover {
        color: #fff;
        transform: translateX(5px);
    }

    .footer-social-link i {
        font-size: 1.4rem;
    }

    .footer-bottom {
        margin-top: 50px;
        padding-top: 25px;
        border-top: 1px solid #333;
        font-size: 0.75rem;
        color: #666;
    }

    .payment-icon {
        filter: grayscale(1) brightness(2);
        opacity: 0.5;
        height: 20px;
    }
</style>

<footer class="energy-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="/" class="footer-brand">ENERGY<span>.</span></a>
                <p class="text-muted small">
                    Potenciando tu rendimiento con las mejores marcas nacionales e importadas en todo el NEA.
                </p>
            </div>

            <div class="col-lg-2 col-md-4">
                <h6 class="footer-title">Menú</h6>
                <ul class="footer-links">
                    <li><a href="/">Principal</a></li>
                    <li><a href="/catalogo">Catálogo</a></li>
                    <li><a href="/quienes-somos">Quiénes Somos</a></li>
                    <li><a href="/contacto">Contacto</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h6 class="footer-title">Información</h6>
                <ul class="footer-links">
                    <li><a href="/comercializacion">Comercialización</a></li>
                    <li><a href="/terminos">Términos y Usos</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h6 class="footer-title">Redes Oficiales</h6>

                <a href="https://www.instagram.com/energy.nutricion" target="_blank" class="footer-social-link">
                    <i class="bi bi-instagram text-danger"></i>
                    <span class="fw-bold">@energy.nutricion</span>
                </a>

                <a href="https://wa.me/543794576548" target="_blank" class="footer-social-link">
                    <i class="bi bi-whatsapp text-success"></i>
                    <span class="fw-bold">+54 379 4576548</span>
                </a>
            </div>
        </div>

        <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-3">
            <p class="mb-0">&copy; 2026 ENERGY Sports Nutrition. Todos los derechos reservados.</p>
            <div class="d-flex gap-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png"
                    class="payment-icon" alt="Visa">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png"
                    class="payment-icon" alt="Mastercard">
            </div>
        </div>
    </div>
</footer>