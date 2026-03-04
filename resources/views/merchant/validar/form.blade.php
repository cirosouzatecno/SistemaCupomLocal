@extends('layouts.app')

@section('title', 'Validar Cupom — Área do Lojista')

@section('content')
<div class="max-w-lg mx-auto px-4 py-14">

    {{-- Cabeçalho --}}
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">📱</div>
        <h1 class="text-2xl font-bold text-gray-800">Validar Cupom</h1>
        <p class="text-sm text-gray-500 mt-2">
            Digite o código do cupom ou use a câmera para ler o QR Code do cliente.
        </p>
    </div>

    {{-- Sucesso --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-300 text-green-800 rounded-xl px-5 py-4 mb-6 text-sm font-medium flex items-center gap-3">
            <span class="text-xl">✅</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulário --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('merchant.validate.lookup') }}" id="validate-form">
            @csrf

            <div>
                <label for="token" class="block text-sm font-semibold text-gray-700 mb-2">
                    Código do cupom
                </label>
                <textarea
                    name="token"
                    id="token"
                    rows="3"
                    autofocus
                    placeholder="Cole aqui o código UUID do cupom do cliente..."
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-400 resize-none
                           @error('token') border-red-400 bg-red-50 @enderror"
                >{{ old('token') }}</textarea>

                @error('token')
                    <p class="text-red-500 text-sm mt-2 font-medium flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror

                <p class="text-xs text-gray-400 mt-2">
                    O código aparece abaixo do QR Code na tela do cliente. Ex: <span class="font-mono">550e8400-e29b-41d4-a716-446655440000</span>
                </p>
            </div>

            {{-- Botão scanner QR --}}
            <button type="button" id="btn-abrir-camera"
                    class="mt-4 w-full flex items-center justify-center gap-2 border-2 border-dashed border-brand-400 text-brand-600
                           hover:bg-brand-50 hover:border-brand-500 font-semibold py-3 rounded-xl transition text-sm">
                <span class="text-xl">📷</span>
                Escanear QR Code com câmera
            </button>

            {{-- Área da câmera (oculta inicialmente) --}}
            <div id="qr-scanner-wrapper" class="hidden mt-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-semibold text-gray-600">🔍 Aponte para o QR Code do cliente</p>
                    <button type="button" id="btn-fechar-camera"
                            class="text-xs text-red-500 hover:text-red-700 font-semibold hover:underline transition">
                        ✕ Fechar câmera
                    </button>
                </div>

                {{-- Seletor de câmera (aparece quando há mais de 1) --}}
                <div id="camera-select-wrapper" class="hidden mb-2">
                    <select id="camera-select"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-400">
                    </select>
                </div>

                {{-- Vídeo + overlay --}}
                <div class="relative rounded-xl overflow-hidden bg-black border-2 border-brand-300" style="aspect-ratio:1/1; max-height:340px;">
                    <video id="qr-video" autoplay playsinline muted
                           class="w-full h-full object-cover"></video>
                    {{-- Mira de leitura --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="border-4 border-white rounded-xl opacity-70"
                             style="width:65%;height:65%;box-shadow:0 0 0 9999px rgba(0,0,0,0.45);"></div>
                    </div>
                    {{-- Canvas oculto usado para decode --}}
                    <canvas id="qr-canvas" class="hidden"></canvas>
                </div>

                {{-- Status do scan --}}
                <div id="qr-status" class="mt-2 text-xs text-center min-h-[1.5rem] font-medium text-gray-500"></div>
            </div>

            {{-- Feedback de leitura bem-sucedida --}}
            <div id="qr-success-banner" class="hidden mt-3 bg-green-50 border border-green-300 rounded-xl px-4 py-3 flex items-center gap-3">
                <span class="text-xl">✅</span>
                <div>
                    <p class="text-sm font-semibold text-green-800">QR Code lido com sucesso!</p>
                    <p class="text-xs text-green-600 mt-0.5">Código preenchido automaticamente. Clique em <strong>Verificar</strong> para continuar.</p>
                </div>
            </div>

            <button type="submit"
                    class="mt-6 w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-xl transition shadow-sm text-sm">
                Verificar cupom →
            </button>
        </form>
    </div>

    {{-- Instruções --}}
    <div class="mt-8 bg-blue-50 border border-blue-100 rounded-2xl px-6 py-5">
        <h3 class="text-sm font-semibold text-blue-800 mb-3">Como validar um cupom</h3>
        <ol class="text-sm text-blue-700 space-y-2 list-decimal list-inside">
            <li>Peça ao cliente para abrir o cupom no aplicativo</li>
            <li>Clique em <strong>"Escanear QR Code"</strong> e aponte a câmera para a tela do cliente</li>
            <li>O código será lido e preenchido automaticamente</li>
            <li>Clique em <strong>Verificar</strong> e depois em <strong>Confirmar uso</strong></li>
        </ol>
    </div>

</div>

{{-- ── Script: scanner QR usando jsQR (getUserMedia + canvas, sem wrapper) ── --}}
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
(function () {
    /* ── refs ───────────────────────────────────────────────────────────── */
    const btnAbrir   = document.getElementById('btn-abrir-camera');
    const btnFechar  = document.getElementById('btn-fechar-camera');
    const wrapper    = document.getElementById('qr-scanner-wrapper');
    const video      = document.getElementById('qr-video');
    const canvas     = document.getElementById('qr-canvas');
    const ctx        = canvas.getContext('2d');
    const tokenField = document.getElementById('token');
    const statusEl   = document.getElementById('qr-status');
    const successEl  = document.getElementById('qr-success-banner');
    const camSelect  = document.getElementById('camera-select');
    const camWrapper = document.getElementById('camera-select-wrapper');

    let stream     = null;   // MediaStream ativo
    let rafId      = null;   // requestAnimationFrame handle
    let active     = false;

    /* ── helpers ────────────────────────────────────────────────────────── */
    function setStatus(msg, cls) {
        statusEl.textContent = msg;
        statusEl.className   = 'mt-2 text-xs text-center min-h-[1.5rem] font-medium ' + (cls || 'text-gray-500');
    }

    function stopCamera() {
        active = false;
        if (rafId) { cancelAnimationFrame(rafId); rafId = null; }
        if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
        video.srcObject = null;
    }

    /* ── loop de decodificação ──────────────────────────────────────────── */
    function scanLoop() {
        if (!active) return;

        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert',
            });

            if (code && code.data) {
                /* ✅ QR detectado */
                stopCamera();
                tokenField.value = code.data.trim();
                wrapper.classList.add('hidden');
                btnAbrir.classList.remove('hidden');
                successEl.classList.remove('hidden');
                tokenField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                tokenField.focus();
                return;
            }
        }

        rafId = requestAnimationFrame(scanLoop);
    }

    /* ── inicia câmera com uma constraint ───────────────────────────────── */
    async function startCamera(constraint) {
        stopCamera();
        setStatus('Abrindo câmera…', 'text-indigo-500');

        try {
            stream          = await navigator.mediaDevices.getUserMedia({ video: constraint, audio: false });
            video.srcObject = stream;
            await video.play();
            active = true;
            setStatus('✅ Câmera ativa — aponte para o QR Code do cliente', 'text-green-600');
            rafId  = requestAnimationFrame(scanLoop);
        } catch (err) {
            const msg = String(err).toLowerCase();
            if (msg.includes('notallowed') || msg.includes('permission') || msg.includes('denied')) {
                setStatus('❌ Permissão de câmera negada. Habilite nas configurações do navegador.', 'text-red-500');
            } else if (msg.includes('notfound') || msg.includes('devicenotfound')) {
                setStatus('❌ Nenhuma câmera encontrada neste dispositivo.', 'text-red-500');
            } else {
                setStatus('❌ Erro ao abrir câmera: ' + err, 'text-red-500');
            }
        }
    }

    /* ── botão abrir ────────────────────────────────────────────────────── */
    btnAbrir.addEventListener('click', async function () {
        /* Segurança: câmera só funciona em HTTPS ou localhost */
        if (location.protocol !== 'https:'
            && location.hostname !== 'localhost'
            && location.hostname !== '127.0.0.1') {
            wrapper.classList.remove('hidden');
            btnAbrir.classList.add('hidden');
            setStatus('❌ Câmera requer HTTPS. Use o link do Cloudflare Tunnel (https://).', 'text-red-500');
            return;
        }

        if (!navigator.mediaDevices?.getUserMedia) {
            wrapper.classList.remove('hidden');
            btnAbrir.classList.add('hidden');
            setStatus('❌ Este navegador não suporta câmera. Use Chrome ou Firefox.', 'text-red-500');
            return;
        }

        successEl.classList.add('hidden');
        wrapper.classList.remove('hidden');
        btnAbrir.classList.add('hidden');

        const isMobile = /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);

        if (isMobile) {
            /* Mobile: câmera traseira direta */
            await startCamera({ facingMode: { exact: 'environment' } });
            /* Se falhou com exact, tenta sem exact */
            if (!active) await startCamera({ facingMode: 'environment' });
        } else {
            /* Desktop: lista câmeras e mostra seletor */
            try {
                const devices = (await navigator.mediaDevices.enumerateDevices())
                    .filter(d => d.kind === 'videoinput');

                if (devices.length > 1) {
                    camSelect.innerHTML = '';
                    devices.forEach((d, i) => {
                        const o = document.createElement('option');
                        o.value       = d.deviceId;
                        o.textContent = d.label || ('Câmera ' + (i + 1));
                        camSelect.appendChild(o);
                    });
                    camWrapper.classList.remove('hidden');
                    await startCamera({ deviceId: { exact: camSelect.value } });
                } else {
                    await startCamera({ facingMode: 'environment' });
                }
            } catch {
                await startCamera({ facingMode: 'environment' });
            }
        }
    });

    /* Troca câmera (desktop) */
    camSelect.addEventListener('change', async function () {
        await startCamera({ deviceId: { exact: this.value } });
    });

    /* Fecha câmera */
    btnFechar.addEventListener('click', function () {
        stopCamera();
        wrapper.classList.add('hidden');
        btnAbrir.classList.remove('hidden');
        setStatus('');
    });

    /* Para câmera ao sair */
    window.addEventListener('beforeunload', stopCamera);
    window.addEventListener('pagehide',     stopCamera);
})();
</script>
@endsection
