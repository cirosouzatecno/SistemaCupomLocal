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

            <input type="file" name="image" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                          file:bg-brand-50 file:text-brand-700 file:font-medium hover:file:bg-brand-100 cursor-pointer">
            <p class="text-xs text-gray-400 mt-1">JPG, PNG ou WebP — máx. 2 MB</p>
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
