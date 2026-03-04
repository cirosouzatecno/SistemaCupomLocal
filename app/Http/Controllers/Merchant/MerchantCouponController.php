<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MerchantCouponController extends Controller
{
    private function merchant()
    {
        return Auth::guard('merchant')->user();
    }

    // ─── Listagem ─────────────────────────────────────────────────────────────

    public function index()
    {
        $merchant = $this->merchant();

        $coupons = Coupon::where('merchant_id', $merchant->id)
            ->withCount([
                'userCoupons as total_adicionados',
                'userCoupons as total_usados' => fn ($q) => $q->where('status', 'used'),
            ])
            ->latest()
            ->paginate(15);

        return view('merchant.coupons.index', compact('coupons', 'merchant'));
    }

    // ─── Criar ────────────────────────────────────────────────────────────────

    public function create()
    {
        return view('merchant.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'category'       => 'nullable|string|max:100',
            'discount_type'  => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0.01|max:999999',
            'min_value'      => 'nullable|numeric|min:0',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'total_quantity' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1|max:10',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ai_image_path'  => 'nullable|string|max:512',
            'status'         => 'required|in:active,inactive',
        ], $this->messages());

        $merchant = $this->merchant();

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Upload manual do formulário
            $imagePath = $request->file('image')->store('coupons', 'public');
        } elseif ($request->filled('ai_image_path')) {
            // Imagem já salva pelo endpoint generateAiImage()
            $candidate = $request->input('ai_image_path');
            if (str_starts_with($candidate, 'coupons/') && Storage::disk('public')->exists($candidate)) {
                $imagePath = $candidate;
            }
        }

        Coupon::create([
            'merchant_id'    => $merchant->id,
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'category'       => $data['category'] ?? null,
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'min_value'      => $data['min_value'] ?? null,
            'start_date'     => $data['start_date'],
            'end_date'       => $data['end_date'],
            'total_quantity' => $data['total_quantity'] ?? null,
            'per_user_limit' => $data['per_user_limit'],
            'image_path'     => $imagePath,
            'status'         => $data['status'],
        ]);

        return redirect()->route('merchant.coupons.index')
            ->with('success', 'Cupom "' . $data['title'] . '" criado com sucesso!');
    }

    // ─── Editar ───────────────────────────────────────────────────────────────

    public function edit(Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);

        $stats = [
            'adicionados' => UserCoupon::where('coupon_id', $coupon->id)->count(),
            'usados'      => UserCoupon::where('coupon_id', $coupon->id)->where('status', 'used')->count(),
            'ativos'      => UserCoupon::where('coupon_id', $coupon->id)->where('status', 'active')->count(),
        ];

        return view('merchant.coupons.edit', compact('coupon', 'stats'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);

        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string|max:1000',
            'category'       => 'nullable|string|max:100',
            'discount_type'  => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0.01|max:999999',
            'min_value'      => 'nullable|numeric|min:0',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'total_quantity' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1|max:10',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ai_image_path'  => 'nullable|string|max:512',
            'status'         => 'required|in:active,inactive,expired',
        ], $this->messages());

        // Substitui imagem se enviada nova
        if ($request->hasFile('image')) {
            if ($coupon->image_path) {
                Storage::disk('public')->delete($coupon->image_path);
            }
            $data['image_path'] = $request->file('image')->store('coupons', 'public');
        } elseif ($request->filled('ai_image_path')) {
            // Imagem já salva pelo endpoint generateAiImage()
            $candidate = $request->input('ai_image_path');
            if (str_starts_with($candidate, 'coupons/') && Storage::disk('public')->exists($candidate)) {
                if ($coupon->image_path && $coupon->image_path !== $candidate) {
                    Storage::disk('public')->delete($coupon->image_path);
                }
                $data['image_path'] = $candidate;
            }
        }

        $coupon->update([
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'category'       => $data['category'] ?? null,
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'min_value'      => $data['min_value'] ?? null,
            'start_date'     => $data['start_date'],
            'end_date'       => $data['end_date'],
            'total_quantity' => $data['total_quantity'] ?? null,
            'per_user_limit' => $data['per_user_limit'],
            'image_path'     => $data['image_path'] ?? $coupon->image_path,
            'status'         => $data['status'],
        ]);

        return redirect()->route('merchant.coupons.index')
            ->with('success', 'Cupom "' . $coupon->title . '" atualizado com sucesso!');
    }

    // ─── Excluir ──────────────────────────────────────────────────────────────

    public function destroy(Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);

        // Não permite excluir se houver usuários com o cupom
        $totalVinculos = UserCoupon::where('coupon_id', $coupon->id)->count();
        if ($totalVinculos > 0) {
            return back()->with('error',
                'Não é possível excluir: ' . $totalVinculos . ' usuário(s) já adicionaram este cupom. Inative-o em vez disso.'
            );
        }

        if ($coupon->image_path) {
            Storage::disk('public')->delete($coupon->image_path);
        }

        $coupon->delete();

        return redirect()->route('merchant.coupons.index')
            ->with('success', 'Cupom excluído com sucesso.');
    }

    // ─── Geração de imagem via IA (Stable Horde — gratuito, anônimo) ───────────

    public function generateAiImage(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
            'title'  => 'nullable|string|max:255',
        ]);

        // Aumenta tempo limite do PHP para 3 minutos (geração pode levar ~30-60 s)
        set_time_limit(180);

        $apiBase  = 'https://stablehorde.net/api/v2';
        $apiKey   = '0000000000'; // chave anônima gratuita
        $headers  = ['apikey' => $apiKey, 'Accept' => 'application/json'];

        $fullPrompt = $request->input('prompt')
            . ', vibrant colorful gradient background, modern flat design, no text, no letters, bold shapes, high quality';

        // ── 1. Submete o job ────────────────────────────────────────────────
        $submitResp = Http::timeout(20)
            ->withHeaders($headers)
            ->post("{$apiBase}/generate/async", [
                'prompt' => $fullPrompt,
                'params' => ['width' => 512, 'height' => 512, 'steps' => 20, 'n' => 1],
            ]);

        if (! $submitResp->successful()) {
            return response()->json([
                'error' => 'Erro ao enviar pedido de geração: ' . $submitResp->body(),
            ], 502);
        }

        $jobId = $submitResp->json('id');
        if (! $jobId) {
            return response()->json(['error' => 'ID do job não retornado pela API.'], 502);
        }

        // ── 2. Aguarda conclusão (poll a cada 4 s, máx 100 s) ────────────────
        $done = false;
        for ($i = 0; $i < 25 && ! $done; $i++) {
            sleep(4);
            $checkResp = Http::timeout(10)->withHeaders($headers)
                ->get("{$apiBase}/generate/check/{$jobId}");
            $done = (bool) $checkResp->json('done');
        }

        if (! $done) {
            return response()->json([
                'error' => 'Tempo limite excedido aguardando geração. Tente novamente.',
            ], 504);
        }

        // ── 3. Busca resultado ────────────────────────────────────────────────
        $statusResp = Http::timeout(15)->withHeaders($headers)
            ->get("{$apiBase}/generate/status/{$jobId}");

        $imgUrl = $statusResp->json('generations.0.img');

        if (! $imgUrl) {
            return response()->json(['error' => 'Geração retornou sem imagem.'], 502);
        }

        // ── 4. Baixa a imagem do Cloudflare R2 e salva no storage ─────────────
        $imgResp = Http::timeout(30)->get($imgUrl);

        if (! $imgResp->successful()) {
            return response()->json(['error' => 'Erro ao baixar imagem gerada.'], 502);
        }

        $ct  = explode(';', $imgResp->header('Content-Type') ?? 'image/webp')[0];
        $ext = match ($ct) {
            'image/png'  => 'png',
            'image/webp' => 'webp',
            default      => 'jpg',
        };

        $filename = 'coupons/ai-' . uniqid() . '.' . $ext;
        Storage::disk('public')->put($filename, $imgResp->body());

        // ── 5. Overlays de texto com o título do cupom ────────────────────────
        $title = trim($request->input('title', ''));
        if ($title !== '') {
            $storagePath = storage_path('app/public/' . $filename);
            $this->addTextOverlay($storagePath, $title, $ext);
        }

        return response()->json([
            'path'     => $filename,
            'imageUrl' => asset('storage/' . $filename),
        ]);
    }

    /**
     * Sobrepõe o título em letras grandes e legíveis sobre a imagem gerada pela IA.
     * Usa uma faixa semitransparente no rodapé e texto branco centralizado.
     */
    private function addTextOverlay(string $path, string $title, string $ext): void
    {
        if (! extension_loaded('gd')) {
            return;
        }

        // Carrega a imagem conforme o formato
        $img = match ($ext) {
            'webp'  => @imagecreatefromwebp($path),
            'png'   => @imagecreatefrompng($path),
            default => @imagecreatefromjpeg($path),
        };

        if (! $img) {
            return;
        }

        $w = imagesx($img);
        $h = imagesy($img);

        // Escolhe fonte mais legível disponível
        $fontCandidates = [
            'C:/Windows/Fonts/arialbd.ttf',
            'C:/Windows/Fonts/calibrib.ttf',
            'C:/Windows/Fonts/verdanab.ttf',
            'C:/Windows/Fonts/arial.ttf',
        ];
        $font = null;
        foreach ($fontCandidates as $f) {
            if (file_exists($f)) { $font = $f; break; }
        }
        if (! $font) {
            imagedestroy($img);
            return;
        }

        // ── Quebra o título em linhas que cabem na largura da imagem ─────────
        $maxFontSize = max(22, (int) ($w * 0.065)); // ~6.5% da largura
        $minFontSize = 14;
        $margin      = (int) ($w * 0.05);
        $maxWidth    = $w - $margin * 2;
        $maxLines    = 3; // máximo de linhas para não cobrir demais a imagem

        $lines    = [];
        $fontSize = $maxFontSize;

        // Reduz tamanho até caber em até $maxLines linhas
        $words    = explode(' ', $title);
        $attempts = 0;

        while ($fontSize >= $minFontSize && $attempts < 40) {
            $lines   = [];
            $current = '';

            foreach ($words as $word) {
                $test = $current === '' ? $word : $current . ' ' . $word;
                $box  = imagettfbbox($fontSize, 0, $font, $test);
                $tw   = abs($box[2] - $box[0]);
                if ($tw > $maxWidth && $current !== '') {
                    $lines[]  = $current;
                    $current  = $word;
                } else {
                    $current  = $test;
                }
            }
            if ($current !== '') {
                $lines[] = $current;
            }

            // Verifica se cabe em maxLines e todas as linhas respeitam maxWidth
            $ok = count($lines) <= $maxLines;
            if ($ok) {
                foreach ($lines as $line) {
                    $box = imagettfbbox($fontSize, 0, $font, $line);
                    if (abs($box[2] - $box[0]) > $maxWidth) { $ok = false; break; }
                }
            }
            if ($ok) break;

            $fontSize -= 2;
            $attempts++;
        }

        // ── Altura da faixa de fundo ─────────────────────────────────────────
        $lineHeight  = (int) ($fontSize * 1.38);
        $paddingV    = (int) ($fontSize * 0.6);
        $bannerH     = count($lines) * $lineHeight + $paddingV * 2;
        // Limita a no máximo 38% da altura da imagem
        $bannerH     = min($bannerH, (int) ($h * 0.38));
        $bannerY     = $h - $bannerH;

        // ── Faixa semitransparente desenhada via blending direto ─────────────
        imagealphablending($img, true);
        $darkBar = imagecolorallocatealpha($img, 15, 15, 25, 55); // ~57% opacidade
        imagefilledrectangle($img, 0, $bannerY, $w - 1, $h - 1, $darkBar);

        // ── Escreve cada linha centralizada ──────────────────────────────────
        $white  = imagecolorallocate($img, 255, 255, 255);
        $shadow = imagecolorallocatealpha($img, 0, 0, 0, 70);

        $startY = $bannerY + $paddingV;

        foreach ($lines as $line) {
            $box    = imagettfbbox($fontSize, 0, $font, $line);
            $tw     = abs($box[2] - $box[0]);
            $x      = (int) (($w - $tw) / 2);
            $y      = $startY + $fontSize;

            // Sombra
            imagettftext($img, $fontSize, 0, $x + 2, $y + 2, $shadow, $font, $line);
            // Texto branco
            imagettftext($img, $fontSize, 0, $x, $y, $white, $font, $line);

            $startY += $lineHeight;
        }

        // ── Salva de volta no mesmo arquivo ──────────────────────────────────
        match ($ext) {
            'webp'  => imagewebp($img, $path, 90),
            'png'   => imagepng($img, $path),
            default => imagejpeg($img, $path, 90),
        };

        imagedestroy($img);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function authorizeOwnership(Coupon $coupon): void
    {
        abort_if($coupon->merchant_id !== $this->merchant()->id, 403, 'Acesso negado.');
    }

    private function messages(): array
    {
        return [
            'title.required'          => 'O título é obrigatório.',
            'discount_type.required'  => 'Selecione o tipo de desconto.',
            'discount_type.in'        => 'Tipo de desconto inválido.',
            'discount_value.required' => 'O valor do desconto é obrigatório.',
            'discount_value.min'      => 'O desconto deve ser maior que zero.',
            'start_date.required'     => 'A data de início é obrigatória.',
            'end_date.required'       => 'A data de término é obrigatória.',
            'end_date.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início.',
            'per_user_limit.required' => 'O limite por usuário é obrigatório.',
            'image.image'             => 'O arquivo deve ser uma imagem.',
            'image.max'               => 'A imagem deve ter no máximo 2 MB.',
            'status.required'         => 'Selecione o status.',
        ];
    }
}
