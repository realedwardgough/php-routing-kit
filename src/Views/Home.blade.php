@extends('example-layout')
@section('content')
   <!-- Hero -->
   <section class="hero">
   <div class="container hero-grid">
      <div>
         <div class="eyebrow"><span class="dot"></span><span>Launch faster with a beautiful baseline</span></div>
         <h1>Make something people love.</h1>
         <p class="lead">A crisp, responsive starter you can brand in minutes. Swap the colors, drop in your copy, and ship your next idea without wrestling CSS.</p>
         <div class="cta">
         <a href="#pricing" class="btn btn-primary">Start free</a>
         <a href="#features" class="btn btn-ghost">Explore features</a>
         </div>
      </div>
      <div class="mock" role="img" aria-label="Interface mockup with gradient accents"></div>
   </div>
   </section>

   <!-- Features -->
   <section id="features" class="section">
   <div class="container">
      <h2>Everything you need to start</h2>
      <p class="kicker">Opinionated defaults. Sensible structure. Delightful details.</p>
      <div class="grid">
         <article class="card">
         <div class="icon" aria-hidden="true">A</div>
         <h3>Accessible</h3>
         <p>Semantic HTML, clear contrast, and keyboard-friendly controls from the start.</p>
         </article>
         <article class="card">
         <div class="icon" aria-hidden="true">R</div>
         <h3>Responsive</h3>
         <p>Mobile-first layout with fluid type and spacing that scales across devices.</p>
         </article>
         <article class="card">
         <div class="icon" aria-hidden="true">F</div>
         <h3>Fast</h3>
         <p>Zero-dependency, single-file template that paints quickly and feels snappy.</p>
         </article>
      </div>
   </div>
   </section>

   <!-- Showcase -->
   <section class="section">
   <div class="container showcase">
      <div class="shot" role="img" aria-label="Product screenshot placeholder"></div>
      <div class="copy">
         <h2>Drop in your screenshots</h2>
         <p>Replace the gradient blocks with real product shots. The cards and layout are designed to make anything you add look tidy with minimal effort.</p>
         <div class="cta">
         <a href="#" class="btn btn-primary">See it in action</a>
         <a href="#contact" class="btn btn-ghost">Talk to us</a>
         </div>
      </div>
   </div>
   </section>

   <!-- Pricing -->
   <section id="pricing" class="section">
   <div class="container">
      <h2>Simple pricing</h2>
      <p class="kicker">Start free. Upgrade when you grow.</p>
      <div class="pricing">
         <article class="price-card">
         <h3>Starter</h3>
         <div class="price">£0<span class="muted">/mo</span></div>
         <ul class="features">
            <li>Basic components</li>
            <li>Email support</li>
            <li>Community access</li>
         </ul>
         <a class="btn btn-ghost" href="#">Try free</a>
         </article>

         <article class="price-card" aria-label="Most popular plan" style="transform: scale(1.02); border-color: color-mix(in oklab, var(--brand) 30%, white 0%);">
         <h3>Pro <span class="pill">Popular</span></h3>
         <div class="price">£14<span class="muted">/mo</span></div>
         <ul class="features">
            <li>Everything in Starter</li>
            <li>Advanced components</li>
            <li>Priority support</li>
         </ul>
         <a class="btn btn-primary" href="#">Go Pro</a>
         </article>

         <article class="price-card">
         <h3>Team</h3>
         <div class="price">£49<span class="muted">/mo</span></div>
         <ul class="features">
            <li>Everything in Pro</li>
            <li>Unlimited collaborators</li>
            <li>SSO & permissions</li>
         </ul>
         <a class="btn btn-ghost" href="#">Contact sales</a>
         </article>
      </div>
   </div>
   </section>

   <!-- CTA band -->
   <section class="section">
   <div class="container">
      <div class="cta-band">
         <h2>Ready to ship something great?</h2>
         <p class="muted">Swap the name, tweak the colors, and you have a polished landing page in minutes.</p>
         <div class="cta" style="justify-content:center;">
         <a class="btn btn-primary" href="#contact">Get started</a>
         </div>
      </div>
   </div>
   </section>

   <!-- Contact -->
   <section id="contact" class="section">
   <div class="container">
      <h2>Contact</h2>
      <p class="kicker">Drop us a line and we'll get back to you.</p>
      <form action="#" method="post" aria-label="Contact form">
         <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
         <label>
            <span class="muted">Name</span>
            <input name="name" autocomplete="name" required />
         </label>
         <label>
            <span class="muted">Email</span>
            <input type="email" name="email" autocomplete="email" required />
         </label>
         </div>
         <label>
         <span class="muted">Message</span>
         <textarea name="message" required></textarea>
         </label>
         <div>
         <button class="btn btn-primary" type="submit">Send message</button>
         </div>
      </form>
   </div>
   </section>
@endsection