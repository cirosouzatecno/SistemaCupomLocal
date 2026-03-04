@extends('theme.layouts.app')

@section('title', 'Tema Azul — Admin')

@section('content')
<div class="theme-container space-y-6 py-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-text">@lang('theme.admin.title')</h1>
            <p class="text-sm text-text-muted">@lang('theme.admin.subtitle')</p>
        </div>
        <div class="flex gap-3">
            <x-theme.button variant="secondary" size="sm">@lang('theme.actions.export')</x-theme.button>
            <x-theme.button size="sm">@lang('theme.actions.invite')</x-theme.button>
        </div>
    </div>

    <x-theme.card>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <x-theme.button variant="secondary" size="sm">@lang('theme.admin.bulk')</x-theme.button>
                <x-theme.button variant="ghost" size="sm" data-modal-open="bulkModal">@lang('theme.admin.delete')</x-theme.button>
            </div>
            <div class="text-sm text-text-muted">@lang('theme.admin.selection')</div>
        </div>
    </x-theme.card>

    <x-theme.table>
        <x-slot name="head">
            <tr>
                <th class="px-5 py-3 text-left">
                    <input type="checkbox" class="h-4 w-4 rounded border-border text-brand-600" />
                </th>
                <th class="px-5 py-3 text-left">@lang('theme.admin.table_name')</th>
                <th class="px-5 py-3">@lang('theme.admin.table_role')</th>
                <th class="px-5 py-3">@lang('theme.admin.table_status')</th>
                <th class="px-5 py-3 text-right">@lang('theme.admin.table_actions')</th>
            </tr>
        </x-slot>

        @foreach ($users as $user)
            <tr class="hover:bg-surface-alt">
                <td class="px-5 py-4">
                    <input type="checkbox" class="h-4 w-4 rounded border-border text-brand-600" />
                </td>
                <td class="px-5 py-4">
                    <p class="text-sm font-semibold text-text">{{ $user['name'] }}</p>
                    <p class="text-xs text-text-muted">{{ $user['email'] }}</p>
                </td>
                <td class="px-5 py-4 text-sm text-text-muted">{{ $user['role'] }}</td>
                <td class="px-5 py-4 text-sm">
                    <x-theme.badge :variant="$user['variant']">{{ $user['status'] }}</x-theme.badge>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="inline-flex gap-2">
                        <button class="rounded-lg p-2 text-text-muted hover:bg-surface-alt">
                            <x-theme.icon name="edit" class="h-4 w-4" />
                        </button>
                        <button class="rounded-lg p-2 text-text-muted hover:bg-surface-alt" data-modal-open="bulkModal">
                            <x-theme.icon name="trash" class="h-4 w-4" />
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-theme.table>
</div>

<x-theme.modal id="bulkModal" title="@lang('theme.admin.modal_title')">
    <p class="text-sm text-text-muted">@lang('theme.admin.modal_body')</p>
    <x-slot name="footer">
        <div class="flex justify-end gap-3">
            <x-theme.button variant="secondary" data-modal-close>@lang('theme.actions.cancel')</x-theme.button>
            <x-theme.button variant="danger">@lang('theme.actions.confirm')</x-theme.button>
        </div>
    </x-slot>
</x-theme.modal>
@endsection
