{{-- Comentario Nova Tech: Arquivo resources/views/loja.blade.php. Origem: Views publicas e da loja. Conteudo: Monta uma tela principal do site usando Blade, HTML e estilos da interface. --}}
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja {{ config('app.name', 'Nova Tech') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|inter:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
<style>
    :root {
    --bg: #09090b;
    --surface: #111113;
    --surface2: #18181b;
    --border: #27272a;
    --border-hi: #7e0a85;
    --purple: #7e0a85;
    --purple-lo: rgba(126,10,133,0.12);
    --text: #ffffff;
    --muted: #71717a;
    --accent: #a78bfa;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background: var(--bg);
    color: var(--text);
    font-family:'Inter',sans-serif;
    min-height:100vh;
}

/* HEADER */

header{
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(9,9,11,.92);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
}

.header-inner{
    max-width: 1600px;
    margin: 0 auto;
    height: 72px;
    padding: 0 2rem;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    text-decoration:none;
}

nav{
    display:flex;
    gap:2rem;
}

nav a{
    color:#a1a1aa;
    text-decoration:none;
    font-size:14px;
    font-weight:500;
    transition:.2s;
}

nav a:hover{ color:white; }
nav a.active{ color: var(--accent); }

/* =========================
   STORE LAYOUT
========================= */

.store-wrapper{
    max-width: 1600px;
    margin: 0 auto;
    padding: 2rem;
    flex: 1;
}

.store-title{
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.store-title h1{
    font-size: 2.2rem;
    font-weight: 700;
}

.store-title h1 span{ color: var(--accent); }

.store-title p{
    color: var(--muted);
    margin-top: 6px;
    font-size: 14px;
}

.store-title-meta{
    min-height: 34px;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(126,10,133,.3);
    border-radius: 999px;
    background: rgba(126,10,133,.1);
    color: #c4b5fd;
    padding: 0 .85rem;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .06em;
}

/* =========================
   FILTERS  (compacto)
========================= */

.filter-panel{
    margin-bottom: 1.5rem;
    padding: .85rem 1rem;
    border: 1px solid var(--border);
    border-radius: 14px;
    background:
        linear-gradient(135deg, rgba(126,10,133,.10), transparent 42%),
        #111113;
    box-shadow: 0 10px 28px rgba(0,0,0,.18);
}

.filter-form{
    display: grid;
    grid-template-columns: minmax(150px, 1fr) minmax(150px, 1fr) auto auto;
    gap: .75rem;
    align-items: end;
}

.filter-field{
    display: grid;
    gap: .35rem;
}

.filter-field label{
    color: #a1a1aa;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.filter-field select{
    width: 100%;
    min-height: 38px;
    border: 1px solid #2f2f35;
    border-radius: 10px;
    outline: 0;
    background: #0c0c0f;
    color: #fff;
    padding: 0 .75rem;
    font: inherit;
    font-size: 13px;
    cursor: pointer;
    transition: .2s ease;
}

.filter-field select:focus{
    border-color: rgba(167,139,250,.78);
    box-shadow: 0 0 0 3px rgba(126,10,133,.14);
}

.filter-button,
.filter-clear{
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    border-radius: 10px;
    padding: 0 .9rem;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    transition: .2s ease;
}

.filter-button{
    border: 0;
    background: linear-gradient(135deg, #7e0a85, #5c0760);
    color: #fff;
}

.filter-button:hover,
.filter-clear:hover{ transform: translateY(-1px); }

.filter-clear{
    border: 1px solid #3f3f46;
    background: transparent;
    color: #a1a1aa;
}

.filter-clear:hover{
    border-color: #7e0a85;
    color: #fff;
}

.active-filters{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .4rem;
    margin-top: .65rem;
}

.filter-chip{
    min-height: 26px;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(167,139,250,.3);
    border-radius: 999px;
    background: rgba(126,10,133,.11);
    color: #ddd6fe;
    padding: 0 .65rem;
    font-size: 11px;
    font-weight: 700;
}

/* =========================
   BRANDS GRID
========================= */

.brands-grid{
    display: flex;
    gap: 24px;
    overflow-x: auto;
    padding-bottom: 10px;
    justify-content: center;
}

.brands-grid::-webkit-scrollbar{ height: 5px; }
.brands-grid::-webkit-scrollbar-thumb{
    background: var(--purple);
    border-radius: 999px;
}

/* =========================
   BRAND COLUMN
========================= */

.brand-col{
    min-width: 320px;
    width: 320px;
    height: 78vh;
    background: linear-gradient(180deg, #111113 0%, #0d0d0f 100%);
    border: 1px solid #232326;
    border-radius: 24px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.03),
        0 10px 40px rgba(0,0,0,.35);
}

/* =========================
   BRAND HEADER
========================= */

.brand-header{
    padding: 20px;
    border-bottom: 1px solid #1f1f22;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.brand-name{
    font-size: 15px;
    letter-spacing: .18em;
    font-weight: 700;
    color: var(--accent);
}

.brand-count{
    width: 28px;
    height: 28px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #16161a;
    border: 1px solid #2c2c31;
    color: #a1a1aa;
    font-size: 11px;
}

/* =========================
   PRODUCT LIST
========================= */

.product-list-inner{
    overflow-y: auto;
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.product-list-inner::-webkit-scrollbar{ width: 4px; }
.product-list-inner::-webkit-scrollbar-thumb{
    background: var(--purple);
    border-radius: 999px;
}

/* =========================
   PRODUCT CARD
========================= */

.product-card{
    background: #141418;
    border: 1px solid #232329;
    border-radius: 18px;
    padding: 16px;
    transition: .25s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 370px;
}

.product-card:hover{
    transform: translateY(-4px);
    border-color: rgba(126,10,133,.6);
    box-shadow:
        0 0 0 1px rgba(126,10,133,.15),
        0 15px 40px rgba(126,10,133,.18);
}

/* =========================
   IMAGE
========================= */

.card-img-link{
    width: 100%;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0c0c0f;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 16px;
}

.card-img-link img{
    max-width: 90%;
    max-height: 180px;
    object-fit: contain;
    transition: .35s ease;
}

.product-card:hover img{ transform: scale(1.06); }

/* =========================
   CARD BODY
========================= */

.card-body{
    width: 100%;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.card-name-link{ text-decoration: none; }

.card-name{
    font-size: 14px;
    line-height: 1.5;
    color: #f4f4f5;
    font-weight: 600;
    min-height: 44px;
}

.card-price{
    margin-top: 12px;
    font-size: 22px;
    font-weight: 700;
    color: #fff;
}

.card-price small{
    display: block;
    margin-top: 3px;
    font-size: 11px;
    color: #71717a;
}

.btn-add{
    margin-top: auto;
    width: 100%;
    height: 44px;
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #7e0a85, #5c0760);
    color: white;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: .25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.btn-add:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(126,10,133,.35);
}

/* =========================
   FOOTER
========================= */

.store-footer{
    margin-top: 3rem;
    padding: 3rem 0 1.5rem;
    background: #111113;
    border-top: 1px solid var(--border);
}

.store-footer-inner{
    width: min(1200px, calc(100% - 32px));
    margin: 0 auto;
}

.store-footer-grid{
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 2.5rem;
    margin-bottom: 2.25rem;
}

.store-footer-logo img{
    width: 180px;
    max-height: 72px;
    border-radius: 6px;
    object-fit: contain;
}

.store-footer-brand p{
    max-width: 300px;
    margin-top: .8rem;
    color: #71717a;
    font-size: .88rem;
    line-height: 1.65;
}

.store-footer-col h4{
    margin-bottom: 1rem;
    color: #a1a1aa;
    font-size: .78rem;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.store-footer-col ul{ list-style: none; }
.store-footer-col li{ margin-bottom: .55rem; }
.store-footer-col a{
    color: #71717a;
    font-size: .88rem;
    text-decoration: none;
    transition: .2s ease;
}
.store-footer-col a:hover{ color: #fff; }

.store-footer-bottom{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
    color: #71717a;
    font-size: .86rem;
}

.store-footer-payment{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .5rem;
}

.payment-badge{
    display: inline-flex;
    align-items: center;
    min-height: 24px;
    padding: 0 .55rem;
    border: 1px solid var(--border);
    border-radius: 4px;
    background: #18181b;
    color: #fff;
    font-size: .7rem;
    font-weight: 800;
}

/* =========================
   RESPONSIVO
========================= */

@media(max-width: 768px){
    .store-wrapper{ padding: 1rem; }
    .brand-col{ min-width: 280px; width: 280px; }
    .product-card{ min-height: 340px; }
    .card-img-link{ height: 180px; }
    .store-footer-grid{ grid-template-columns: 1fr 1fr; }
    .filter-form{ grid-template-columns: 1fr; }
}

@media(max-width: 560px){
    .store-footer-grid{ grid-template-columns: 1fr; gap: 1.5rem; }
    .store-footer-bottom{ align-items: flex-start; flex-direction: column; }
    .store-title{ align-items: flex-start; }
}
</style>
</head>
<body>

    @if(session('success'))
        <div class="flash"><span class="check">✓</span> {{ session('success') }}</div>
    @endif

    <x-site-header active="loja" />

    <div class="store-wrapper">
        <div class="store-title">
            <div class="store-title-meta">
                {{ $productsByBrand->flatten(1)->count() }} {{ $productsByBrand->flatten(1)->count() === 1 ? 'produto' : 'produtos' }}
            </div>
        </div>

        <section class="filter-panel" aria-label="Filtros da loja">
            <form class="filter-form" method="GET" action="{{ route('loja') }}">
                <div class="filter-field">
                    <label for="brand">Marca</label>
                    <select id="brand" name="brand">
                        <option value="">Todas as marcas</option>
                        @foreach($brands as $brandOption)
                            <option value="{{ $brandOption }}" @selected($selectedBrand === $brandOption)>
                                {{ $brandOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-field">
                    <label for="price_range">Faixa de preço</label>
                    <select id="price_range" name="price_range">
                        <option value="">Todos os preços</option>
                        <option value="0-1500" @selected($selectedPriceRange === '0-1500')>Até R$ 1.500</option>
                        <option value="1500-3000" @selected($selectedPriceRange === '1500-3000')>R$ 1.500 a R$ 3.000</option>
                        <option value="3000-5000" @selected($selectedPriceRange === '3000-5000')>R$ 3.000 a R$ 5.000</option>
                        <option value="5000-plus" @selected($selectedPriceRange === '5000-plus')>Acima de R$ 5.000</option>
                    </select>
                </div>

                <button class="filter-button" type="submit">
                    Filtrar
                </button>

                <a class="filter-clear" href="{{ route('loja') }}">
                    Limpar
                </a>
            </form>

            @if($selectedBrand || $selectedPriceRange)
                <div class="active-filters" aria-label="Filtros ativos">
                    @if($selectedBrand)
                        <span class="filter-chip">Marca: {{ $selectedBrand }}</span>
                    @endif
                    @if($selectedPriceRange)
                        <span class="filter-chip">
                            Preço:
                            @switch($selectedPriceRange)
                                @case('0-1500') até R$ 1.500 @break
                                @case('1500-3000') R$ 1.500 a R$ 3.000 @break
                                @case('3000-5000') R$ 3.000 a R$ 5.000 @break
                                @case('5000-plus') acima de R$ 5.000 @break
                            @endswitch
                        </span>
                    @endif
                </div>
            @endif
        </section>

        @if(isset($productsByBrand) && $productsByBrand->isNotEmpty())
            <div class="brands-grid">
                @foreach($productsByBrand as $brand => $products)
                <div class="brand-col">
                    <div class="brand-header">
                        <span class="brand-name">{{ $brand }}</span>
                        <span class="brand-count">{{ $products->count() }}</span>
                    </div>
                    <div class="product-list-inner">
                        @foreach($products as $product)
                        <div class="product-card">
                            <a href="{{ route('product.show', $product->id) }}" class="card-img-link">
                                @if($product->image)
                                    @if(str_starts_with($product->image, 'http'))
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @endif
                                @else
                                    <svg width="40" height="40" fill="none" stroke="#3f3f46" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                @endif
                            </a>
                            <div class="card-body">
                                <a href="{{ route('product.show', $product->id) }}" class="card-name-link">
                                    <div class="card-name">{{ $product->name }}</div>
                                </a>
                                <div class="card-price">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                    <small>ou 12x no cartão</small>
                                </div>
                                @auth
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-add">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                            Adicionar ao Carrinho
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn-add">Entrar para comprar</a>
                                @endauth
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="56" height="56" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#3f3f46;margin:0 auto 1rem;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                @if($selectedBrand || $selectedPriceRange)
                    <p>Não encontramos produtos para os filtros selecionados.</p>
                    <a class="filter-clear" href="{{ route('loja') }}" style="margin-top:1rem;">Limpar filtros</a>
                @else
                    <h3>Nenhum produto cadastrado</h3>
                    <p>Os produtos aparecerao aqui assim que forem adicionados pelo administrador.</p>
                @endif
            </div>
        @endif
    </div>

    <footer class="store-footer">
        <div class="store-footer-inner">
            <div class="store-footer-grid">
                <div class="store-footer-brand">
                    <a class="store-footer-logo" href="{{ route('home', Auth::check() ? ['site' => 1] : []) }}" aria-label="Nova Tech">
                        <img src="{{ asset('images/nova-tech-logo.png') }}" alt="Nova Tech">
                    </a>
                    <p>Os melhores celulares do mercado com atendimento, garantia e compra segura.</p>
                </div>

                <div class="store-footer-col">
                    <h4>Produtos</h4>
                    <ul>
                        <li><a href="{{ route('loja') }}?brand=Apple">iPhone</a></li>
                        <li><a href="{{ route('loja') }}?brand=Samsung">Samsung Galaxy</a></li>
                        <li><a href="{{ route('loja') }}?brand=Xiaomi">Xiaomi</a></li>
                    </ul>
                </div>

                <div class="store-footer-col">
                    <h4>Conta</h4>
                    <ul>
                        @auth
                            <li><a href="{{ route('profile.edit') }}">Editar Perfil</a></li>
                            <li><a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('orders.index') }}">{{ Auth::user()->role === 'admin' ? 'Painel Admin' : 'Meus Pedidos' }}</a></li>
                            <li><a href="{{ route('cart.index') }}">Carrinho</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Entrar</a></li>
                            <li><a href="{{ route('register') }}">Criar Conta</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="store-footer-col">
                    <h4>Suporte</h4>
                    <ul>
                        <li><a href="{{ route('support') }}">Central de Ajuda</a></li>
                        <li><a href="{{ route('support') }}#politica-troca">Politica de Troca</a></li>
                        <li><a href="{{ route('support') }}#garantia">Garantia</a></li>
                        <li><a href="{{ route('support') }}#fale-conosco">Fale Conosco</a></li>
                    </ul>
                </div>
            </div>

            <div class="store-footer-bottom">
                <p>{{ date('Y') }} Nova Tech. Todos os direitos reservados.</p>
                <div class="store-footer-payment">
                    <span>Pagamentos seguros:</span>
                    <span class="payment-badge">PIX</span>
                    <span class="payment-badge">VISA</span>
                    <span class="payment-badge">MASTER</span>
                    <span class="payment-badge">ELO</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        setTimeout(() => { const f = document.querySelector('.flash'); if (f) f.style.display = 'none'; }, 4000);
    </script>
</body>
</html>
