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
        --brand: #7c4dff;
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

      /* ---------- Header ---------- */
      header {
        position: sticky; top: 0; backdrop-filter: saturate(1.3) blur(8px);
        background: color-mix(in oklab, var(--bg) 85%, transparent); border-bottom: 1px solid rgba(255,255,255,.06);
        z-index: 50;
      }
      nav ul { list-style: none; display: flex; gap: 18px; padding: 0; margin: 0; align-items: center; }
      nav a { color: var(--muted); font-weight: 600; }
      nav a:hover { color: var(--text); }

      /* ---------- Contact ---------- */
      form { display: grid; gap: 12px; }
      input, textarea { width: 100%; padding: 12px 14px; border-radius: 12px; background: color-mix(in oklab, var(--panel) 92%, #000 10%); border: 1px solid rgba(255,255,255,.1); color: var(--text); }
      input:focus, textarea:focus { outline: 2px solid var(--ring); box-shadow: 0 0 0 4px color-mix(in oklab, var(--brand) 25%, transparent); }
      textarea { min-height: 120px; resize: vertical; }

      /* ---------- Footer ---------- */
      footer { color: var(--muted); border-top: 1px solid rgba(255,255,255,.06); padding: 24px 0 40px; }

    </style>
  </head>
  <body>
    @yield('content')
  </body>
</html>


