@props([
    'name' => 'square',
    'class' => 'h-5 w-5',
])

@php
    $cls = $class;
    $icons = [
        'square' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\"><rect x=\"4\" y=\"4\" width=\"16\" height=\"16\" rx=\"3\" /></svg>",
        'menu' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M3 6h18M3 12h18M3 18h18\" /></svg>",
        'search' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"11\" cy=\"11\" r=\"7\" /><path d=\"M20 20l-3.5-3.5\" /></svg>",
        'spark' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M12 3l2.8 5.6L21 11l-6.2 2.4L12 21l-2.8-7.6L3 11l6.2-2.4L12 3z\" /></svg>",
        'home' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M3 12l9-9 9 9\" /><path d=\"M5 10v10a2 2 0 0 0 2 2h3v-6h4v6h3a2 2 0 0 0 2-2V10\" /></svg>",
        'grid' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><rect x=\"3\" y=\"3\" width=\"7\" height=\"7\" /><rect x=\"14\" y=\"3\" width=\"7\" height=\"7\" /><rect x=\"14\" y=\"14\" width=\"7\" height=\"7\" /><rect x=\"3\" y=\"14\" width=\"7\" height=\"7\" /></svg>",
        'user' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M20 21a8 8 0 0 0-16 0\" /><circle cx=\"12\" cy=\"8\" r=\"4\" /></svg>",
        'users' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M16 19a4 4 0 0 0-8 0\" /><circle cx=\"12\" cy=\"9\" r=\"4\" /><path d=\"M22 19a4 4 0 0 0-6-3.46\" /><path d=\"M2 19a4 4 0 0 1 6-3.46\" /></svg>",
        'settings' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"12\" cy=\"12\" r=\"3\" /><path d=\"M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 1.5V21a2 2 0 0 1-4 0v-.1a1.7 1.7 0 0 0-1-1.5 1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.5-1H3a2 2 0 0 1 0-4h.1a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.34-1.87l-.06-.06A2 2 0 1 1 7.03 3.2l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.5V3a2 2 0 0 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 0 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z\" /></svg>",
        'plus' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M12 5v14M5 12h14\" /></svg>",
        'chevron-down' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 9l6 6 6-6\" /></svg>",
        'chevron-right' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M9 6l6 6-6 6\" /></svg>",
        'chevron-left' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M15 6l-6 6 6 6\" /></svg>",
        'check' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M20 6L9 17l-5-5\" /></svg>",
        'alert' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M10.3 3.9l-7 12a2 2 0 0 0 1.7 3h14a2 2 0 0 0 1.7-3l-7-12a2 2 0 0 0-3.4 0z\" /><path d=\"M12 9v4\" /><path d=\"M12 17h.01\" /></svg>",
        'info' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"12\" cy=\"12\" r=\"10\" /><path d=\"M12 16v-4\" /><path d=\"M12 8h.01\" /></svg>",
        'x' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M18 6L6 18M6 6l12 12\" /></svg>",
        'logout' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4\" /><path d=\"M16 17l5-5-5-5\" /><path d=\"M21 12H9\" /></svg>",
        'chart' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M3 3v18h18\" /><path d=\"M7 14h3v4H7z\" /><path d=\"M12 9h3v9h-3z\" /><path d=\"M17 5h3v13h-3z\" /></svg>",
        'filter' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M4 5h16l-6 7v5l-4 2v-7z\" /></svg>",
        'dots' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"12\" cy=\"5\" r=\"1.5\" /><circle cx=\"12\" cy=\"12\" r=\"1.5\" /><circle cx=\"12\" cy=\"19\" r=\"1.5\" /></svg>",
        'edit' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M12 20h9\" /><path d=\"M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z\" /></svg>",
        'trash' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M3 6h18\" /><path d=\"M8 6v-2h8v2\" /><path d=\"M6 6l1 14h10l1-14\" /></svg>",
        'mail' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><rect x=\"3\" y=\"5\" width=\"18\" height=\"14\" rx=\"2\" /><path d=\"M3 7l9 6 9-6\" /></svg>",
        'lock' => "<svg class=\"$cls\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><rect x=\"4\" y=\"11\" width=\"16\" height=\"9\" rx=\"2\" /><path d=\"M8 11V7a4 4 0 1 1 8 0v4\" /></svg>",
    ];
@endphp

{!! $icons[$name] ?? $icons['square'] !!}
