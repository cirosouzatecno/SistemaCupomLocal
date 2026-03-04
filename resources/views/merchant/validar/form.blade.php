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

                {{-- Preview da câmera --}}
                <div id="qr-reader"
                     class="w-full rounded-xl overflow-hidden border-2 border-brand-300 bg-gray-900"
                     style="min-height: 300px;">
                </div>

                {{-- Status do scan --}}
                <div id="qr-status" class="mt-2 text-xs text-center text-gray-500 min-h-[1.5rem]"></div>
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

{{-- ── Script: scanner QR ────────────────────────────────────────────────── --}}
{{-- CDN carregado ANTES do script inline para garantir que Html5Qrcode esteja disponível --}}
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
(function () {
    const btnAbrir   = document.getElementById('btn-abrir-camera');
    const btnFechar  = document.getElementById('btn-fechar-camera');
    const wrapper    = document.getElementById('qr-scanner-wrapper');
    const tokenField = document.getElementById('token');
    const statusEl   = document.getElementById('qr-status');
    const successEl  = document.getElementById('qr-success-banner');
    const camSelect  = document.getElementById('camera-select');
    const camWrapper = document.getElementById('camera-select-wrapper');

    let html5QrCode = null;
    let scanning    = false;

    function setStatus(msg, color) {
        statusEl.textContent = msg;
        statusEl.className   = 'mt-2 text-xs text-center min-h-[1.5rem] font-medium ' + (color || 'text-gray-500');
    }

    function onScanSuccess(decodedText) {
        // Para o scanner antes de tudo
        stopScanner();

        // Preenche o campo com o código lido
        tokenField.value = decodedText.trim();

        // Esconde câmera e mostra feedback
        wrapper.classList.add('hidden');
        btnAbrir.classList.remove('hidden');
        successEl.classList.remove('hidden');

        // Rola até o campo preenchido
        tokenField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        tokenField.focus();
    }

    function getQrbox(viewfinderWidth, viewfinderHeight) {
        // Caixa de scan = 80% do menor lado, mínimo 150px
        const side = Math.max(150, Math.floor(Math.min(viewfinderWidth, viewfinderHeight) * 0.8));
        return { width: side, height: side };
    }

    function startWithConstraint(constraint) {
        if (!html5QrCode) {
            // experimentalFeatures usa BarcodeDetector nativo no Android Chrome — muito mais rápido
            html5QrCode = new Html5Qrcode('qr-reader', {
                verbose: false,
                experimentalFeatures: { useBarCodeDetectorIfSupported: true },
            });
        }

        setStatus('Abrindo câmera…', 'text-indigo-500');

        html5QrCode.start(
            constraint,
            {
                fps: 15,
                qrbox: getQrbox,       // tamanho dinâmico baseado no vídeo real
                aspectRatio: 1.0,
                disableFlip: false,    // tenta imagem espelhada também
            },
            onScanSuccess,
            (_errorMsg) => { /* frame sem QR — silencioso */ }
        )
        .then(() => {
            scanning = true;
            setStatus('✅ Câmera ativa — aponte para o QR Code do cliente', 'text-green-600');
        })
        .catch((err) => {
            const msg = String(err).toLowerCase();
            if (constraint && constraint.facingMode === 'environment') {
                setStatus('Câmera traseira indisponível, alternando…', 'text-yellow-600');
                startWithConstraint({ facingMode: 'user' });
            } else if (msg.includes('permission') || msg.includes('denied') || msg.includes('notallowed')) {
                setStatus('❌ Permissão de câmera negada. Ative nas configurações do navegador.', 'text-red-500');
            } else {
                setStatus('❌ Não foi possível abrir a câmera: ' + err, 'text-red-500');
            }
        });
    }

    function stopScanner() {
        if (html5QrCode && scanning) {
            html5QrCode.stop().catch(() => {});
            scanning = false;
        }
    }

    /* ── Abre câmera ─────────────────────────────────────────────────────── */
    btnAbrir.addEventListener('click', function () {
        // Câmera exige HTTPS (exceto localhost)
        if (location.protocol !== 'https:'
            && location.hostname !== 'localhost'
            && location.hostname !== '127.0.0.1') {
            wrapper.classList.remove('hidden');
            btnAbrir.classList.add('hidden');
            setStatus('❌ Câmera só funciona via HTTPS. Use o link do Cloudflare Tunnel ou localhost.', 'text-red-500');
            return;
        }

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            wrapper.classList.remove('hidden');
            btnAbrir.classList.add('hidden');
            setStatus('❌ Este navegador não suporta câmera. Use Chrome ou Firefox atualizado.', 'text-red-500');
            return;
        }

        successEl.classList.add('hidden');
        wrapper.classList.remove('hidden');
        btnAbrir.classList.add('hidden');

        const isMobile = /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);

        if (isMobile) {
            // Mobile: inicia direto com câmera traseira — dispara permissão imediatamente
            startWithConstraint({ facingMode: 'environment' });
        } else {
            // Desktop: lista câmeras para mostrar seletor se houver mais de uma
            setStatus('Listando câmeras…', 'text-indigo-500');
            Html5Qrcode.getCameras()
                .then((devices) => {
                    if (!devices || devices.length === 0) {
                        setStatus('❌ Nenhuma câmera encontrada.', 'text-red-500');
                        return;
                    }
                    if (devices.length > 1) {
                        camSelect.innerHTML = '';
                        devices.forEach((cam, idx) => {
                            const opt       = document.createElement('option');
                            opt.value       = cam.id;
                            opt.textContent = cam.label || ('Câmera ' + (idx + 1));
                            camSelect.appendChild(opt);
                        });
                        const back = devices.findIndex(d => /back|rear|traseira|environment/i.test(d.label));
                        if (back >= 0) camSelect.selectedIndex = back;
                        camWrapper.classList.remove('hidden');
                        startWithConstraint(camSelect.value);
                    } else {
                        startWithConstraint(devices[0].id);
                    }
                })
                .catch(() => startWithConstraint({ facingMode: 'environment' }));
        }
    });

    /* Troca câmera no seletor (desktop) */
    camSelect.addEventListener('change', function () {
        stopScanner();
        scanning = false;
        startWithConstraint(this.value);
    });

    /* Fecha câmera */
    btnFechar.addEventListener('click', function () {
        stopScanner();
        wrapper.classList.add('hidden');
        btnAbrir.classList.remove('hidden');
        setStatus('');
    });

    /* Para câmera ao sair da página */
    window.addEventListener('beforeunload', stopScanner);
})();
</script>
@endsection
