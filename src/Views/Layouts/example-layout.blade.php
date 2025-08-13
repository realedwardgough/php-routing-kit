<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PHP Routing Kit Layout 1</title>
    <meta name="description" content="" />

    <style>
      /* ---------- Design tokens ---------- */
      :root {
        --bg: #0b0d12;
        --panel: #111521;
        --muted: #8a93a6;
        --text: #e7ecf3;
        --brand: #7c4dff; /* tweak this to change accent */
        --brand-2: #4dd0e1;
        --ring: color-mix(in oklab, var(--brand) 50%, white 10%);
        --radius: 16px;
        --shadow: 0 10px 30px rgba(0,0,0,.35), 0 2px 8px rgba(0,0,0,.25);
        --container: 1120px;
      }

      @media (prefers-color-scheme: light) {
        :root { --bg: #f8fbff; --panel: #ffffff; --text: #101218; --muted: #5a6473; }
        body { background: linear-gradient(180deg, #eef3ff 0%, #ffffff 40%); }
      }

      * { box-sizing: border-box; }
      html, body { height: 100%; }
      body {
        margin: 0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Inter, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji";
        color: var(--text); background: radial-gradient(60vw 60vw at 10% -10%, rgba(124,77,255,.2), transparent 60%),
                    radial-gradient(60vw 60vw at 100% 10%, rgba(77,208,225,.15), transparent 60%), var(--bg);
        line-height: 1.6;
      }

      .container { max-width: var(--container); margin-inline: auto; padding-inline: clamp(16px, 4vw, 28px); }

      a { color: inherit; text-decoration: none; }
      img { max-width: 100%; height: auto; display: block; }
      .btn { appearance: none; border: 0; padding: 12px 18px; border-radius: 999px; font-weight: 600; cursor: pointer; }
      .btn-primary { background: linear-gradient(135deg, var(--brand), var(--brand-2)); color: white; box-shadow: var(--shadow); }
      .btn-ghost { background: transparent; color: var(--text); outline: 2px solid color-mix(in oklab, var(--brand) 45%, transparent); }
      .btn:hover { transform: translateY(-1px); }
      .btn:active { transform: translateY(0); }

      /* ---------- Header ---------- */
      header {
        position: sticky; top: 0; backdrop-filter: saturate(1.3) blur(8px);
        background: color-mix(in oklab, var(--bg) 85%, transparent); border-bottom: 1px solid rgba(255,255,255,.06);
        z-index: 50;
      }
      .nav { display: flex; align-items: center; justify-content: space-between; gap: 16px; height: 72px; }
      .brand { display: inline-flex; align-items: center; gap: 10px; font-weight: 800; letter-spacing: .3px; }
      .logo {
        width: 36px; height: 36px; border-radius: 10px; background: conic-gradient(from 210deg, var(--brand), var(--brand-2));
        box-shadow: inset 0 0 0 3px rgba(255,255,255,.12), 0 6px 16px rgba(0,0,0,.25);
      }
      nav ul { list-style: none; display: flex; gap: 18px; padding: 0; margin: 0; align-items: center; }
      nav a { color: var(--muted); font-weight: 600; }
      nav a:hover { color: var(--text); }

      /* ---------- Hero ---------- */
      .hero { position: relative; padding: clamp(48px, 9vw, 100px) 0; }
      .hero-grid { display: grid; grid-template-columns: 1.2fr .8fr; gap: clamp(24px, 6vw, 56px); align-items: center; }
      .eyebrow { display:inline-flex; align-items:center; gap:8px; font-size: 12px; letter-spacing:.6px; text-transform: uppercase; color: var(--muted); }
      .eyebrow .dot { width: 6px; height: 6px; border-radius: 999px; background: var(--brand-2); box-shadow: 0 0 0 3px rgba(77,208,225,.15); }
      h1 { font-size: clamp(28px, 5vw, 56px); line-height: 1.1; margin: 10px 0 16px; }
      .lead { font-size: clamp(16px, 1.7vw, 18px); color: var(--muted); max-width: 60ch; }
      .cta { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 22px; }

      .mock { aspect-ratio: 4/3; border-radius: var(--radius); background:
          linear-gradient(180deg, rgba(255,255,255,.06), rgba(0,0,0,.06)),
          radial-gradient(400px 180px at 100% 0, rgba(124,77,255,.25), transparent),
          radial-gradient(400px 180px at 0% 100%, rgba(77,208,225,.25), transparent),
          var(--panel);
        border: 1px solid rgba(255,255,255,.07); box-shadow: var(--shadow); position: relative; overflow: hidden;
      }
      .mock::after {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(120deg, rgba(255,255,255,.2) 0%, transparent 20%, transparent 80%, rgba(255,255,255,.2) 100%);
        mask: linear-gradient(#000, transparent 30%);
        pointer-events: none;
      }

      /* ---------- Feature grid ---------- */
      .section { padding: clamp(44px, 7vw, 84px) 0; }
      .section h2 { font-size: clamp(22px, 3.4vw, 36px); margin: 0 0 14px; }
      .kicker { color: var(--muted); margin-bottom: 28px; }
      .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(16px, 3vw, 24px); }
      .card { background: var(--panel); border: 1px solid rgba(255,255,255,.07); border-radius: var(--radius); box-shadow: var(--shadow); padding: 20px; }
      .icon { width: 42px; height: 42px; border-radius: 12px; display: grid; place-items: center; background: linear-gradient(135deg, var(--brand), var(--brand-2)); font-weight: 800; }
      .card h3 { margin: 12px 0 8px; font-size: 18px; }
      .card p { margin: 0; color: var(--muted); }

      /* ---------- Showcase ---------- */
      .showcase { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(16px, 4vw, 36px); align-items: center; }
      .showcase .shot { border-radius: var(--radius); border: 1px solid rgba(255,255,255,.08); box-shadow: var(--shadow); aspect-ratio: 16/10; background: linear-gradient(140deg, rgba(124,77,255,.3), rgba(77,208,225,.3)); }
      .showcase .copy p { color: var(--muted); }

      /* ---------- Pricing ---------- */
      .pricing { display: grid; grid-template-columns: repeat(3, 1fr); gap: clamp(16px, 3vw, 24px); align-items: stretch; }
      .price-card { background: var(--panel); border: 1px solid rgba(255,255,255,.08); border-radius: var(--radius); box-shadow: var(--shadow); padding: 24px; display: grid; gap: 10px; }
      .price { font-size: 32px; font-weight: 800; }
      .strike { color: var(--muted); text-decoration: line-through; font-weight: 500; font-size: 14px; }
      .features { margin: 10px 0 4px; padding: 0 0 0 18px; color: var(--muted); }

      /* ---------- CTA band ---------- */
      .cta-band { background: linear-gradient(120deg, color-mix(in oklab, var(--brand) 50%, #000 20%), color-mix(in oklab, var(--brand-2) 45%, #000 10%)); border-radius: calc(var(--radius) + 6px);
        padding: clamp(20px, 4vw, 28px); box-shadow: var(--shadow); border: 1px solid rgba(255,255,255,.08); display: grid; gap: 10px; text-align: center; }

      /* ---------- Contact ---------- */
      form { display: grid; gap: 12px; }
      input, textarea { width: 100%; padding: 12px 14px; border-radius: 12px; background: color-mix(in oklab, var(--panel) 92%, #000 10%); border: 1px solid rgba(255,255,255,.1); color: var(--text); }
      input:focus, textarea:focus { outline: 2px solid var(--ring); box-shadow: 0 0 0 4px color-mix(in oklab, var(--brand) 25%, transparent); }
      textarea { min-height: 120px; resize: vertical; }

      /* ---------- Footer ---------- */
      footer { color: var(--muted); border-top: 1px solid rgba(255,255,255,.06); padding: 24px 0 40px; }

      /* ---------- Utilities ---------- */
      .muted { color: var(--muted); }
      .center { text-align: center; }
      .pill { padding: 6px 10px; border-radius: 999px; background: color-mix(in oklab, var(--panel) 85%, transparent); border: 1px solid rgba(255,255,255,.1); font-weight: 700; font-size: 12px; letter-spacing: .4px; }

      /* ---------- Responsiveness ---------- */
      @media (max-width: 900px) {
        .hero-grid, .showcase { grid-template-columns: 1fr; }
        .grid, .pricing { grid-template-columns: 1fr; }
        .nav ul { display: none; }
      }
    </style>
  </head>
  <body>
    <!-- Header -->
    <header>
      <div class="container nav" role="navigation" aria-label="Main">
        <a class="brand" href="#" aria-label="Nova Home">
          <span class="logo" aria-hidden="true"></span>
          <span>Nova</span>
        </a>
        <nav>
          <ul>
            <li><a href="#features">Features</a></li>
            <li><a href="#pricing">Pricing</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a class="pill" href="#">Get Started</a></li>
          </ul>
        </nav>
      </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer>
      <div class="container">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
          <small>© <span id="y"></span> Nova. All rights reserved.</small>
          <div class="muted" style="display:flex; gap:14px;">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Changelog</a>
          </div>
        </div>
      </div>
    </footer>

    <script>
      // tiny enhancement: current year
      document.getElementById('y').textContent = new Date().getFullYear();
    </script>

  </body>
</html>
