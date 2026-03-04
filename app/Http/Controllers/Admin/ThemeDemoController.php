<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ThemeDemoController extends Controller
{
    public function home()
    {
        return view('theme.pages.home', $this->baseData());
    }

    public function login()
    {
        return view('theme.pages.auth.login');
    }

    public function register()
    {
        return view('theme.pages.auth.register');
    }

    public function forgot()
    {
        return view('theme.pages.auth.forgot-password');
    }

    public function dashboard()
    {
        return view('theme.pages.dashboard', $this->baseData());
    }

    public function items()
    {
        return view('theme.pages.items.index', $this->baseData());
    }

    public function forms()
    {
        return view('theme.pages.forms.complex');
    }

    public function profile()
    {
        return view('theme.pages.profile', $this->baseData());
    }

    public function adminTable()
    {
        return view('theme.pages.admin.table', $this->baseData());
    }

    public function error404()
    {
        return view('theme.pages.errors.404');
    }

    public function error500()
    {
        return view('theme.pages.errors.500');
    }

    public function emptyState()
    {
        return view('theme.pages.empty-state');
    }

    public function mobile()
    {
        return view('theme.pages.mobile-preview');
    }

    private function baseData(): array
    {
        return [
            'stats' => [
                'companies' => '120+',
                'growth' => '+18%',
                'tickets' => '2,4k',
            ],
            'features' => [
                [
                    'icon' => 'chart',
                    'title' => 'Insights em tempo real',
                    'description' => 'Dashboards prontos para decisões rápidas.',
                ],
                [
                    'icon' => 'users',
                    'title' => 'Times conectados',
                    'description' => 'Fluxos claros com responsabilidades definidas.',
                ],
                [
                    'icon' => 'lock',
                    'title' => 'Segurança corporativa',
                    'description' => 'Controle de acessos e auditoria simplificada.',
                ],
                [
                    'icon' => 'mail',
                    'title' => 'Alertas inteligentes',
                    'description' => 'Notificações que reduzem retrabalho.',
                ],
                [
                    'icon' => 'settings',
                    'title' => 'Automação flexível',
                    'description' => 'Regras prontas para cada etapa do processo.',
                ],
                [
                    'icon' => 'spark',
                    'title' => 'Experiência fluida',
                    'description' => 'Interface responsiva com foco em produtividade.',
                ],
            ],
            'metrics' => [
                ['title' => 'Receita recorrente', 'value' => 'R$ 248k', 'trend' => '+12%'],
                ['title' => 'Novos contratos', 'value' => '86', 'trend' => '+8%'],
                ['title' => 'Satisfação', 'value' => '94%', 'trend' => '+3%'],
                ['title' => 'Tickets resolvidos', 'value' => '1.240', 'trend' => '+21%'],
            ],
            'chart' => [
                ['label' => 'S1', 'value' => 35],
                ['label' => 'S2', 'value' => 52],
                ['label' => 'S3', 'value' => 44],
                ['label' => 'S4', 'value' => 68],
                ['label' => 'S5', 'value' => 58],
                ['label' => 'S6', 'value' => 72],
                ['label' => 'S7', 'value' => 63],
                ['label' => 'S8', 'value' => 80],
            ],
            'activities' => [
                ['title' => 'Relatório financeiro enviado', 'time' => 'há 2 horas', 'status' => 'Concluído', 'variant' => 'success'],
                ['title' => 'Revisão de metas trimestrais', 'time' => 'há 4 horas', 'status' => 'Em revisão', 'variant' => 'warning'],
                ['title' => 'Novo contrato aprovado', 'time' => 'ontem', 'status' => 'Aprovado', 'variant' => 'info'],
            ],
            'items' => [
                ['name' => 'Projeto Nimbus', 'detail' => 'Entrega semanal', 'owner' => 'Equipe Alfa', 'status' => 'Ativo', 'variant' => 'success'],
                ['name' => 'Operação Atlas', 'detail' => 'Plano Q2', 'owner' => 'Equipe Beta', 'status' => 'Pausado', 'variant' => 'warning'],
                ['name' => 'Campanha Boreal', 'detail' => 'Marketing regional', 'owner' => 'Equipe Gama', 'status' => 'Ativo', 'variant' => 'success'],
                ['name' => 'Auditoria Sigma', 'detail' => 'Compliance', 'owner' => 'Equipe Delta', 'status' => 'Em revisão', 'variant' => 'info'],
            ],
            'users' => [
                ['name' => 'Camila Lopes', 'email' => 'camila@aurora.com', 'role' => 'Admin', 'status' => 'Ativo', 'variant' => 'success'],
                ['name' => 'Rafael Dias', 'email' => 'rafael@aurora.com', 'role' => 'Analista', 'status' => 'Em revisão', 'variant' => 'warning'],
                ['name' => 'Lina Souza', 'email' => 'lina@aurora.com', 'role' => 'Gestora', 'status' => 'Ativo', 'variant' => 'success'],
                ['name' => 'João Mendes', 'email' => 'joao@aurora.com', 'role' => 'Financeiro', 'status' => 'Suspenso', 'variant' => 'error'],
            ],
            'profile' => [
                'name' => 'Clara Nogueira',
                'role' => 'Head de Operações',
                'status' => 'Ativo',
                'plan' => 'Enterprise',
                'email' => 'clara@aurora.com',
                'phone' => '(11) 98888-1234',
                'location' => 'São Paulo, SP',
                'team' => 'Operações',
            ],
        ];
    }
}
