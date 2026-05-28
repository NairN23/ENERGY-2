<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energy - Contacto Validado</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #fff; font-family: sans-serif; }
        
        .form-control { 
            background-color: #f2f2f2; 
            border: 2px solid transparent; 
            padding: 12px; 
            border-radius: 8px; 
            transition: 0.3s;
        }
        
        /* Validación Visual */
        .form-control:focus { background-color: #fff; border-color: #ff0000; box-shadow: none; }
        .form-control.is-invalid { border-color: #dc3545 !important; background-color: #fff8f8; }
        .form-control.is-valid { border-color: #198754 !important; background-color: #f8fff8; }
        
        .btn-enviar { 
            background-color: #ff0000; 
            color: white; 
            border: none; 
            padding: 14px; 
            font-weight: bold; 
            border-radius: 8px; 
            text-transform: uppercase;
            transition: 0.3s;
        }
        .btn-enviar:hover { background-color: #cc0000; transform: translateY(-2px); }
        
        .small-map-box {
            width: 100%; max-width: 380px; height: 220px;
            border-radius: 15px; overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08); border: 1px solid #eee; margin-top: 20px;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="container py-5 mt-4">
        <div class="row g-5">
            <div class="col-md-5">
                <h4 class="fw-bold mb-4">¡Hola! Gracias por elegir <span class="text-danger">ENERGY</span>.</h4>
                <div class="mb-4">
                    <p><i class="bi bi-telephone text-danger me-2"></i> 3794576548</p>
                    <p><i class="bi bi-geo-alt text-danger me-2"></i> Salta 560, Corrientes Capital</p>
                    <p><i class="bi bi-instagram text-danger me-2"></i> @energy.nutricion</p>
                </div>
                <div class="small-map-box">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.04505417833!2d-58.8373188!3d-27.4678255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca4237d8001%3A0x6734151a37c86576!2sSalta%20560%2C%20W3400%20Corrientes!5e0!3m2!1ses-419!2sar!4v1713554400000!5m2!1ses-419!2sar" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <div class="col-md-7">
                <form action="{{ route('contacto.store') }}" method="POST" id="contactForm" novalidate>
                    @csrf
                    
                    {{-- SI EL USUARIO ESTÁ LOGUEADO: Campos invisibles autocompletados y saludo personalizado --}}
                    @auth
                        <input type="hidden" name="nombre" value="{{ auth()->user()->name }}">
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                        <div class="alert alert-dark mb-4" style="border-radius: 10px; font-size: 0.92rem; background-color: #1a1a1a; color: #fff; border: none;">
                            <i class="bi bi-person-fill me-2 text-danger"></i> Conectado como <strong>{{ auth()->user()->name }}</strong>. Envianos tu consulta directamente abajo.
                        </div>
                    @endauth

                    {{-- SI EL USUARIO ES VISITANTE: Se dibujan todos los inputs con sus validaciones en tiempo real --}}
                    @guest
                        <div class="mb-3">
                            <label class="form-label fw-bold small">NOMBRE</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre completo" required>
                            @error('nombre')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">EMAIL</label>
                            <input type="email" name="email" class="form-control" placeholder="ejemplo@gmail.com" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">TELÉFONO</label>
                            <input type="tel" name="telefono" class="form-control" placeholder="3794..." required>
                            @error('telefono')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endguest

                    {{-- Asunto --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold small">ASUNTO</label>
                        <input type="text" name="asunto" class="form-control" placeholder="Tema de tu consulta" required>
                        @error('asunto')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- El cuadro de mensaje lo ven siempre ambos estados --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold small">MENSAJE</label>
                        <textarea name="contenido" class="form-control" rows="4" placeholder="¿En qué te ayudamos?" required></textarea>
                        @error('contenido')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-enviar w-100">ENVIAR CONSULTA</button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>