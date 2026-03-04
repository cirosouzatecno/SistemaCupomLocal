{{--
    Partial _form.blade.php: campos comuns ao criar e editar cupom.
    Uso: @include('merchant.coupons._form', ['coupon' => $coupon ?? null])
--}}
<div class="space-y-6">

    {{-- Título + Categoria --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Título <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title"
                   value="{{ old('title', $coupon->title ?? '') }}"
                   placeholder="Ex.: 10% em compras acima de R$ 50"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('title') border-red-400 @enderror"
                   required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
            <input type="text" name="category"
                   value="{{ old('category', $coupon->category ?? '') }}"
                   list="categorias-list"
                   placeholder="Ex.: Alimentação, Farmácia…"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500">
            <datalist id="categorias-list">
                @foreach(['Alimentação','Farmácia','Vestuário','Beleza','Serviços','Eletrônicos','Padaria','Restaurante','Supermercado','Pet','Academia','Outros'] as $cat)
                    <option value="{{ $cat }}">
                @endforeach
            </datalist>
        </div>
    </div>

    {{-- Descrição --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
        <textarea name="description" rows="3"
                  placeholder="Detalhe as condições, produtos incluídos, restrições…"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 resize-none @error('description') border-red-400 @enderror">{{ old('description', $coupon->description ?? '') }}</textarea>
        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Desconto --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Tipo de desconto <span class="text-red-500">*</span>
            </label>
            <select name="discount_type"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500"
                    required>
                <option value="percent" @selected(old('discount_type', $coupon->discount_type ?? '') === 'percent')>Percentual (%)</option>
                <option value="fixed"   @selected(old('discount_type', $coupon->discount_type ?? '') === 'fixed')>Valor fixo (R$)</option>
            </select>
            @error('discount_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Valor do desconto <span class="text-red-500">*</span>
            </label>
            <input type="number" name="discount_value" step="0.01" min="0.01"
                   value="{{ old('discount_value', $coupon->discount_value ?? '') }}"
                   placeholder="Ex.: 10 (para 10% ou R$ 10)"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('discount_value') border-red-400 @enderror"
                   required>
            @error('discount_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Datas + Valor mínimo --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Data Início <span class="text-red-500">*</span>
            </label>
            <input type="date" name="start_date"
                   value="{{ old('start_date', isset($coupon) ? $coupon->start_date->format('Y-m-d') : '') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('start_date') border-red-400 @enderror"
                   required>
            @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Data Fim <span class="text-red-500">*</span>
            </label>
            <input type="date" name="end_date"
                   value="{{ old('end_date', isset($coupon) ? $coupon->end_date->format('Y-m-d') : '') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('end_date') border-red-400 @enderror"
                   required>
            @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Valor mínimo (R$)</label>
            <input type="number" name="min_value" step="0.01" min="0"
                   value="{{ old('min_value', $coupon->min_value ?? '') }}"
                   placeholder="Opcional"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500">
        </div>
    </div>

    {{-- Limites --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantidade total de resgates</label>
            <input type="number" name="total_quantity" min="1"
                   value="{{ old('total_quantity', $coupon->total_quantity ?? '') }}"
                   placeholder="Ilimitado (deixe em branco)"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Limite por usuário <span class="text-red-500">*</span>
            </label>
            <input type="number" name="per_user_limit" min="1" max="10"
                   value="{{ old('per_user_limit', $coupon->per_user_limit ?? 1) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500 @error('per_user_limit') border-red-400 @enderror"
                   required>
            @error('per_user_limit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Imagem + Status --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Imagem do cupom</label>

            @if (isset($coupon) && $coupon->image_path)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $coupon->image_path) }}"
                         alt="Imagem atual" class="h-20 rounded-lg object-cover border border-gray-200">
                    <p class="text-xs text-gray-400 mt-1">Envie nova imagem para substituir</p>
                </div>
            @endif

            {{-- Input de arquivo --}}
            <input type="file" name="image" id="coupon-image-input" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                          file:bg-brand-50 file:text-brand-700 file:font-medium hover:file:bg-brand-100 cursor-pointer">
            <p class="text-xs text-gray-400 mt-1">JPG, PNG ou WebP — máx. 2 MB</p>

            {{-- Botão Gerar por IA --}}
            <button type="button" id="btn-gerar-ia"
                    class="mt-2 flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                           text-white text-xs font-semibold px-4 py-2 rounded-lg transition shadow-sm
                           disabled:opacity-50 disabled:cursor-not-allowed">
                <span id="ia-btn-icon" aria-hidden="true">✨</span>
                <span id="ia-btn-label">Gerar por IA</span>
            </button>
            <p class="text-xs text-gray-400 mt-1">Usa o título e a descrição para criar a imagem automaticamente com IA (Pollinations.AI).</p>

            {{-- Spinner de carregamento --}}
            <div id="ia-loading" class="hidden mt-3 flex items-center gap-2 text-indigo-600 text-xs font-medium">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Gerando imagem com IA, aguarde (pode levar até 1 minuto)…
            </div>

            {{-- Preview da imagem gerada --}}
            <div id="ia-preview-wrapper" class="hidden mt-4 p-3 bg-indigo-50 border border-indigo-200 rounded-xl">
                <p class="text-xs font-semibold text-indigo-700 mb-2">✅ Imagem gerada por IA:</p>
                <img id="ia-preview-img" src="" alt="Imagem gerada por IA" crossorigin="anonymous"
                     class="w-[335px] h-[335px] max-w-full rounded-xl object-cover border-2 border-indigo-300 shadow-md mx-auto block">
                <div class="mt-2 flex items-center gap-3">
                    <span class="text-xs text-indigo-600 font-medium">335 × 335 px</span>
                    <button type="button" id="btn-ia-remove"
                            class="text-xs text-red-500 hover:text-red-700 hover:underline transition">
                        ✕ Remover e usar upload manual
                    </button>
                </div>
            </div>

            {{-- Campo oculto — path da imagem já salva pelo servidor --}}
            <input type="hidden" name="ai_image_path" id="ai_image_path" value="">

            {{-- Mensagem de erro da IA --}}
            <p id="ia-error" class="hidden text-xs text-red-500 mt-2"></p>

            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Status <span class="text-red-500">*</span>
            </label>
            <select name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-brand-500"
                    required>
                <option value="active"   @selected(old('status', $coupon->status ?? 'active') === 'active')>✅ Ativo — visível na plataforma</option>
                <option value="inactive" @selected(old('status', $coupon->status ?? '') === 'inactive')>⏸️ Inativo — oculto temporariamente</option>
                @isset($coupon)
                    <option value="expired"  @selected(old('status', $coupon->status) === 'expired')>🔒 Expirado</option>
                @endisset
            </select>
        </div>
    </div>

</div>

{{-- ── Script: Gerar imagem por IA (via servidor-proxy → Pollinations.AI) ── --}}
<script>
(function () {
    const btn           = document.getElementById('btn-gerar-ia');
    const btnLabel      = document.getElementById('ia-btn-label');
    const btnIcon       = document.getElementById('ia-btn-icon');
    const loading       = document.getElementById('ia-loading');
    const preview       = document.getElementById('ia-preview-wrapper');
    const previewImg    = document.getElementById('ia-preview-img');
    const removeBtn     = document.getElementById('btn-ia-remove');
    const errorMsg      = document.getElementById('ia-error');
    const aiPathInput   = document.getElementById('ai_image_path');

    if (!btn) return;

    const aiRoute   = '{{ route("merchant.coupons.ai-image") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                   || document.querySelector('input[name="_token"]')?.value
                   || '';

    function setLoading(on) {
        btn.disabled         = on;
        btnIcon.textContent  = on ? '' : '✨';
        btnLabel.textContent = on ? 'Gerando…' : 'Gerar por IA';
        loading.classList.toggle('hidden', !on);
        if (on) { preview.classList.add('hidden'); clearError(); }
    }

    function showError(msg) {
        errorMsg.textContent = '⚠️ ' + msg;
        errorMsg.classList.remove('hidden');
    }

    function clearError() {
        errorMsg.textContent = '';
        errorMsg.classList.add('hidden');
    }

    function buildPrompt(title, desc) {
        const context = [title, desc].filter(Boolean).join(' - ');
        return 'discount coupon image square format'
             + (context ? ', ' + context : '')
             + ', vibrant colorful gradient background, modern flat design, no text, no letters, bold shapes, product thumbnail';
    }

    btn.addEventListener('click', async function () {
        clearError();

        const title = (document.querySelector('input[name="title"]')?.value ?? '').trim();
        const desc  = (document.querySelector('textarea[name="description"]')?.value ?? '').trim();

        if (!title && !desc) {
            showError('Preencha pelo menos o Título ou a Descrição antes de gerar.');
            return;
        }

        setLoading(true);

        // Limpa path anterior
        aiPathInput.value = '';

        // AbortController para timeout de 120 segundos
        const controller = new AbortController();
        const timeoutId  = setTimeout(() => controller.abort(), 180_000);

        try {
            const resp = await fetch(aiRoute, {
                method:  'POST',
                signal:  controller.signal,
                headers: {
                    'Content-Type':     'application/json',
                    'Accept':           'application/json',
                    'X-CSRF-TOKEN':     csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ prompt: buildPrompt(title, desc), title: title }),
            });

            clearTimeout(timeoutId);

            const data = await resp.json();

            if (!resp.ok || data.error) {
                showError(data.error ?? `Erro ${resp.status}. Tente novamente.`);
                setLoading(false);
                return;
            }

            // Sucesso — servidor salvou a imagem e devolveu a URL local
            aiPathInput.value  = data.path;
            previewImg.src     = data.imageUrl;
            preview.classList.remove('hidden');
            preview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        } catch (err) {
            clearTimeout(timeoutId);
            if (err.name === 'AbortError') {
                showError('Tempo limite excedido (120 s). O servidor de imagens está lento. Tente novamente.');
            } else {
                showError('Erro de comunicação: ' + err.message + '. Verifique o console do navegador.');
            }
        }

        setLoading(false);
    });

    /* Botão "Remover" */
    removeBtn.addEventListener('click', function () {
        aiPathInput.value = '';
        previewImg.src    = '';
        preview.classList.add('hidden');
        clearError();
    });
})();
</script>
