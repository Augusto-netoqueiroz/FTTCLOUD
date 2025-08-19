
<?php if(auth()->check() && $config): ?>
  <script src="https://cdn.jsdelivr.net/npm/sip.js@0.11.6/dist/sip.min.js"></script>

  <style>
    /* Tema: base LIGHT, override quando html tiver .dark */
    :root{
      --sp-bg:#ffffff; --sp-bg-2:#f8fafc; --sp-line:#e5e7eb; --sp-txt:#0f172a; --sp-muted:#6b7280;
      --sp-acc:#3b82f6; --sp-ok:#10b981; --sp-err:#ef4444; --sp-warn:#f59e0b; --sp-surface:#f1f5f9;
      --sp-wave-bg:#f3f4f6; --sp-wave-stroke:#3b82f6;
    }
    html.dark :root, .dark :root{
      --sp-bg:#0f172a; --sp-bg-2:#0b1220; --sp-line:#1e293b; --sp-txt:#e6edf6; --sp-muted:#9aa6b2;
      --sp-acc:#3b82f6; --sp-ok:#10b981; --sp-err:#ef4444; --sp-warn:#f59e0b; --sp-surface:#0d172c;
      --sp-wave-bg:#0b1427; --sp-wave-stroke:#60a5fa;
    }

    /* Botão da topbar */
    .sp-trigger{
      position:relative; width:34px; height:34px; border-radius:9px; display:inline-flex;
      align-items:center; justify-content:center; border:1px solid var(--sp-line);
      background:transparent; color:inherit; cursor:pointer; transition:background .15s, transform .06s;
    }
    .sp-trigger:hover{ background:rgba(148,163,184,.15); }
    .sp-trigger:active{ transform:translateY(1px); }
    .sp-dot{
      position:absolute; right:-2px; top:-2px; width:9px; height:9px; border-radius:999px;
      border:2px solid var(--sp-bg-2); background:#94a3b8;
    }
    .sp-dot.online{ background:var(--sp-ok); }
    .sp-dot.registered{ background:var(--sp-acc); }
    .sp-dot.offline{ background:var(--sp-err); }
    .sp-dot.error{ background:var(--sp-warn); }

    /* Painel super compacto e arrastável */
    .sp-panel{
      position:fixed; z-index:10000; width:236px; max-width:calc(100vw - 24px);
      background:var(--sp-bg); color:var(--sp-txt); border:1px solid var(--sp-line);
      border-radius:12px; box-shadow:0 14px 34px rgba(0,0,0,.25);
      transform:translate3d(0,8px,0); opacity:0; pointer-events:none; transition:opacity .16s, transform .16s;
      will-change:transform; /* para arrasto suave */
    }
    .sp-panel.show{ transform:translate3d(0,0,0); opacity:1; pointer-events:auto; }
    .sp-hd{
      display:flex; align-items:center; justify-content:space-between; gap:6px;
      padding:6px 8px; background:var(--sp-bg-2); border-bottom:1px solid var(--sp-line);
      border-radius:12px 12px 0 0; user-select:none; cursor:grab;
      touch-action:none; /* evita bounce em mobile ao arrastar */
    }
    .sp-hd:active{ cursor:grabbing; }
    .sp-title{ font-size:11px; font-weight:700; }
    .sp-status{ font-size:10px; color:var(--sp-muted); line-height:1.1; }
    .sp-iconbtn{ border:1px solid var(--sp-line); background:var(--sp-surface); color:inherit; border-radius:8px; padding:4px 6px; cursor:pointer; }
    .sp-iconbtn:hover{ filter:brightness(1.05); }

    .sp-body{ padding:8px; display:grid; gap:8px; }

    .sp-display{
      background:var(--sp-surface); border:1px solid var(--sp-line); border-radius:10px; padding:6px 8px;
    }
    .sp-num{ font-size:14px; font-weight:700; letter-spacing:.3px; }
    .sp-sub{ font-size:10px; color:var(--sp-muted); margin-top:2px; display:flex; gap:6px; flex-wrap:wrap; }

    .sp-actions{ display:grid; grid-template-columns:1fr 1fr; gap:6px; }
    .sp-row{ display:flex; gap:6px; }
    .sp-btn{
      display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:7px 8px;
      border-radius:9px; font-weight:700; font-size:12px; border:1px solid transparent; cursor:pointer;
      white-space:nowrap;
    }
    .sp-call{ background:rgba(16,185,129,.12); color:var(--sp-ok); border-color:rgba(16,185,129,.28); }
    .sp-hang{ background:rgba(239,68,68,.12); color:var(--sp-err); border-color:rgba(239,68,68,.28); }
    .sp-mute{ background:var(--sp-surface); color:inherit; border-color:var(--sp-line); }
    .sp-btn.active{ outline:2px solid currentColor; outline-offset:0; }

    .sp-section{ border:1px solid var(--sp-line); border-radius:10px; overflow:hidden; }
    .sp-sec-hd{
      display:flex; align-items:center; justify-content:space-between; gap:4px; background:var(--sp-bg-2);
      padding:6px 8px; font-size:11px; cursor:pointer; user-select:none;
    }
    .sp-sec-body{ padding:6px; display:none; }
    .sp-section.open .sp-sec-body{ display:block; }

    .sp-pad{ display:grid; grid-template-columns:repeat(3,1fr); gap:6px; }
    .sp-key{
      background:var(--sp-surface); border:1px solid var(--sp-line); color:inherit;
      border-radius:9px; padding:8px 0; font-size:14px; font-weight:700; cursor:pointer; text-align:center;
    }
    .sp-key small{ display:block; font-size:9px; color:var(--sp-muted); margin-top:1px; font-weight:600; }

    .sp-meter{ display:grid; gap:6px; }
    .sp-meter .lbl{ font-size:10px; color:var(--sp-muted); }
    canvas{ width:100%; height:36px; background:var(--sp-wave-bg); border-radius:8px; display:block; }

    .sp-badges{ display:flex; gap:5px; flex-wrap:wrap; }
    .sp-badge{ font-size:10px; padding:2px 6px; border-radius:999px; border:1px solid var(--sp-line); background:var(--sp-surface); color:var(--sp-muted); }
    .bd-on{ color:var(--sp-ok); border-color:rgba(16,185,129,.35); background:rgba(16,185,129,.08); }
    .bd-reg{ color:var(--sp-acc); border-color:rgba(59,130,246,.35); background:rgba(59,130,246,.08); }
    .bd-off{ color:var(--sp-err); border-color:rgba(239,68,68,.35); background:rgba(239,68,68,.08); }
    .bd-err{ color:var(--sp-warn); border-color:rgba(245,158,11,.35); background:rgba(245,158,11,.08); }

    .sp-logs{ background:var(--sp-surface); border:1px solid var(--sp-line); border-radius:9px; padding:6px; height:60px; overflow:auto; font-size:10px; color:var(--sp-muted); white-space:pre-wrap; }
  </style>

  
  <button id="spTrigger" type="button" class="sp-trigger" title="Softphone">
    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.86 19.86 0 0 1 2.09 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.3 1.78.57 2.63a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.45-1.14a2 2 0 0 1 2.11-.45c.85.27 1.73.45 2.63.57A2 2 0 0 1 22 16.92z"/></svg>
    <span id="spDot" class="sp-dot"></span>
  </button>

  
  <div id="spPanel" class="sp-panel" role="dialog" aria-modal="true" aria-labelledby="spTitle" style="top:72px; right:14px;">
    <div id="spDrag" class="sp-hd">
      <div>
        <div id="spTitle" class="sp-title">Softphone</div>
        <div class="sp-status"><span id="wsStatus">WS —</span> • <span id="regStatus">REG —</span> • <span id="callStatus">CALL —</span></div>
      </div>
      <div class="sp-row">
        <button id="togglePad"  class="sp-iconbtn" type="button" title="Teclado">⌨️</button>
        <button id="toggleMeters" class="sp-iconbtn" type="button" title="Áudio">📈</button>
        <button id="spClose" class="sp-iconbtn" type="button" aria-label="Fechar">✕</button>
      </div>
    </div>

    <div class="sp-body">
      <div class="sp-display">
        <div class="sp-num" id="displayNum">—</div>
        <div class="sp-sub">
          <span id="displaySub">Pronto</span>
          <span id="extStatus" class="sp-badge">ext —</span>
          <span id="badge" class="sp-badge">status</span>
        </div>
      </div>

      <div class="sp-actions">
        <button id="btnCall" class="sp-btn sp-call" type="button">Discar</button>
        <button id="btnHang" class="sp-btn sp-hang" type="button">Desligar</button>
      </div>
      <div class="sp-row">
        <button id="muteMic" class="sp-btn sp-mute" type="button" style="flex:1">Mic</button>
        <button id="muteSpk" class="sp-btn sp-mute" type="button" style="flex:1">Áudio</button>
      </div>

      
      <div id="secPad" class="sp-section">
        <div class="sp-sec-hd"><span>Teclado</span><span id="icoPad">▾</span></div>
        <div class="sp-sec-body">
          <div class="sp-pad">
            <button class="sp-key" data-k="1">1</button>
            <button class="sp-key" data-k="2">2<small>ABC</small></button>
            <button class="sp-key" data-k="3">3<small>DEF</small></button>
            <button class="sp-key" data-k="4">4<small>GHI</small></button>
            <button class="sp-key" data-k="5">5<small>JKL</small></button>
            <button class="sp-key" data-k="6">6<small>MNO</small></button>
            <button class="sp-key" data-k="7">7<small>PQRS</small></button>
            <button class="sp-key" data-k="8">8<small>TUV</small></button>
            <button class="sp-key" data-k="9">9<small>WXYZ</small></button>
            <button class="sp-key" data-k="*">*</button>
            <button class="sp-key" data-k="0">0</button>
            <button class="sp-key" data-k="#">#</button>
          </div>
        </div>
      </div>

      
      <div id="secMeters" class="sp-section">
        <div class="sp-sec-hd"><span>Níveis de Áudio</span><span id="icoMeters">▾</span></div>
        <div class="sp-sec-body">
          <div class="sp-meter">
            <div class="lbl">Microfone</div>
            <canvas id="canvasMic" width="220" height="36"></canvas>
          </div>
          <div class="sp-meter">
            <div class="lbl">Áudio Remoto</div>
            <canvas id="canvasSpk" width="220" height="36"></canvas>
          </div>
        </div>
      </div>

      <pre id="logs" class="sp-logs"></pre>
    </div>
  </div>

  <audio id="remoteAudio" autoplay playsinline></audio>

  <script>
    // ---- CONFIG DO BACKEND ----
    window.__SIPCFG = <?php echo json_encode($config, JSON_UNESCAPED_SLASHES, 512) ?>;

    ;(() => {
      const SIP_CONFIG = window.__SIPCFG;
      if (!SIP_CONFIG || !SIP_CONFIG.user || !SIP_CONFIG.pass) { console.warn('SIP config ausente'); return; }

      // Elements
      const $ = (id)=>document.getElementById(id);
      const spTrigger=$('spTrigger'), spDot=$('spDot'), spPanel=$('spPanel'), spDrag=$('spDrag'), spClose=$('spClose');
      const displayNum=$('displayNum'), displaySub=$('displaySub'), badge=$('badge');
      const btnCall=$('btnCall'), btnHang=$('btnHang'), muteMicBtn=$('muteMic'), muteSpkBtn=$('muteSpk');
      const wsStatus=$('wsStatus'), regStatus=$('regStatus'), extStatus=$('extStatus'), callStatus=$('callStatus'), titleEl=$('spTitle');
      const remoteAudio=$('remoteAudio'), logs=$('logs');
      const canvasSpk=$('canvasSpk'), canvasMic=$('canvasMic');
      const ctxSpk=canvasSpk?.getContext('2d'), ctxMic=canvasMic?.getContext('2d');
      const secPad=$('secPad'), secMeters=$('secMeters'), icoPad=$('icoPad'), icoMeters=$('icoMeters');
      const togglePad=$('togglePad'), toggleMeters=$('toggleMeters');

      const S = {
        ua:null, session:null, number:'', micMuted:false, spkMuted:false,
        ac:null, micStream:null, micSource:null, micAnalyser:null,
        spkSource:null, spkAnalyser:null, raf:null,
        drag:{ active:false, sx:0, sy:0, x:0, y:0 } // arrasto com transform
      };

      // ---------- UI helpers ----------
      const dlog = (m)=>{ if(!logs) return; logs.textContent+=`[${new Date().toLocaleTimeString()}] ${m}\n`; logs.scrollTop=logs.scrollHeight; };
      const setBadge=(txt,cls)=>{ if(!badge) return; badge.textContent=txt; badge.className=`sp-badge ${cls||''}`; };
      const setStatuses=({ws,reg,ext,call})=>{
        if(ws!==undefined) wsStatus.textContent = `WS ${ws}`;
        if(reg!==undefined) regStatus.textContent = `REG ${reg}`;
        if(ext!==undefined) extStatus.textContent = ext;
        if(call!==undefined) callStatus.textContent = `CALL ${call}`;
      };
      const setTrigger = (state) => {
        spDot.classList.remove('online','registered','offline','error');
        spDot.classList.add(state||'offline');
      };
      const setDisplays=(num, sub)=>{ if(num!==undefined) displayNum.textContent = num || '—'; if(sub!==undefined) displaySub.textContent = sub; };

      // -------- Abrir / Fechar --------
      const togglePanel = () => {
        const open = spPanel.classList.toggle('show');
        localStorage.setItem('sp_open', open ? '1' : '0');
        if(open) ensureAudioContext();
      };
      spTrigger.addEventListener('click', togglePanel);
      spClose.addEventListener('click', ()=>{ spPanel.classList.remove('show'); localStorage.setItem('sp_open','0'); });

      // -------- Colapsáveis + persistência --------
      function setSection(sectionEl, open, iconEl){
        sectionEl.classList.toggle('open', !!open);
        if(iconEl) iconEl.textContent = open ? '▾' : '▸';
      }
      const padOpen = localStorage.getItem('sp_pad_open') !== '0';
      const metersOpen = localStorage.getItem('sp_meters_open') === '1';
      setSection(secPad, padOpen, icoPad);
      setSection(secMeters, metersOpen, icoMeters);

      secPad.querySelector('.sp-sec-hd').addEventListener('click', ()=>{
        const o = !secPad.classList.contains('open'); setSection(secPad, o, icoPad);
        localStorage.setItem('sp_pad_open', o ? '1' : '0');
      });
      secMeters.querySelector('.sp-sec-hd').addEventListener('click', ()=>{
        const o = !secMeters.classList.contains('open'); setSection(secMeters, o, icoMeters);
        localStorage.setItem('sp_meters_open', o ? '1' : '0');
      });
      togglePad.addEventListener('click', ()=>secPad.querySelector('.sp-sec-hd').click());
      toggleMeters.addEventListener('click', ()=>secMeters.querySelector('.sp-sec-hd').click());

      // -------- Arrastar com transform + rAF (suave em mouse e touch) --------
      (function makeDraggable(){
        const loadPos = () => {
          const raw = localStorage.getItem('sp_pos_v2');
          if(!raw) return { x:0, y:0 };
          try{ return JSON.parse(raw); }catch{ return { x:0, y:0 }; }
        };
        const savePos = () => localStorage.setItem('sp_pos_v2', JSON.stringify({ x:S.drag.x, y:S.drag.y }));

        const apply = ()=>{ spPanel.style.transform = `translate3d(${S.drag.x}px, ${S.drag.y}px, 0)`; };
        // posição base = onde o painel foi renderizado
        const baseRect = () => spPanel.getBoundingClientRect();

        const pos = loadPos();
        S.drag.x = pos.x || 0; S.drag.y = pos.y || 0;
        apply();

        const start = (cx, cy)=>{
          S.drag.active = true; S.drag.sx = cx; S.drag.sy = cy;
          document.body.style.userSelect='none';
        };
        const move = (cx, cy)=>{
          if(!S.drag.active) return;
          const dx = cx - S.drag.sx, dy = cy - S.drag.sy;
          // clamp na viewport
          const rect = baseRect();
          const w = window.innerWidth, h = window.innerHeight;
          const nx = S.drag.x + dx, ny = S.drag.y + dy;
          const left = Math.min(Math.max(nx, -(rect.left - 8)), w - (rect.left + rect.width) + S.drag.x - 8);
          const top  = Math.min(Math.max(ny, -(rect.top  - 8)), h - (rect.top + rect.height) + S.drag.y - 8);
          S.drag.x = left; S.drag.y = top;
          S.drag.sx = cx; S.drag.sy = cy;
          requestAnimationFrame(apply);
        };
        const end = ()=>{ if(!S.drag.active) return; S.drag.active = false; document.body.style.userSelect=''; savePos(); };

        // Mouse
        spDrag.addEventListener('mousedown', (e)=>{ start(e.clientX, e.clientY); });
        window.addEventListener('mousemove', (e)=> move(e.clientX, e.clientY));
        window.addEventListener('mouseup', end);

        // Touch
        spDrag.addEventListener('touchstart', (e)=>{ const t=e.touches[0]; start(t.clientX, t.clientY); }, {passive:true});
        window.addEventListener('touchmove', (e)=>{ const t=e.touches[0]; move(t.clientX, t.clientY); }, {passive:true});
        window.addEventListener('touchend', end);

        // Restaurar aberto/fechado
        if(localStorage.getItem('sp_open') === '1'){ spPanel.classList.add('show'); }
      })();

      // -------- WebAudio: ondas reais --------
      function ensureAudioContext(){
        if(S.ac) return;
        try{
          S.ac = new (window.AudioContext || window.webkitAudioContext)();
          navigator.mediaDevices.getUserMedia({ audio:true, video:false })
            .then(stream=>{
              S.micStream = stream;
              S.micSource = S.ac.createMediaStreamSource(stream);
              S.micAnalyser = S.ac.createAnalyser();
              S.micAnalyser.fftSize = 1024;
              S.micSource.connect(S.micAnalyser);
              dlog('Mic OK para meter');
              drawLoop(); // inicia assim que consegue áudio
            }).catch(err=> dlog('Mic meter erro: '+err));
        }catch(err){ dlog('AudioContext erro: '+err); }
      }

      function drawWave(ctx, analyser){
        const w = ctx.canvas.width, h = ctx.canvas.height;
        ctx.clearRect(0,0,w,h);
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--sp-wave-bg').trim() || '#f3f4f6';
        ctx.fillRect(0,0,w,h);
        if(!analyser) return;
        const bufferLength = analyser.fftSize;
        const dataArray = new Uint8Array(bufferLength);
        analyser.getByteTimeDomainData(dataArray);
        ctx.lineWidth = 2;
        ctx.strokeStyle = getComputedStyle(document.documentElement).getPropertyValue('--sp-wave-stroke').trim() || '#3b82f6';
        ctx.beginPath();
        const slice = w / bufferLength; let x = 0;
        for(let i=0;i<bufferLength;i++){
          const v = dataArray[i]/128.0;
          const y = (v*h/2);
          if(i===0) ctx.moveTo(x,y); else ctx.lineTo(x,y);
          x += slice;
        }
        ctx.lineTo(w, h/2); ctx.stroke();
      }
      function drawLoop(){
        if(ctxMic && S.micAnalyser) drawWave(ctxMic, S.micAnalyser);
        if(ctxSpk && S.spkAnalyser) drawWave(ctxSpk, S.spkAnalyser);
        S.raf = requestAnimationFrame(drawLoop);
      }

      // -------- SIP.js --------
      async function initUA(){
        if(S.ua){ try{ await S.ua.stop(); }catch(_){ } S.ua=null; }
        try{
          S.ua = new SIP.UA({
            uri: `sip:${SIP_CONFIG.user}@${SIP_CONFIG.domain}`,
            transportOptions: { wsServers: [SIP_CONFIG.wss] },
            authorizationUser: SIP_CONFIG.user,
            password: SIP_CONFIG.pass,
            displayName: SIP_CONFIG.displayName || SIP_CONFIG.user,
            traceSip: true,
            rel100: SIP.C.supported.SUPPORTED,
            sessionDescriptionHandlerFactoryOptions: {
              constraints: { audio: true, video: false },
              peerConnectionOptions: {
                rtcConfiguration: {
                  iceServers: [{ urls: 'stun:stun.l.google.com:19302' }],
                  iceCandidatePoolSize: 4
                }
              }
            }
          });

          S.ua.on('connected', ()=>{ setBadge('Online','bd-on'); setStatuses({ws:'ON'}); setTrigger('online'); dlog('WS conectado'); });
          S.ua.on('disconnected', ()=>{ setBadge('Offline','bd-off'); setStatuses({ws:'OFF', reg:'—'}); setTrigger('offline'); dlog('WS desconectado'); });
          S.ua.on('registered', ()=>{
            setBadge('Registrado','bd-reg'); setStatuses({reg:'OK'}); setTrigger('registered');
            titleEl.textContent = `${SIP_CONFIG.displayName||'Ramal'} — ${SIP_CONFIG.user}@${SIP_CONFIG.domain}`;
            extStatus.textContent = `${SIP_CONFIG.user}@${SIP_CONFIG.domain}`;
            dlog('Registrado');
          });
          S.ua.on('registrationFailed', (e)=>{ setBadge('Falha','bd-err'); setStatuses({reg:'ERRO'}); setTrigger('error'); dlog('Falha registro: '+(e?.cause||'')); });

          // Inbound
          S.ua.on('invite', (incoming)=>{
            dlog('Chamada recebida');
            setStatuses({call:'RINGING'});
            setDisplays(incoming?.request?.from?.displayName || incoming?.remoteIdentity?.displayName || 'Remoto', 'Chamada recebida');
            spPanel.classList.add('show'); ensureAudioContext();

            const acceptCall = async ()=>{ try{ incoming.accept({ sessionDescriptionHandlerOptions: { constraints:{audio:true, video:false} }}); bindSession(incoming); }catch(err){ dlog('Erro ao atender: '+err); } };
            const rejectCall = ()=>{ try{ incoming.reject(); }catch(_){ } setStatuses({call:'—'}); dlog('Recusada'); };
            btnCall.addEventListener('click', acceptCall, { once:true });
            btnHang.addEventListener('click', rejectCall, { once:true });
          });

          await S.ua.start();
        }catch(err){ setBadge('Erro','bd-err'); setTrigger('error'); dlog('Erro UA: '+err); }
      }

      function bindSession(sess){
        S.session = sess;
        setStatuses({call:'EM CHAMADA'}); setDisplays(displayNum.textContent, 'Em chamada');
        S.session.on('trackAdded', ()=>{
          const pc = S.session.sessionDescriptionHandler?.peerConnection; if(!pc) return;
          const remoteStream = new MediaStream();
          pc.getReceivers().forEach(r=>{ if(r.track) remoteStream.addTrack(r.track); });
          remoteAudio.srcObject = remoteStream;
          try{
            if(S.ac){ S.spkSource = S.ac.createMediaStreamSource(remoteStream); S.spkAnalyser = S.ac.createAnalyser(); S.spkAnalyser.fftSize = 1024; S.spkSource.connect(S.spkAnalyser); }
          }catch(err){ dlog('Spk analyser erro: '+err); }
        });
        S.session.on('terminated', ()=>{ setStatuses({call:'—'}); setDisplays('', 'Pronto'); S.session=null; dlog('Chamada encerrada'); });
      }

      // -------- Discagem / DTMF / Hang --------
      async function startCall(){
        if(!S.ua) return;
        const num = S.number.trim() || displayNum.textContent.replace(/\D/g,'');
        if(!num){ setDisplays('', 'Informe um número'); return; }
        const target = `sip:${num}@${SIP_CONFIG.domain}`;
        dlog('Discando: '+target);
        try{ const out = S.ua.invite(target, { sessionDescriptionHandlerOptions:{ constraints:{ audio:true, video:false } }}); bindSession(out); }
        catch(err){ dlog('Erro ao discar: '+err); }
      }
      function hangCall(){ try{ if(S.session){ S.session.bye?.(); S.session.terminate?.(); } }catch(_){ } }

      function pressKey(k){
        if(S.session && typeof S.session.dtmf === 'function'){
          try{ S.session.dtmf(k); dlog('DTMF '+k); }catch(err){ dlog('DTMF erro: '+err); }
        }else{
          S.number = (S.number||'') + k;
          setDisplays(S.number, 'Compondo');
        }
      }

      // -------- Mutes --------
      function toggleMic(){
        if(!S.session){ S.micMuted = !S.micMuted; muteMicBtn.classList.toggle('active', S.micMuted); return; }
        const pc = S.session.sessionDescriptionHandler?.peerConnection; if(!pc) return;
        pc.getSenders().forEach(s=>{ if(s.track && s.track.kind==='audio'){ s.track.enabled = !s.track.enabled; S.micMuted = !s.track.enabled; } });
        muteMicBtn.classList.toggle('active', S.micMuted);
      }
      function toggleSpk(){
        remoteAudio.muted = !remoteAudio.muted;
        S.spkMuted = remoteAudio.muted;
        muteSpkBtn.classList.toggle('active', S.spkMuted);
      }

      // Listeners
      btnCall.addEventListener('click', startCall);
      btnHang.addEventListener('click', hangCall);
      muteMicBtn.addEventListener('click', toggleMic);
      muteSpkBtn.addEventListener('click', toggleSpk);
      document.querySelectorAll('.sp-key').forEach(b=> b.addEventListener('click', ()=> pressKey(b.dataset.k)));

      window.addEventListener('keydown', (e)=>{
        if(!spPanel.classList.contains('show')) return;
        if((e.key>='0' && e.key<='9') || ['*','#'].includes(e.key)){ pressKey(e.key); }
        else if(e.key==='Backspace' && !S.session){ S.number = (S.number||'').slice(0,-1); setDisplays(S.number || '—','Compondo'); }
        else if(e.key==='Enter' && !S.session){ startCall(); }
        else if(e.key==='Escape' && S.session){ hangCall(); }
      });

      // Boot
      setDisplays('', 'Inicializando…');
      setStatuses({ws:'—', reg:'—', ext:`${SIP_CONFIG.user}@${SIP_CONFIG.domain}`, call:'—'});
      titleEl.textContent = `${SIP_CONFIG.displayName||'Ramal'} — ${SIP_CONFIG.user}@${SIP_CONFIG.domain}`;
      if(localStorage.getItem('sp_open') === '1'){ ensureAudioContext(); }
      initUA();
    })();
  </script>
<?php else: ?>
  
<?php endif; ?>
<?php /**PATH /var/www/html/fttelecom/resources/views/components/webrtc-phone.blade.php ENDPATH**/ ?>