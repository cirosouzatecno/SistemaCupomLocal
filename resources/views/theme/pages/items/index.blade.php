@extends('theme.layouts.app')

@section('title', 'Tema Azul — Itens')

@section('content')
<div class="theme-container space-y-6 py-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-text">@lang('theme.items.title')</h1>
            <p class="text-sm text-text-muted">@lang('theme.items.subtitle')</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <x-theme.button variant="secondary" size="sm">
                <x-theme.icon name="filter" class="mr-2 h-4 w-4" />
                @lang('theme.items.filter')
            </x-theme.button>
            <x-theme.button size="sm">
                <x-theme.icon name="plus" class="mr-2 h-4 w-4" />
                @lang('theme.items.new')
            </x-theme.button>
        </div>
    </div>

    <x-theme.card>
        <div class="grid gap-4 lg:grid-cols-4">
            <x-theme.input label="@lang('theme.items.search')" placeholder="@lang('theme.items.search_placeholder')" />
            <x-theme.select label="@lang('theme.items.status')">
                <option>@lang('theme.items.status_all')</option>
                <option>@lang('theme.items.status_active')</option>
                <option>@lang('theme.items.status_paused')</option>
            </x-theme.select>
            <x-theme.select label="@lang('theme.items.owner')">
                <option>@lang('theme.items.owner_all')</option>
                <option>Equipe Alfa</option>
                <option>Equipe Beta</option>
            </x-theme.select>
            <div class="flex items-end">
                <x-theme.button size="sm" class="w-full">@lang('theme.items.apply')</x-theme.button>
            </div>
        </div>
    </x-theme.card>

    <x-theme.table>
        <x-slot name="head">
            <tr>
                <th class="px-5 py-3 text-left">
                    <input type="checkbox" class="h-4 w-4 rounded border-border text-brand-600" />
                </th>
                <th class="px-5 py-3 text-left">@lang('theme.items.table_item')</th>
                <th class="px-5 py-3">@lang('theme.items.table_owner')</th>
                <th class="px-5 py-3">@lang('theme.items.table_status')</th>
                <th class="px-5 py-3 text-right">@lang('theme.items.table_actions')</th>
            </tr>
        </x-slot>

        @foreach ($items as $item)
            <tr class="hover:bg-surface-alt">
                <td class="px-5 py-4">
                    <input type="checkbox" class="h-4 w-4 rounded border-border text-brand-600" />
                </td>
                <td class="px-5 py-4">
                    <p class="text-sm font-semibold text-text">{{ $item['name'] }}</p>
                    <p class="text-xs text-text-muted">{{ $item['detail'] }}</p>
                </td>
                <td class="px-5 py-4 text-sm text-text-muted">{{ $item['owner'] }}</td>
                <td class="px-5 py-4 text-sm">
                    <x-theme.badge :variant="$item['variant']">{{ $item['status'] }}</x-theme.badge>
                </td>
                <td class="px-5 py-4 text-right">
                    <button class="rounded-lg p-2 text-text-muted hover:bg-surface-alt">
                        <x-theme.icon name="dots" class="h-4 w-4" />
                    </button>
                </td>
            </tr>
        @endforeach
    </x-theme.table>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-text-muted">@lang('theme.items.pagination')</p>
        <x-theme.pagination :current="2" :total="5" />
    </div>
</div>
@endsection
