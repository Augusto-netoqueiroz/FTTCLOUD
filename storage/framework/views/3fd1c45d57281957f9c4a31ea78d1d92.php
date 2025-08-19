<!doctype html>
<html lang="pt-BR" data-theme="dark">
<head>
  <meta charset="utf-8" />
  <title>FT Telecom — Ramal Web (Perpétuo)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.jsdelivr.net/npm/sip.js@0.11.6/dist/sip.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#0b1220; --surface:#0f172a; --surface-2:#111b2e; --txt:#e6edf6;
      --muted:#8ba0bd; --line:#1d2a44; --line-strong:#223357;
      --primary:#3b82f6; --success:#22c55e; --danger:#ef4444; --warning:#f59e0b;
      --shadow:0 14px 40px rgba(0,0,0,.35);
      /* cores do capsule meter */
      --cap-bg:#0c1528; --cap-fill-start:#22c55e; --cap-fill-mid:#f59e0b; --cap-fill-end:#ef4444; --cap-vol:#3b82f6;
    }
    [data-theme="light"]{
      --bg:#f3f6fb; --surface:#ffffff; --surface-2:#f6f8fc; --txt:#0b1220;
      --muted:#4a5a72; --line:#e4e9f1; --line-strong:#d7deea;
      --primary:#2563eb; --success:#16a34a; --danger:#dc2626; --warning:#f59e0b;
      --shadow:0 14px 40px rgba(16,24,40,.15);
      --cap-bg:#eef2f7; --cap-fill-start:#16a34a; --cap-fill-mid:#f59e0b; --cap-fill-end:#dc2626; --cap-vol:#2563eb;
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:var(--bg);color:var(--txt)}
    .container{max-width:1000px;margin:0 auto;padding:16px}
    header.top{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
    .theme-toggle{display:inline-flex;gap:8px;align-items:center;padding:6px 10px;border:1px solid var(--line);border-radius:999px;background:var(--surface);cursor:pointer;user-select:none}
    .theme-toggle input{display:none}
    .theme-toggle .dot{width:14px;height:14px;border-radius:999px;background:var(--primary)}
    .panel{border:1px solid var(--line);background:var(--surface);border-radius:14px;padding:12px;box-shadow:var(--shadow)}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    @media (max-width:900px){.grid{grid-template-columns:1fr}}

    /* layer clique-fora */
    .layer{position:fixed;inset:0;z-index:1000;pointer-events:none}
    .layer.active{pointer-events:auto}

    /* MODAL sólido */
    .phone{
      position:fixed;left:18px;bottom:18px;width:340px;max-width:92vw;border-radius:16px;border:1px solid var(--line-strong);
      background:var(--surface);box-shadow:var(--shadow);overflow:hidden;transform-origin:bottom left;
      opacity:0;transform:scale(.98) translateY(8px);transition:opacity .18s ease, transform .18s ease
    }
    .phone.show{opacity:1;transform:scale(1) translateY(0)}
    .phone.hide{opacity:0;transform:scale(.98) translateY(8px)}
    @media (max-width:420px){.phone{width:92vw}}

    .ph-head{
      display:flex;align-items:center;justify-content:space-between;padding:10px;border-bottom:1px solid var(--line-strong);
      background:var(--surface-2);user-select:none;cursor:grab
    }
    .ph-title{font-size:13px;font-weight:700;display:flex;align-items:center;gap:8px}
    .badge{font-size:11px;padding:2px 8px;border-radius:999px;border:1px solid var(--line)}
    .bd-off{background:#6b7a90;color:#0b1220}.bd-on{background:var(--primary);color:#fff}.bd-reg{background:var(--success);color:#04110a}.bd-err{background:var(--danger);color:#fff}
    .head-actions{display:flex;align-items:center;gap:8px}
    .icon{background:var(--surface);border:1px solid var(--line-strong);width:32px;height:32px;border-radius:10px;color:var(--muted);cursor:pointer;display:grid;place-items:center}
    .icon:hover{border-color:var(--primary);color:var(--primary)}
    .ph-body{padding:10px;min-width:0}

    .display{display:flex;flex-direction:column;align-items:center;gap:2px;margin:2px 0 8px}
    .number{font-size:22px;min-height:24px;max-width:100%;overflow:hidden;text-overflow:ellipsis}
    .sub{font-size:12px;color:var(--muted);min-height:16px}

    /* Capsule meter + slider integrado (elástico) */
    .sliders{display:grid;grid-template-columns:1fr;gap:10px;margin:8px 0}
    .ac{display:grid;grid-template-columns:74px 1fr;gap:8px;align-items:center;min-width:0}
    .ac label{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.04em}
    .audio-control{position:relative;width:100%;height:46px;min-width:0}
    .audio-control canvas{
      position:absolute;inset:0;border-radius:12px;border:1px solid var(--line-strong);
      background:var(--surface-2);display:block;width:100%;height:46px /* elástico */
    }
    .audio-control input[type="range"]{
      position:absolute;inset:0;appearance:none;background:transparent;height:46px;margin:0
    }
    .audio-control input[type="range"]::-webkit-slider-thumb{-webkit-appearance:none;width:18px;height:18px;border-radius:12px;background:var(--primary);border:1px solid var(--line-strong)}
    .audio-control input[type="range"]::-moz-range-thumb{width:18px;height:18px;border-radius:12px;background:var(--primary);border:1px solid var(--line-strong)}
    .audio-control input[type="range"]::-webkit-slider-runnable-track{background:transparent;height:46px}
    .audio-control input[type="range"]::-moz-range-track{background:transparent;height:46px}

    /* Toolbar em grid (não corta) */
    .toolbar{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;margin:8px 0}
    .btn{
      height:40px;padding:0 10px;border-radius:10px;border:1px solid var(--line-strong);
      background:var(--surface-2);color:var(--txt);cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;
      font-weight:600;font-size:13px;max-width:100%;min-width:0
    }
    .btn.primary{background:var(--primary);border-color:var(--primary);color:#fff}
    .btn.success{background:var(--success);border-color:var(--success);color:#06220f}
    .btn.danger{background:var(--danger);border-color:var(--danger);color:#fff}
    .btn.ghost{background:var(--surface);border-color:var(--line)}
    .btn svg{flex:0 0 auto}
    .btn span{display:inline-block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:100%}

    .keypad{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
    .key{height:46px;border-radius:10px;background:var(--surface-2);border:1px solid var(--line-strong);display:flex;align-items:center;justify-content:center;font-size:18px;cursor:pointer;user-select:none}
    .key:active{transform:scale(.98)}

    .actions{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin:10px 0}
    .logs{font:12px ui-monospace,Menlo,Consolas,monospace;color:var(--muted);border:1px solid var(--line-strong);border-radius:10px;padding:6px;height:64px;overflow:auto;background:var(--surface-2)}

    .pill{position:fixed;right:16px;bottom:16px;z-index:1001;display:inline-flex;align-items:center;gap:10px;background:var(--surface);border:1px solid var(--line-strong);box-shadow:var(--shadow);padding:10px 14px;border-radius:999px;cursor:pointer}
    .pill .dot{width:10px;height:10px;border-radius:999px;background:var(--danger)}
    .pill.online .dot{background:var(--primary)}
    .pill.registered .dot{background:var(--success)}

    .popup{position:fixed;right:16px;top:16px;z-index:1100;display:none;width:340px;border:1px solid var(--line-strong);background:var(--surface);border-radius:12px;box-shadow:var(--shadow);overflow:hidden;opacity:0;transform:translateY(-6px);transition:opacity .18s ease, transform .18s ease}
    .popup.show{display:block;opacity:1;transform:translateY(0)}
    .pop-head{padding:10px;border-bottom:1px solid var(--line-strong);font-weight:700;font-size:14px;background:var(--surface-2)}
    .pop-body{padding:12px;font-size:14px;line-height:1.2}
    .pop-meta{display:flex;gap:8px;color:var(--muted);font-size:12px;margin-top:4px}
    .pop-actions{display:flex;gap:10px;padding:12px;border-top:1px solid var(--line-strong)}
  </style>
</head>
<body>
  <div class="container">
    <header class="top">
      <h3 style="margin:0">Call Center — Ramal Web (Perpétuo)</h3>
      <label class="theme-toggle">
        <span id="themeLabel">Tema: Escuro</span>
        <span class="dot"></span>
        <input id="themeToggle" type="checkbox" />
      </label>
    </header>

    <div class="grid">
      <div class="panel">
        <strong>Status</strong>
        <div id="statusArea" style="margin-top:8px;display:grid;grid-template-columns:120px 1fr;gap:6px;font-size:14px">
          <div>WS:</div><div id="wsStatus">—</div>
          <div>Registro:</div><div id="regStatus">—</div>
          <div>Ramal:</div><div id="extStatus">—</div>
          <div>Chamada:</div><div id="callStatus">—</div>
        </div>
      </div>
      <div class="panel">
        <strong>Dicas</strong>
        <ul style="margin:8px 0 0 18px; color:var(--muted); font-size:14px">
          <li>Registro automático; modal inicia minimizado (pill no canto).</li>
          <li>Minimiza por botão, **clique-fora** ou tecla **Esc**.</li>
          <li>Controles de volume com **Capsule Meter** (gradiente + pico) elástico.</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- layer clique-fora -->
  <div id="layer" class="layer">
    <div id="phone" class="phone" role="dialog" aria-modal="true" aria-label="Telefone WebRTC">
      <div id="drag" class="ph-head" title="Arraste para mover. Duplo clique minimiza.">
        <div class="ph-title">
          <span id="title">Ramal Web</span>
          <span id="badge" class="badge bd-off">Offline</span>
        </div>
        <div class="head-actions">
          <button id="btnMin" class="icon" title="Minimizar" aria-label="Minimizar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="2" rx="1" fill="currentColor"/></svg>
          </button>
        </div>
      </div>

      <div class="ph-body">
        <div class="display">
          <div id="displayNum" class="number"></div>
          <div id="displaySub" class="sub">Pronto para discar</div>
        </div>

        <div class="sliders">
          <div class="ac">
            <label>Cliente</label>
            <div class="audio-control">
              <canvas id="canvasSpk"></canvas>
              <input id="rangeSpk" type="range" min="0" max="100" value="80" />
            </div>
          </div>
          <div class="ac">
            <label>Microfone</label>
            <div class="audio-control">
              <canvas id="canvasMic"></canvas>
              <input id="rangeMic" type="range" min="0" max="100" value="60" />
            </div>
          </div>
        </div>

        <div class="toolbar">
          <label class="btn ghost"><input id="autoAnswer" type="checkbox" style="margin-right:6px"> <span>Autoatender</span></label>
          <button id="toggleKey" class="btn ghost"><span>Teclado</span></button>
          <button id="muteMic" class="btn ghost"><span>Mic</span></button>
          <button id="muteSpk" class="btn ghost"><span>Áudio</span></button>
          <button id="clearNum" class="btn ghost"><span>Limpar</span></button>
        </div>

        <div id="keypad" class="keypad"></div>

        <div class="actions">
          <button id="btnCall" class="btn success" title="Ligar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.28-.28.67-.36 1.02-.25 1.12.37 2.32.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1A17 17 0 0 1 3 4c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2Z"/></svg>
            <span>Ligar</span>
          </button>
          <button id="btnHang" class="btn danger" title="Desligar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 9c-1.6 0-3.15.25-4.6.72v3.1c0 .4-.23.74-.56.9-.98.49-1.87 1.12-2.67 1.85-.17.18-.42.29-.67.29-.3 0-.5-.1-.7-.26-.5-.42-.5-1.16 0-1.6l.7-.7c1.03-1.01 2.16-1.91 3.36-2.67.19-.13.39-.21.59-.25 1.4-.51 2.95-.82 4.55-.82s3.15.31 4.55.82c.2.04.4.12.59.25 1.2.76 2.33 1.66 3.36 2.67l.7.7c.5.44.5 1.18 0 1.6-.2.16-.4.26-.7.26-.25 0-.5-.11-.68-.29-.8-.73-1.69-1.36-2.67-1.85a.99.99 0 0 1-.56-.9v-3.1C15.15 9.25 13.6 9 12 9Z"/></svg>
            <span>Desligar</span>
          </button>
        </div>

        <div id="logs" class="logs" aria-live="polite"></div>
      </div>
    </div>
  </div>

  <!-- pill -->
  <div id="pill" class="pill" role="button" aria-label="Ramal">
    <span class="dot"></span><strong style="font-weight:700">Ramal</strong><span id="pillText" style="color:var(--muted)">Inicializando…</span>
  </div>

  <!-- popup -->
  <div id="popup" class="popup" role="alertdialog" aria-labelledby="popTitle">
    <div id="popTitle" class="pop-head">📥 Chamada recebida</div>
    <div class="pop-body">
      <div style="font-size:13px;color:var(--muted)">Origem</div>
      <div id="popFrom" style="font-size:18px;margin-top:4px">—</div>
      <div class="pop-meta">
        <div id="popTo">→ Ramal: —</div>
        <div id="ringTimer">Tocando: 0s</div>
      </div>
    </div>
    <div class="pop-actions">
      <button id="popDecline" class="btn">Recusar</button>
      <button id="popAccept" class="btn primary">Atender</button>
    </div>
  </div>

  <audio id="remoteAudio" autoplay playsinline></audio>

  <script>
  ;(() => {
    // ===== CONFIG SIP =====
    const SIP_CONFIG = { wss:'wss://pbx.fttelecom.cloud:8089/ws', domain:'pbx.fttelecom.cloud', user:'2005', pass:'S3nh@WebRTC_2005!' };

    // ===== ELEMENTOS =====
    const $ = (id)=>document.getElementById(id);
    const layer=$('layer'), phone=$('phone'), pill=$('pill'), pillText=$('pillText'), badge=$('badge'), btnMin=$('btnMin');
    const displayNum=$('displayNum'), displaySub=$('displaySub'), keypad=$('keypad'), logs=$('logs');
    const btnCall=$('btnCall'), btnHang=$('btnHang'), muteMicBtn=$('muteMic'), muteSpkBtn=$('muteSpk'), clearBtn=$('clearNum'), toggleKeyBtn=$('toggleKey');
    const drag=$('drag'), autoAnswer=$('autoAnswer');
    const wsStatus=$('wsStatus'), regStatus=$('regStatus'), extStatus=$('extStatus'), callStatus=$('callStatus'), title=$('title');
    const popup=$('popup'), popFrom=$('popFrom'), popTo=$('popTo'), ringTimer=$('ringTimer'), popAccept=$('popAccept'), popDecline=$('popDecline');
    const themeToggle=$('themeToggle'), themeLabel=$('themeLabel');
    const remoteAudio=$('remoteAudio');

    // Capsule meters
    const canvasSpk=$('canvasSpk'), rangeSpk=$('rangeSpk');
    const canvasMic=$('canvasMic'), rangeMic=$('rangeMic');
    const ctxSpk=canvasSpk.getContext('2d'), ctxMic=canvasMic.getContext('2d');

    // ===== STATE =====
    const S = {
      ua:null, session:null, number:'',
      micMuted:false, spkMuted:false, callTimer:null,
      ctx:null, // AudioContext
      // MIC nodes
      micStream:null, micSource:null, micGain:null, micAnalyser:null, micProcTrack:null,
      // SPK nodes
      spkSource:null, spkGain:null, spkAnalyser:null,
      raf:null,
      dragging:false, startX:0, startY:0, posX:18, posY:18,
      ringT0:null, ringTick:null,
      peakMic:0, peakSpk:0, // peak hold
    };

    // ===== THEME =====
    const loadTheme=()=>{ const saved=localStorage.getItem('fttheme')||'dark'; document.documentElement.setAttribute('data-theme',saved); themeToggle.checked=(saved==='light'); themeLabel.textContent=`Tema: ${saved==='light'?'Claro':'Escuro'}`; };
    themeToggle.addEventListener('change',()=>{ const mode=themeToggle.checked?'light':'dark'; document.documentElement.setAttribute('data-theme',mode); localStorage.setItem('fttheme',mode); themeLabel.textContent=`Tema: ${mode==='light'?'Claro':'Escuro'}`; });
    loadTheme();

    // ===== UI helpers =====
    const dlog = (m)=>{ logs.textContent+=`[${new Date().toLocaleTimeString()}] ${m}\n`; logs.scrollTop=logs.scrollHeight; };
    const setBadge=(txt,cls)=>{ badge.textContent=txt; badge.className=`badge ${cls}`; };
    const setDisplays=(n,sub)=>{ if(n!==undefined) displayNum.textContent=n||'…'; if(sub!==undefined) displaySub.textContent=sub; };
    const setStatuses=({ws,reg,ext,call})=>{ if(ws!==undefined) wsStatus.textContent=ws; if(reg!==undefined) regStatus.textContent=reg; if(ext!==undefined) extStatus.textContent=ext; if(call!==undefined) callStatus.textContent=call; };

    // ===== phone show/hide =====
    const showPhone=()=>{ layer.classList.add('active'); phone.classList.remove('hide'); phone.classList.add('show'); };
    const hidePhone=()=>{ phone.classList.remove('show'); phone.classList.add('hide'); setTimeout(()=>layer.classList.remove('active'),180); };
    const minimize=()=>{ hidePhone(); };

    // ===== pill =====
    const setPill=(cls,txt)=>{ pill.className=`pill ${cls}`; pillText.textContent=txt; };
    pill.addEventListener('click', showPhone);

    // ===== modal controls =====
    btnMin.addEventListener('click', minimize);
    layer.addEventListener('click', (e)=>{ if(e.target===layer) minimize(); });

    // ===== popup =====
    const showPopup=(from,to)=>{ popFrom.textContent=from; popTo.textContent=`→ Ramal: ${to}`; popup.classList.add('show'); S.ringT0=Date.now(); S.ringTick=setInterval(()=>{ const elapsed=Math.floor((Date.now()-S.ringT0)/1000); ringTimer.textContent=`Tocando: ${elapsed}s`; },1000); };
    const hidePopup=()=>{ popup.classList.remove('show'); if(S.ringTick){ clearInterval(S.ringTick); S.ringTick=null; } };
    popAccept.addEventListener('click',()=>{ hidePopup(); tryAcceptIncoming(); });
    popDecline.addEventListener('click',()=>{ hidePopup(); if(S.session){ try{ S.session.reject(); }catch(e){ dlog('Erro reject: '+e); } } });

    // ===== keypad =====
    const keys=['1','2','3','4','5','6','7','8','9','*','0','#'];
    keys.forEach(k=>{ const btn=document.createElement('div'); btn.className='key'; btn.textContent=k; btn.onclick=()=>{ if(S.session){ try{ S.session.dtmf(k); }catch(e){ dlog('DTMF erro: '+e); } } else { S.number+=k; setDisplays(S.number); } }; keypad.appendChild(btn); });

    // ===== clear =====
    clearBtn.addEventListener('click',()=>{ S.number=''; setDisplays(''); });

    // ===== toggle keypad =====
    toggleKeyBtn.addEventListener('click',()=>{ keypad.classList.toggle('hidden'); });

    // ===== drag =====
    let isDragging=false, startX=0, startY=0, startLeft=0, startTop=0;
    drag.addEventListener('mousedown',(e)=>{ isDragging=true; startX=e.clientX; startY=e.clientY; const rect=phone.getBoundingClientRect(); startLeft=rect.left; startTop=rect.top; document.addEventListener('mousemove',onDrag); document.addEventListener('mouseup',onDragEnd); });
    drag.addEventListener('dblclick', minimize);
    const onDrag=(e)=>{ if(!isDragging) return; const dx=e.clientX-startX, dy=e.clientY-startY; phone.style.left=`${startLeft+dx}px`; phone.style.top=`${startTop+dy}px`; };
    const onDragEnd=()=>{ isDragging=false; document.removeEventListener('mousemove',onDrag); document.removeEventListener('mouseup',onDragEnd); };

    // ===== timer =====
    let callStartTime=null;
    const startTimer=()=>{ callStartTime=Date.now(); const updateTimer=()=>{ if(!callStartTime) return; const elapsed=Math.floor((Date.now()-callStartTime)/1000); const mm=Math.floor(elapsed/60).toString().padStart(2,'0'), ss=(elapsed%60).toString().padStart(2,'0'); setDisplays(undefined,`${mm}:${ss}`); }; S.callTimer=setInterval(updateTimer,1000); updateTimer(); };
    const stopTimer=()=>{ if(S.callTimer){ clearInterval(S.callTimer); S.callTimer=null; } callStartTime=null; };

    // ===== session end =====
    const endSession=(reason)=>{ S.session=null; stopTimer(); setDisplays('',reason||'Finalizada'); setStatuses({call:'—'}); hidePopup(); if(S.spkSource){ try{ S.spkSource.disconnect(); }catch(_){} S.spkSource=null; } if(S.spkGain){ try{ S.spkGain.disconnect(); }catch(_){} S.spkGain=null; } if(S.spkAnalyser){ try{ S.spkAnalyser.disconnect(); }catch(_){} S.spkAnalyser=null; } dlog(reason||'Chamada finalizada'); };

    // ===== audio context =====
    async function ensureAudioGraph(){
      if(S.ctx) return;
      try{
        S.ctx = new (window.AudioContext||window.webkitAudioContext)();
        if(S.ctx.state==='suspended') await S.ctx.resume();

        // MIC
        S.micStream = await navigator.mediaDevices.getUserMedia({audio:true});
        S.micSource = S.ctx.createMediaStreamSource(S.micStream);
        S.micGain   = S.ctx.createGain();
        S.micAnalyser = S.ctx.createAnalyser();
        S.micAnalyser.fftSize = 1024; S.micAnalyser.smoothingTimeConstant = 0.85;

        S.micSource.connect(S.micGain);
        S.micGain.connect(S.micAnalyser);

        // Aplicar ganho inicial
        const applyMicGain = ()=> { const v = rangeMic.value/100; S.micGain.gain.value = Math.pow(v, 2); };
        applyMicGain();
        rangeMic.oninput = applyMicGain;

        // Criar track processado para SIP
        const dest = S.ctx.createMediaStreamDestination();
        S.micGain.connect(dest);
        S.micProcTrack = dest.stream.getAudioTracks()[0];

        startMetersLoop();
        dlog('AudioContext + microfone OK');
      }catch(e){ dlog('Erro audio: '+e); }
    }

    // ===== meters =====
    function startMetersLoop(){
      if(S.raf) return;
      const loop=()=>{
        drawMeter(ctxMic, S.micAnalyser, rangeMic.value/100, 'mic');
        if(S.spkAnalyser) drawMeter(ctxSpk, S.spkAnalyser, rangeSpk.value/100, 'spk');
        S.raf = requestAnimationFrame(loop);
      };
      loop();
    }

    function drawMeter(ctx, analyser, volume, type){
      if(!analyser) return;
      const canvas=ctx.canvas, w=canvas.width, h=canvas.height;
      ctx.clearRect(0,0,w,h);

      // Fundo
      ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--cap-bg').trim();
      ctx.fillRect(0,0,w,h);

      // FFT
      const bufferLength = analyser.frequencyBinCount;
      const dataArray = new Uint8Array(bufferLength);
      analyser.getByteFrequencyData(dataArray);

      // RMS
      let sum=0; for(let i=0; i<bufferLength; i++) sum += (dataArray[i]/255)**2;
      const rms = Math.sqrt(sum/bufferLength);
      const level = Math.min(rms * volume, 1);

      // Peak hold
      const peakKey = type==='mic' ? 'peakMic' : 'peakSpk';
      if(level > S[peakKey]) S[peakKey] = level;
      else S[peakKey] *= 0.95; // decay

      // Gradiente
      const grad = ctx.createLinearGradient(0,0,w,0);
      grad.addColorStop(0, getComputedStyle(document.documentElement).getPropertyValue('--cap-fill-start').trim());
      grad.addColorStop(0.5, getComputedStyle(document.documentElement).getPropertyValue('--cap-fill-mid').trim());
      grad.addColorStop(1, getComputedStyle(document.documentElement).getPropertyValue('--cap-fill-end').trim());

      // Barra principal
      ctx.fillStyle = grad;
      ctx.fillRect(0, h*0.2, w*level, h*0.4);

      // Peak
      if(S[peakKey] > 0.01){
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--cap-vol').trim();
        ctx.fillRect(w*S[peakKey]-2, h*0.1, 4, h*0.6);
      }

      // Volume indicator
      ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--cap-vol').trim();
      ctx.fillRect(w*volume-1, h*0.7, 2, h*0.2);
    }

    // ===== SIP =====
    async function initUA(){
      if(S.ua){ try{ await S.ua.stop(); }catch(_){ } S.ua=null; }
      try{
        S.ua = new SIP.UA({
          uri: `sip:${SIP_CONFIG.user}@${SIP_CONFIG.domain}`,
          transportOptions: { wsServers: [SIP_CONFIG.wss] },
          authorizationUser: SIP_CONFIG.user,
          password: SIP_CONFIG.pass,
          traceSip: true,
          rel100: SIP.C.supported.SUPPORTED,
          sessionDescriptionHandlerFactoryOptions: {
            constraints: { audio: true, video: false },
            peerConnectionOptions: {
              rtcConfiguration: { iceServers: [{urls:'stun:stun.l.google.com:19302'}], iceCandidatePoolSize: 4 }
            }
          }
        });

        S.ua.on('connected', ()=>{ setBadge('Online','bd-on'); setStatuses({ws:'Conectado'}); setPill('online','Online'); dlog('WS conectado'); });
        S.ua.on('disconnected', ()=>{ setBadge('Offline','bd-off'); setStatuses({ws:'Desconectado', reg:'—'}); setPill('', 'Offline'); dlog('WS desconectado'); });
        S.ua.on('registered',  ()=>{ setBadge('Registrado','bd-reg'); setStatuses({reg:'Registrado'}); setPill('registered','Registrado'); title.textContent=`Ramal ${SIP_CONFIG.user} — ${SIP_CONFIG.domain}`; extStatus.textContent=`${SIP_CONFIG.user}@${SIP_CONFIG.domain}`; dlog('Registrado'); });
        S.ua.on('registrationFailed', (e)=>{ setBadge('Falha','bd-err'); setStatuses({reg:`Falha (${e?.cause||'erro'})`}); dlog('Falha registro: '+(e?.cause||'')); });

        S.ua.on('invite', (incoming)=>{
          S.session = incoming;
          wireSession(incoming,true);
          const from = incoming.remoteIdentity?.uri?.toString() || 'Desconhecido';
          const to   = `${SIP_CONFIG.user}@${SIP_CONFIG.domain}`;
          setDisplays(from,'Tocando…'); setStatuses({call:'Tocando'});
          if (autoAnswer.checked) { tryAcceptIncoming(); } else { showPopup(from, to); }
        });

        await S.ua.start(); // registra imediatamente
      }catch(err){ setBadge('Erro','bd-err'); dlog('Erro UA: '+err); }
    }

    function wireSession(sess, incoming=false){
      sess.on('trackAdded', ()=>{
        try{
          const pc=sess.sessionDescriptionHandler?.peerConnection; if(!pc) return;
          const remoteStream=new MediaStream();
          pc.getReceivers().forEach(r=>{ if(r.track) remoteStream.addTrack(r.track); });

          // <audio> como fallback (mutado); som via AudioContext (ganho + meter)
          remoteAudio.srcObject=remoteStream; remoteAudio.muted = true;
          setupSpeakerGraph(remoteStream);

          dlog('Áudio remoto pronto');
        }catch(e){ dlog('trackAdded erro: '+e); }
      });
      sess.on('progress', ()=>{ setDisplays(undefined,'Chamando…'); setStatuses({call:'Chamando'}); });
      sess.on('accepted', ()=>{ startTimer(); setStatuses({call:'Em chamada'}); keypad.classList.remove('hidden'); });
      sess.on('bye', ()=> endSession('Chamada finalizada'));
      sess.on('failed', (e)=> endSession('Falhou: '+(e?.cause||'erro')));
    }

    function setupSpeakerGraph(remoteStream){
      if(!S.ctx) return;
      try{ S.spkSource && S.spkSource.disconnect(); }catch(_){}
      try{ S.spkGain && S.spkGain.disconnect(); }catch(_){}
      try{ S.spkAnalyser && S.spkAnalyser.disconnect(); }catch(_){}
      S.spkSource = S.ctx.createMediaStreamSource(remoteStream);
      S.spkGain   = S.ctx.createGain();
      S.spkAnalyser = S.ctx.createAnalyser();
      S.spkAnalyser.fftSize = 1024; S.spkAnalyser.smoothingTimeConstant = 0.85;

      S.spkSource.connect(S.spkGain);
      S.spkGain.connect(S.spkAnalyser);
      S.spkGain.connect(S.ctx.destination);

      const applySpkGain = ()=> { const v = rangeSpk.value/100; S.spkGain.gain.value = Math.pow(v, 2); };
      applySpkGain();
      rangeSpk.oninput = applySpkGain;

      startMetersLoop();
    }

    async function tryAcceptIncoming(){
      if(!S.session) return;
      try{
        if(!S.ctx) await ensureAudioGraph();
        S.session.accept({ sessionDescriptionHandlerOptions: { constraints:{ audio:true, video:false } } });
      }catch(e){ dlog('Erro ao atender: '+e); }
    }

    btnCall.addEventListener('click', async ()=>{
      if(!S.ua){ await initUA(); }
      if(!S.number){ dlog('Informe um número'); return; }
      try{
        if(!S.ctx) await ensureAudioGraph();
        const target=`sip:${S.number}@${SIP_CONFIG.domain}`;
        const s=S.ua.invite(target,{ sessionDescriptionHandlerOptions:{constraints:{audio:true,video:false}} });
        S.session=s; wireSession(s,false);
        dlog('Discando: '+S.number); setDisplays(S.number,'Chamando…'); setStatuses({call:'Chamando'});
        showPhone();
      }catch(e){ dlog('Erro ao discar: '+e); }
    });

    btnHang.addEventListener('click', ()=>{ if(S.session){ try{ S.session.bye(); }catch(e){ dlog('Erro bye: '+e);} } });
    muteSpkBtn.addEventListener('click', ()=>{ S.spkGain && (S.spkGain.gain.value = 0); rangeSpk.value=0; });
    muteMicBtn.addEventListener('click', ()=>{ if(S.micGain){ S.micGain.gain.value=0; rangeMic.value=0; } });

    // teclado físico
    window.addEventListener('keydown',(e)=>{
      if(e.key.match(/^[0-9*#]$/)){ if(S.session){ try{ S.session.dtmf(e.key);}catch(_){}} else { S.number+=e.key; setDisplays(S.number);} }
      if(e.key==='Backspace' && !S.session){ S.number=S.number.slice(0,-1); setDisplays(S.number); }
      if(e.key==='Enter'){ btnCall.click(); }
      if(e.key==='Escape'){ minimize(); }
    });

    // título/ramal
    title.textContent=`Ramal ${SIP_CONFIG.user} — ${SIP_CONFIG.domain}`;
    extStatus.textContent=`${SIP_CONFIG.user}@${SIP_CONFIG.domain}`;

    // inicia registro automaticamente e começa minimizado
    window.addEventListener('DOMContentLoaded', async ()=>{
      phone.classList.remove('show'); phone.classList.add('hide'); layer.classList.remove('active'); // minimizado
      await initUA();
      pillText.textContent = 'Conectando…';
    });
  })();
  </script>
</body>
</html>

<?php /**PATH /var/www/html/fttelecom/resources/views/teste.blade.php ENDPATH**/ ?>