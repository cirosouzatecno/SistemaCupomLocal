@extends('layouts.app')

@section('title', 'Meu Perfil — Área do Lojista')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">

    <div class="mb-6">
        <a href="{{ route('merchant.dashboard') }}"
           class="text-sm text-gray-500 hover:text-brand-600 transition flex items-center gap-1 w-fit">
            ← Voltar ao painel
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-3">Meu Perfil</h1>
        <p class="text-sm text-gray-400 mt-1">Mantenha as informações do seu comércio atualizadas</p>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('merchant.profile.update') }}" enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Informações do comércio --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-5">
            <h2 class="text-base font-semibold text-gray-700 border-b border-gray-100 pb-3">Informações do Comércio</h2>

            {{-- Logo atual + upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo do comércio</label>
                @if ($merchant->logo_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $merchant->logo_path) }}"
                             alt="Logo atual"
                             class="h-20 w-20 object-cover rounded-xl border border-gray-200 shadow-sm">
                        <p class="text-xs text-gray-400 mt-1">Logo atual</p>
                    </div>
                @endif
                <input type="file" name="logo" id="logo" accept="image/*"
                       class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition
                              @error('logo') border-red-300 @enderror">
                @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">JPG, PNG ou WebP. Máximo 2 MB.</p>
            </div>

            {{-- Nome do comércio --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome do comércio <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $merchant->name) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 @error('name') border-red-400 @enderror"
                       required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nome do responsável --}}
            <div>
                <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">Nome do responsável</label>
                <input type="text" name="owner_name" id="owner_name"
                       value="{{ old('owner_name', $merchant->owner_name) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 @error('owner_name') border-red-400 @enderror">
                @error('owner_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- CNPJ/CPF --}}
            <div>
                <label for="cnpj_cpf" class="block text-sm font-medium text-gray-700 mb-1">CNPJ / CPF</label>
                <input type="text" name="cnpj_cpf" id="cnpj_cpf"
                       value="{{ old('cnpj_cpf', $merchant->cnpj_cpf) }}"
                       placeholder="00.000.000/0001-00"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 @error('cnpj_cpf') border-red-400 @enderror">
                @error('cnpj_cpf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Categoria --}}
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                <input type="text" name="category" id="category"
                       value="{{ old('category', $merchant->category) }}"
                       list="category-list"
                       placeholder="Ex: Restaurante, Farmácia..."
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 @error('category') border-red-400 @enderror">
                <datalist id="category-list">
                    @foreach(['Restaurante','Lanchonete','Farmácia','Supermercado','Moda','Eletrônicos','Serviços','Beleza','Academia','Padaria','Pet Shop','Outros'] as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
                @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Descrição --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição do comércio</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 @error('description') border-red-400 @enderror"
                          >{{ old('description', $merchant->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Contato --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-5">
            <h2 class="text-base font-semibold text-gray-700 border-b border-gray-100 pb-3">Contato</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="text" name="phone" id="phone"
                           value="{{ old('phone', $merchant->phone) }}"
                           placeholder="(00) 0000-0000"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                </div>
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" id="whatsapp"
                           value="{{ old('whatsapp', $merchant->whatsapp) }}"
                           placeholder="(00) 00000-0000"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email"
                       value="{{ old('email', $merchant->email) }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 @error('email') border-red-400 @enderror"
                       required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Site / Instagram</label>
                <input type="text" name="website" id="website"
                       value="{{ old('website', $merchant->website) }}"
                       placeholder="https://..."
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        {{-- Endereço --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-5">
            <h2 class="text-base font-semibold text-gray-700 border-b border-gray-100 pb-3">Endereço</h2>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Logradouro</label>
                <input type="text" name="address" id="address"
                       value="{{ old('address', $merchant->address) }}"
                       placeholder="Rua, número"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="neighborhood" class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
                    <input type="text" name="neighborhood" id="neighborhood"
                           value="{{ old('neighborhood', $merchant->neighborhood) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                </div>
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
                    <input type="text" name="zip_code" id="zip_code"
                           value="{{ old('zip_code', $merchant->zip_code) }}"
                           placeholder="00000-000"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                    <input type="text" name="city" id="city"
                           value="{{ old('city', $merchant->city) }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
                </div>
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <input type="text" name="state" id="state"
                           value="{{ old('state', $merchant->state) }}"
                           maxlength="2"
                           placeholder="SP"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 uppercase">
                </div>
            </div>
        </div>

        {{-- Alterar senha --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-5">
            <h2 class="text-base font-semibold text-gray-700 border-b border-gray-100 pb-3">Alterar Senha</h2>
            <p class="text-xs text-gray-400">Deixe em branco para manter a senha atual.</p>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nova senha</label>
                <input type="password" name="password" id="password"
                       autocomplete="new-password"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar nova senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       autocomplete="new-password"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400">
            </div>
        </div>

        {{-- Botão salvar --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm px-8 py-3 rounded-xl transition shadow-sm">
                Salvar alterações
            </button>
        </div>

    </form>
</div>
@endsection
